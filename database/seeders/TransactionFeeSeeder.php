<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaction_fee')->delete();

        $fees = [
            // USD amount
            [
                'transaction_type' => 'deposit',
                'fee_type' => 'fixed',
                'currency_code' => 'USD',
                'amount' => 2.00,
                'percentage' => 0,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => 'Fixed fee for deposits',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'withdrawal',
                'fee_type' => 'percentage',
                'currency_code' => 'USD',
                'amount' => 0,
                'percentage' => 0.5,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => '0.5% fee for withdrawals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'transfer',
                'fee_type' => 'mixed',
                'currency_code' => 'USD',
                'amount' => 1.00,
                'percentage' => 1.5,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => '$1 + 1.5% of transfer amount',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // AED amount
            [
                'transaction_type' => 'deposit',
                'fee_type' => 'fixed',
                'currency_code' => 'AED',
                'amount' => 2.00,
                'percentage' => 0,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => 'Fixed fee for deposits',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'withdrawal',
                'fee_type' => 'percentage',
                'currency_code' => 'AED',
                'amount' => 0,
                'percentage' => 0.5,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => '0.5% fee for withdrawals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'transfer',
                'fee_type' => 'mixed',
                'currency_code' => 'AED',
                'amount' => 1.00,
                'percentage' => 1.5,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => '$1 + 1.5% of transfer amount',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // OMN amount
            [
                'transaction_type' => 'deposit',
                'fee_type' => 'fixed',
                'currency_code' => 'OMN',
                'amount' => 2.00,
                'percentage' => 0,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => 'Fixed fee for deposits',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'withdrawal',
                'fee_type' => 'percentage',
                'currency_code' => 'OMN',
                'amount' => 0,
                'percentage' => 0.5,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => '0.5% fee for withdrawals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_type' => 'transfer',
                'fee_type' => 'mixed',
                'currency_code' => 'OMN',
                'amount' => 1.00,
                'percentage' => 1.5,
                'min_amount' => 0,
                'max_amount' => 0,
                'description' => '$1 + 1.5% of transfer amount',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the data into the 'transaction_fees' table
        DB::table('transaction_fee')->insert($fees);
    }
}
