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
            'image' => 'storage/brand/001 Axe.jpg',
        ]);
        Brand::create([
            'name' => 'BRU',
            'slug' => 'bru',
            'image' => 'storage/brand/002 Bru.png',
        ]);
        Brand::create([
            'name' => 'CAMAY',
            'slug' => 'camay',
            'image' => 'storage/brand/003 Camay.png',
        ]);
        Brand::create([
            'name' => 'COMFORT',
            'slug' => 'comfort',
            'image' => 'storage/brand/004 Comfort.jpg',
        ]);
        Brand::create([
            'name' => 'DOVE',
            'slug' => 'dove',
            'image' => 'storage/brand/005 Dove.png',
        ]);
        Brand::create([
            'name' => 'PEARS',
            'slug' => 'pears',
            'image' => 'storage/brand/006 Pears.png',
        ]);
        Brand::create([
            'name' => 'SIMPLE',
            'slug' => 'simple',
            'image' => 'storage/brand/007 Simple.jpg',
        ]);
        Brand::create([
            'name' => 'SUNSILK',
            'slug' => 'sunsilk',
            'image' => 'storage/brand/008 Sunsilk2.png',

        ]);
        Brand::create([
            'name' => 'TRESEMME',
            'slug' => 'tresemme',
            'image' => 'storage/brand/009 Tresemme.png',
        ]);
        Brand::create([
            'name' => 'PERSIL',
            'slug' => 'persil',
            'image' => 'storage/brand/010 Persil.png',
        ]);
        Brand::create([
            'name' => 'CLEAR',
            'slug' => 'clear',
            'image' => 'storage/brand/012 CLEAR.jpg',
        ]);
    }
}
