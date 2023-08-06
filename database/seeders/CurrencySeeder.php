<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::insert([
            [
                'currency_code' => 'USD',
                'currency_name' => 'US Dollar',
                'exchange_Rate' => '1.0000',
            ],
            [
                'currency_code' => 'BDT',
                'currency_name' => 'Bangladeshi Taka',
                'exchange_Rate' => 108.18,
            ],
            [
                'currency_code' => 'AED',
                'currency_name' => 'United Arab Emirates Dirham',
                'exchange_Rate' => 3.6720,
            ],
            [
                'currency_code' => 'OMR',
                'currency_name' => 'Omani Rial',
                'exchange_Rate' => 0.1020,
            ],
        ]);
    }
}
