<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Susu Bubuk Ibu Hamil',
            'slug' => 'susu-bubuk-ibu-hamil',
            'short_description' => 'Susu bubuk berkualitas tinggi.',
            'description' => 'Produk susu bubuk untuk ibu hamil dan menyusui.',
            'image' => null,
            'is_featured' => true,
        ]);
    }
}