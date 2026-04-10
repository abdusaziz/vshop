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
            'name' => 'SKIN CARE',
            'slug' => 'skin-care',
        ]);
        Category::create([
            'name' => 'BEVERAGES',
            'slug' => 'beverages',
        ]);
        Category::create([
            'name' => 'FABRIC ENHANCERS',
            'slug' => 'fabric-enhancers',
        ]);
        Category::create([
            'name' => 'SKIN CLEANSING',
            'slug' => 'skin-cleansing',
        ]);
        Category::create([
            'name' => 'DEODORANTS & FRAGRANCES',
            'slug' => 'deodorants-frAGRANCES',
        ]);
        Category::create([
            'name' => 'ORAL CARE',
            'slug' => 'oral-care',
        ]);
        Category::create([
            'name' => 'HAIR CARE',
            'slug' => 'hair-care',
        ]);
        Category::create([
            'name' => 'FABRIC CLEANING',
            'slug' => 'fabric-cleaning',
        ]);
        Category::create([
            'name' => 'HOME & HYGIENE',
            'slug' => 'home-hygiene',
        ]);
    }
}
