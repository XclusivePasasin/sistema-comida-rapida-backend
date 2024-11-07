<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dishes')->insert([
            // Pupusas
            ['dish_name' => 'Pupusa de Queso', 'price' => 1.00, 'id_category' => 1],
            ['dish_name' => 'Pupusa de Frijol y Queso', 'price' => 1.25, 'id_category' => 1],
            ['dish_name' => 'Pupusa de Chicharrón', 'price' => 1.50, 'id_category' => 1],
            ['dish_name' => 'Pupusa de Loroco', 'price' => 1.50, 'id_category' => 1],
            ['dish_name' => 'Pupusa Mixta', 'price' => 1.75, 'id_category' => 1],
            
            // Drinks
            ['dish_name' => 'Coca-Cola', 'price' => 1.00, 'id_category' => 2],
            ['dish_name' => 'Pepsi', 'price' => 1.00, 'id_category' => 2],
            ['dish_name' => 'Licuado de Fresa', 'price' => 1.50, 'id_category' => 2],
            ['dish_name' => 'Limonada', 'price' => 1.25, 'id_category' => 2],
            ['dish_name' => 'Pilsener', 'price' => 1.50, 'id_category' => 2],
            
            // Sweets
            ['dish_name' => 'Pastel de Chocolate', 'price' => 2.50, 'id_category' => 3],
            ['dish_name' => 'Galletas', 'price' => 1.00, 'id_category' => 3],
            ['dish_name' => 'Brownie', 'price' => 1.75, 'id_category' => 3],
            ['dish_name' => 'Flan', 'price' => 1.25, 'id_category' => 3],
            ['dish_name' => 'Cheesecake', 'price' => 2.75, 'id_category' => 3],
            
            // Pizza
            ['dish_name' => 'Pizza de Pepperoni', 'price' => 5.00, 'id_category' => 4],
            ['dish_name' => 'Pizza Hawaiana', 'price' => 5.50, 'id_category' => 4],
            ['dish_name' => 'Pizza de Queso', 'price' => 4.50, 'id_category' => 4],
            ['dish_name' => 'Pizza de Vegetales', 'price' => 5.00, 'id_category' => 4],
            ['dish_name' => 'Pizza de Pollo', 'price' => 5.75, 'id_category' => 4],
            
            // Sandwiches
            ['dish_name' => 'Sándwich de Pollo', 'price' => 3.50, 'id_category' => 5],
            ['dish_name' => 'Sándwich de Jamón y Queso', 'price' => 3.00, 'id_category' => 5],
            ['dish_name' => 'Sándwich Vegano', 'price' => 4.00, 'id_category' => 5],
            ['dish_name' => 'Sándwich de Atún', 'price' => 3.75, 'id_category' => 5],
            ['dish_name' => 'Club Sándwich', 'price' => 4.50, 'id_category' => 5],
            
            // Salads
            ['dish_name' => 'Ensalada César', 'price' => 3.50, 'id_category' => 6],
            ['dish_name' => 'Ensalada de Pollo', 'price' => 4.00, 'id_category' => 6],
            ['dish_name' => 'Ensalada Griega', 'price' => 3.75, 'id_category' => 6],
            ['dish_name' => 'Ensalada de Atún', 'price' => 4.25, 'id_category' => 6],
            ['dish_name' => 'Ensalada Mixta', 'price' => 3.25, 'id_category' => 6],
            
            // Snacks
            ['dish_name' => 'Papas Fritas', 'price' => 1.50, 'id_category' => 7],
            ['dish_name' => 'Alitas de Pollo', 'price' => 4.50, 'id_category' => 7],
            ['dish_name' => 'Mozzarella Sticks', 'price' => 3.50, 'id_category' => 7],
            ['dish_name' => 'Nachos', 'price' => 3.00, 'id_category' => 7],
            ['dish_name' => 'Onion Rings', 'price' => 2.75, 'id_category' => 7],
            
            // Hamburgers
            ['dish_name' => 'Hamburguesa Clásica', 'price' => 4.00, 'id_category' => 8],
            ['dish_name' => 'Hamburguesa con Queso', 'price' => 4.50, 'id_category' => 8],
            ['dish_name' => 'Hamburguesa BBQ', 'price' => 5.00, 'id_category' => 8],
            ['dish_name' => 'Hamburguesa Doble', 'price' => 5.50, 'id_category' => 8],
            ['dish_name' => 'Hamburguesa Vegana', 'price' => 5.25, 'id_category' => 8],
            
            // Hotdogs
            ['dish_name' => 'Hotdog Clásico', 'price' => 2.00, 'id_category' => 9],
            ['dish_name' => 'Hotdog con Queso', 'price' => 2.50, 'id_category' => 9],
            ['dish_name' => 'Hotdog con Bacon', 'price' => 3.00, 'id_category' => 9],
            ['dish_name' => 'Hotdog Jumbo', 'price' => 3.50, 'id_category' => 9],
            ['dish_name' => 'Hotdog Especial', 'price' => 3.25, 'id_category' => 9],
            
            // Fries
            ['dish_name' => 'Papas Fritas Clásicas', 'price' => 1.50, 'id_category' => 10],
            ['dish_name' => 'Papas con Queso', 'price' => 2.00, 'id_category' => 10],
            ['dish_name' => 'Papas con Bacon', 'price' => 2.50, 'id_category' => 10],
            ['dish_name' => 'Papas Gajo', 'price' => 1.75, 'id_category' => 10],
            ['dish_name' => 'Curly Fries', 'price' => 2.25, 'id_category' => 10],
            
            // Sushi
            ['dish_name' => 'Rollo de Salmón', 'price' => 4.50, 'id_category' => 11],
            ['dish_name' => 'Rollo de Atún', 'price' => 4.75, 'id_category' => 11],
            ['dish_name' => 'California Roll', 'price' => 4.25, 'id_category' => 11],
            ['dish_name' => 'Tempura Roll', 'price' => 5.00, 'id_category' => 11],
            ['dish_name' => 'Ebi Roll', 'price' => 5.25, 'id_category' => 11],
            
            // Soups
            ['dish_name' => 'Sopa de Pollo', 'price' => 3.00, 'id_category' => 12],
            ['dish_name' => 'Sopa de Mariscos', 'price' => 4.50, 'id_category' => 12],
            ['dish_name' => 'Sopa de Res', 'price' => 3.75, 'id_category' => 12],
            ['dish_name' => 'Sopa de Vegetales', 'price' => 3.25, 'id_category' => 12],
            ['dish_name' => 'Sopa Miso', 'price' => 2.50, 'id_category' => 12],
        ]);
    }
}
