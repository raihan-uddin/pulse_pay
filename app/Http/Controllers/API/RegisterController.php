<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     */
    public function register(Request $request): JsonResponse
    {
        $countryCode = str_replace(' ', '', $request->input('phonecode'));
        $phoneNo = str_replace(' ', '', $request->input('phone_number'));
        $username = $countryCode.$phoneNo;

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phonecode' => 'required',
            'phone_number' => 'required',
            'email' => 'email|unique:users', // 'email' must be in a valid format and unique in the 'users' table
            'username' => [
                'alpha_dash',
                Rule::unique('users')->where(function ($query) use ($username) {
                    return $query->where('username', $username);
                }),
            ], // 'username' is required, no spaces allowed, and must be unique in the 'users' table based on the concatenated 'country_code' and 'phone'
            'password' => 'required',
            'phonecode' => 'required',
            'c_password' => 'required|same:password',
        ]);

        // Set custom attribute names
        $validator->setAttributeNames([
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'username' => 'Username',
            'password' => 'Password',
            'c_password' => 'Password Confirmation',
        ]);

        // Set custom error messages
        $validator->setCustomMessages([
            'username.unique' => 'The :attribute is already taken. Please choose a different :attribute.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            // Replace the ':attribute' placeholder in each error message with 'Phone number'
            $errors = array_map(function ($error) {
                return str_replace(':attribute', 'Phone number', $error);
            }, $errors);

            return $this->sendError($errors, 400);
        }

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
