<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction_fee';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    // Other transaction fee model code...

    public static function getFeesByUserCurrency()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the user's currency code
        $userCurrency = $user->currency_code;
        info($userCurrency);

        return static::whereCurrencyCode($userCurrency)->get();
    }

    public function scopeWhereCurrencyCode($query, $currencyCode)
    {
        return $query->where('currency_code', $currencyCode);
    }
}
