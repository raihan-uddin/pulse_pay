<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
