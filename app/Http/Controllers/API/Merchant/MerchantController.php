<?php

namespace App\Http\Controllers\API\Merchant;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

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
}
