<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'title' => 'AXE DEO AER APOLLO EAW 12X150ML',
            'price' => 290.96,
            'quantity' => 50,
            'category_id' => 1,
            'brand_id' => 1,
            'description' => 'This is a sample product description of AXE Body Spray.',
        ]);
    }
}
