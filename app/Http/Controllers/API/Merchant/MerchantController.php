<?php

namespace App\Http\Controllers\API\Merchant;

use App\Http\Controllers\API\BaseController;
use App\Models\TrxLedger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MerchantController extends BaseController
{
    public function checkBalance(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Check if the user is authenticated
        if ($user) {
            $data = ['balance' => $user->balance];

            return $this->sendResponse($data);
        }
        // If the user is not authenticated, return an error response
        return $this->sendError(['message' => 'Unauthorized'], 401);
    }

    public function moneyTransfer(Request $request)
    {
        // Validate phone, amount, transaction_fee, and exchange_rate
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric', // Add appropriate validation rules for phone
            'amount' => 'required|numeric|min:0',
            'fee' => 'required|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', 400, $validator->errors());
        }

        // Get the authenticated user
        $user = $request->user();

        // Get the recipient user (customer) based on customer's ID from the request
        $phone = $request->input('phone'); // Replace with your input variable
        $recipient = User::where('phone_number', $phone)->where('country_code', $user->country_code)->where('currency_code', $user->currency_code)->first();

        // Get the amount to transfer from the request
        $amount = $request->input('amount');
        $fee = $request->input('fee');
        $exchange_rate = $request->input('exchange_rate');

        // Calculate the total amount to deduct (amount + transfer fee)
        $totalAmountToDeduct = $amount + $fee;

        // Check if the sender (this user) has sufficient balance
        if ($user->balance < $totalAmountToDeduct) {
            return $this->sendError('Insufficient Balance', 402);
        }

        // Perform the money transfer with transfer fee
        try {
            DB::beginTransaction();

            // Deduct the total amount (amount + transfer fee) from the sender's balance
            $user->balance -= $totalAmountToDeduct;
            if ($user->save()) {
                $hashedValue = strtoupper(substr(md5(uniqid(mt_rand(), true).'!salt!'), 0, 16));

                $transaction = TrxLedger::insertTrxLedger($hashedValue,
                    $user->id, 'transfer', 0, $amount,
                    $user->currency_code, $recipient->currency_code, $exchange_rate,
                    $fee, 0, 0, 0, 'Send Money', 'online'
                );

                // Add the amount to the recipient's balance
                $recipient->balance += $amount;
                if ($recipient->save()) {
                    $transaction = TrxLedger::insertTrxLedger($hashedValue,
                        $recipient->id, 'received', $amount, 0,
                        $user->currency_code, $recipient->currency_code, $exchange_rate,
                        $fee, 0, 0, 0, 'Received Money', 'online'
                    );
                }

            }

            DB::commit();
            $data = [
                'trx_no' => $hashedValue,
                'amount' => $amount,
                'fee' => $fee,
                'currency_code' => $user->currency_code,
                'exchange_rate' => $exchange_rate,
                'current_balance' => number_format($user->balance, 4),
            ];

            return $this->sendResponse('Money send successful.', $data);
        } catch (\Exception $e) {
            DB::rollback();

            return $this->sendError('Server error! Please try again.');
        }
    }
}
