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
            ['iso' => 'BD', 'name' => 'Bangladesh', 'iso3' => 'BGD', 'numcode' => '50', 'phonecode' => '880'],
            ['iso' => 'OM', 'name' => 'Oman', 'iso3' => 'OMN', 'numcode' => '512', 'phonecode' => '968'],
            ['iso' => 'AE', 'name' => 'United Arab Emirates', 'iso3' => 'ARE', 'numcode' => '784', 'phonecode' => '971'],
        ];

        DB::table('countries')->insert($countries);
    }
}
