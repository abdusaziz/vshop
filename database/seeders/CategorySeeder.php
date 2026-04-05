<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'DEODORANTS & FRAGRANCES',
            'slug' => 'DEODORANTS-FRAGRANCES',
        ]);
        Category::create([
            'name' => 'BEVERAGES',
            'slug' => 'BEVERAGES',
        ]);
        Category::create([
            'name' => 'SKIN CLEANSING',
            'slug' => 'SKIN-CLEANSING',
        ]);
        Category::create([
            'name' => 'HAIR CARE',
            'slug' => 'HAIR-CARE',
        ]);
    }
}
