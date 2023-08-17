<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxLedger extends Model
{
    use HasFactory;

    protected $table = 'trx_ledger';


    public static function insertTrxLedger(
        $trx_no, $user_id, $transaction_type, $cr_amount, $dr_amount,
        $source_currency_code, $target_currency_code, $exchange_rate,
        $transaction_fee, $commission, $point, $vat, $description, $transaction_method
    ): ?TrxLedger
    {
        try {
            // Create a new transaction entry in the ledger table
            $transaction = new TrxLedger();
            $transaction->user_id = $user_id;
            $transaction->trx_no = $trx_no;
            $transaction->transaction_type = $transaction_type;
            $transaction->cr_amount = $cr_amount;
            $transaction->dr_amount = $dr_amount;
            $transaction->source_currency_code = $source_currency_code;
            $transaction->target_currency_code = $target_currency_code;
            $transaction->exchange_rate = $exchange_rate;
            $transaction->transaction_fee = $transaction_fee;
            $transaction->commission = $commission;
            $transaction->point = $point;
            $transaction->vat = $vat;
            $transaction->description = $description;
            $transaction->transaction_method = $transaction_method;
            if($transaction->save()){
                info("saved");
            }

            return $transaction;
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error inserting transaction ledger: ' . $e->getMessage());

            // Handle the error as needed, e.g., throw an exception or return false
            return null;
        }
    }
}
