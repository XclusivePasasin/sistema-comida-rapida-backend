<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tables')->insert([
            ['id_table' => 1, 'table_number' => '1 - MESA', 'status' => 'A'],
            ['id_table' => 2, 'table_number' => '2 - MESA', 'status' => 'A'],
            ['id_table' => 3, 'table_number' => '3 - MESA', 'status' => 'A'],
            ['id_table' => 4, 'table_number' => '4 - MESA', 'status' => 'A'],
            ['id_table' => 5, 'table_number' => '5 - MESA', 'status' => 'A'],
        ]);
    }
}
