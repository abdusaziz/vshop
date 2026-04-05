<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => 'AXE',
            'slug' => 'axe',
        ]);
        Brand::create([
            'name' => 'BRU',
            'slug' => 'bru',
        ]);
        Brand::create([
            'name' => 'CAMAY',
            'slug' => 'camay',
        ]);
        Brand::create([
            'name' => 'DOVE',
            'slug' => 'dove',
        ]);
    }
}
