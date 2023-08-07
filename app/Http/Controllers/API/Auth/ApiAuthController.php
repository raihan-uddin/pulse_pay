<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;

class ApiAuthController extends BaseController
{
    /**
     * Register api
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $countryCode = str_replace(' ', '', $request->input('phonecode'));
            $phoneNo = str_replace(' ', '', $request->input('phone_number'));

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phonecode' => 'required|string|max:10',
                'phone_number' => 'required|string|max:20|unique:users',
                'account_type' => 'required|in:merchant,user',
                'email' => 'email|unique:users', // 'email' must be in a valid format and unique in the 'users' table
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return $this->handleValidationException(new ValidationException($validator));
            }

            $user = User::create($request->all());

            $success['token'] = $user->createToken('PulsePay')->accessToken;
            $success['name'] = sprintf('%s %s', $user->first_name, $user->last_name);

            return $this->sendResponse($success, 'User registered successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Login api
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->sendError(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::where('username', $request->username)->where('status', 'active')->where('account_type', 'user')->first();

        if ($user) {

            //remove all previous tokens
            $user->tokens()->delete();

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('PulsePay')->accessToken;
                $response = [
                    'token' => $token,
                    'name' => sprintf('%s %s', $user->first_name, $user->last_name),
                    'account_type' => $user->account_type,
                    'currency_code' => $user->currency_code,
                ];

                return $this->sendResponse($response, 'User login successfully.');
            } else {
                $response = ['message' => 'Password mismatch'];

                return $this->sendError($response, 422);

            }
        } else {
            $response = ['message' => 'User does not exist'];

            return $this->sendError($response, 422);
        }
    }

    /**
     * Login api
     */
    public function merchantLogin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->sendError(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::where('username', $request->username)->where('status', 'active')->where('account_type', 'merchant')->first();

        if ($user) {
            //remove all previous tokens
            $user->tokens()->delete();
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('PulsePay')->accessToken;
                $response = [
                    'token' => $token,
                    'name' => sprintf('%s %s', $user->first_name, $user->last_name),
                    'account_type' => $user->account_type,
                    'currency_code' => $user->currency_code,
                ];

                return $this->sendResponse($response, 'Merchant login successfully.');
            } else {
                $response = ['message' => 'Password mismatch'];

                return $this->sendError($response, 422);

            }
        } else {
            $response = ['message' => 'User does not exist'];

            return $this->sendError($response, 422);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();

        return $this->sendResponse(null, 'You have been successfully logged out!');
    }
}
