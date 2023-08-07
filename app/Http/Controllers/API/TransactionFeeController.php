<?php

namespace App\Http\Controllers\API;

use App\Models\TransactionFee;
use Illuminate\Http\Request;

class TransactionFeeController extends BaseController
{
    public function fees(Request $request)
    {
        $fees = TransactionFee::getFeesByUserCurrency();
        return $this->sendResponse($fees);
    }
}
