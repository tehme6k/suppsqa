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
        Category::create(['name' => 'Active', 'uom' => 'kg']);
        Category::create(['name' => 'Flavor', 'uom' => 'kg']);
        Category::create(['name' => 'Color', 'uom' => 'kg']);
        Category::create(['name' => 'Lid', 'uom' => 'ea']);
        Category::create(['name' => 'Bottle', 'uom' => 'ea']);
        Category::create(['name' => 'Scoop', 'uom' => 'ea']);
        Category::create(['name' => 'Dessicant', 'uom' => 'ea']);
        Category::create(['name' => 'Label', 'uom' => 'ea']);
        Category::create(['name' => 'Box', 'uom' => 'ea']);
        Category::create(['name' => 'Capsule', 'uom' => 'ea']);
    }
}
