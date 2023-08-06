<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456789');

        User::insert([
            [
                'first_name' => 'Pulse',
                'last_name' => 'Tech',
                'email' => 'info@pulsetechltde.com',
                'username' => 'pulsetech',
                'country_code' => 'BD',
                'phonecode' => '+880',
                'phone_number' => '1320000000',
                'account_type' => 'admin',
                'password' => $password,
                'gender' => 'male',
                'currency_code' => 'USD',
                'balance' => 10000000000,
                'point' => 0,
                'status' => 'active',
            ],
            [
                'first_name' => 'Rasel',
                'last_name' => 'Khan',
                'email' => 'rasel@pulsetechltde.com',
                'country_code' => 'OM',
                'phonecode' => '+880',
                'phone_number' => '1322800304',
                'username' => '+8801322800304',
                'account_type' => 'merchant',
                'password' => $password,
                'gender' => 'male',
                'currency_code' => 'USD',
                'balance' => 50000,
                'point' => 0,
                'status' => 'active',
            ],
            [
                'name' => 'Dominic',
                'last_name' => 'Gomes',
                'email' => 'dominic@pulsetechltde.com',
                'country_code' => 'OM',
                'phonecode' => '+880',
                'phone_number' => '1676115478',
                'username' => '+8801676115478',
                'account_type' => 'user',
                'password' => $password,
                'gender' => 'male',
                'currency_code' => 'USD',
                'balance' => 10000,
                'point' => 0,
                'status' => 'active',
            ],
        ]);
    }
}
