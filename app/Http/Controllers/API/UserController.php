<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function searchCustomer(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:5',
        ]);

        $searchTerm = $request->input('phone');
        $user = User::searchCustomer($searchTerm);

        if ($user) {
            return $this->sendResponse($user);
        } else {
            return $this->sendError('User not found.', [], 404);
        }
    }
}
