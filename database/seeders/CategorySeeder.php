<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Category::insert([
            ['name' => 'Ordinateurs'],
            ['name' => 'T-shirts'],
            ['name' => 'Chaussures'],
            ['name' => 'Accessoires'],
        ]);
    }
}
