<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->delete();

        $countries = [
            [
                'iso' => 'US',
                'name' => 'United States',
                'iso3' => 'USA',
                'numcode' => '840',
                'phonecode' => '+1',
                'currency_code' => 'USD',
                'currency_name' => 'US Dollar',
                'exchange_Rate' => '1.0000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iso' => 'BD',
                'name' => 'Bangladesh',
                'iso3' => 'BGD',
                'numcode' => '50',
                'phonecode' => '+880',
                'currency_code' => 'BDT',
                'currency_name' => 'Bangladeshi Taka',
                'exchange_Rate' => 108.18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iso' => 'OM',
                'name' => 'Oman',
                'iso3' => 'OMN',
                'numcode' => '512',
                'phonecode' => '+968',
                'currency_code' => 'OMR',
                'currency_name' => 'Omani Rial',
                'exchange_Rate' => 0.1020,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'iso' => 'AE',
                'name' => 'United Arab Emirates',
                'iso3' => 'ARE',
                'numcode' => '784',
                'phonecode' => '+971',
                'currency_code' => 'AED',
                'currency_name' => 'United Arab Emirates Dirham',
                'exchange_Rate' => 3.6720,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('countries')->insert($countries);
    }
}
