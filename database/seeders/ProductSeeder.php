<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
            'description' => 'High performance laptop',
            'price' => 999.99,
            'stock_quantity' => 10,
            'is_available' => true
        ]);

        Product::create([
            'name' => 'Smartphone',
            'description' => 'Latest smartphone model',
            'price' => 699.99,
            'stock_quantity' => 25,
            'is_available' => true
        ]);

        Product::create([
            'name' => 'Headphones',
            'description' => 'Wireless noise-cancelling headphones',
            'price' => 199.99,
            'stock_quantity' => 50,
            'is_available' => true
        ]);
    }
}
