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
        Category::create(['name' => 'Active']);
        Category::create(['name' => 'Flavor']);
        Category::create(['name' => 'Color']);
        Category::create(['name' => 'Lid']);
        Category::create(['name' => 'Bottle']);
        Category::create(['name' => 'Scoop']);
        Category::create(['name' => 'Dessicant']);
    }
}
