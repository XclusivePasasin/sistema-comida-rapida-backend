<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        [
            'password' => Hash::make('demo'),
            'role' => 'A',
            'username' => 'Administrator',
            'employee_name' => 'Fast Food - Administrator',
            'phone' => '25252525'
        ],
        [
            'password' => Hash::make('demo'),
            'role' => 'C',
            'username' => 'Cashier',
            'employee_name' => 'Fast Food - Cashier',
            'phone' => '25252525'
        ],
        [
            'password' => Hash::make('demo'),
            'role' => 'M',
            'username' => 'Waiter',
            'employee_name' => 'Fast Food - Waiter',
            'phone' => '25252525'
        ]
    ]);
    }
}
