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
        Brand::create(['name' => 'Brand A']);
        Brand::create(['name' => 'Brand B']);
        Brand::create(['name' => 'Brand C']);
        Brand::create(['name' => 'Brand D']);
        Brand::create(['name' => 'Brand E']);
        Brand::create(['name' => 'Brand F']);
        Brand::create(['name' => 'Brand G']);
    }
}
