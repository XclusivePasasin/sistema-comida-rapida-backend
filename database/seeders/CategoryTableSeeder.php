<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id_category' => 1, 'name' => 'Pupusas'],
            ['id_category' => 2, 'name' => 'Drinks'],
            ['id_category' => 3, 'name' => 'Sweets'],
            ['id_category' => 4, 'name' => 'Pizza'],
            ['id_category' => 5, 'name' => 'Sandwiches'],
            ['id_category' => 6, 'name' => 'Salads'],
            ['id_category' => 7, 'name' => 'Snacks'],
            ['id_category' => 8, 'name' => 'Hamburgers'],
            ['id_category' => 9, 'name' => 'Hotdogs'],
            ['id_category' => 10, 'name' => 'Fries'],
            ['id_category' => 11, 'name' => 'Sushi'],
            ['id_category' => 12, 'name' => 'Soups'],
        ]);
    }
}
