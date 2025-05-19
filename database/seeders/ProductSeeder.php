<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Product::create([
            'name' => 'Laptop HP',
            'code' => 'LAPTOP001',
            'price' => 7000,
            'stock' => 10,
            'category_id' => 1,
            'image_url' => 'https://via.placeholder.com/100',
        ]);
        Product::create([
            'name' => 'T-shirt Gris',
            'code' => 'TSHIRT001',
            'price' => 110,
            'stock' => 50,
            'category_id' => 2,
            'image_url' => 'https://via.placeholder.com/100',
        ]);
        Product::create([
            'name' => 'Chaussures Sport',
            'code' => 'SHOES001',
            'price' => 500,
            'stock' => 20,
            'category_id' => 3,
            'image_url' => 'https://via.placeholder.com/100',
        ]);
        Product::create([
            'name' => 'Souris Sans Fil',
            'code' => 'MOUSE001',
            'price' => 80,
            'stock' => 40,
            'category_id' => 4,
            'image_url' => 'https://via.placeholder.com/100',
        ]);
        Product::create([
            'name' => 'Casque Audio',
            'code' => 'HEADPHONE001',
            'price' => 150,
            'stock' => 30,
            'category_id' => 4,
            'image_url' => 'https://via.placeholder.com/100',
        ]);
        // Ajoute d'autres produits ici si besoin
    }
}
