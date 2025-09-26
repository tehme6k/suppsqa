<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $randomUserId = User::inRandomOrder()->first()->id;
        // $randomProductId = User::inRandomOrder()->first()->id;
        // $randomVendorId = Vendor::inRandomOrder()->first()->id;
        $faker = Faker::create();
        Inventory::create([
            'product_id' => '1',
            'quarantine_user' => User::inRandomOrder()->first()->id,
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'lot_number' => 'abc123',
            'facility_location' => 'quarantine',
            'adjustment_type' => 'receive',
            'quantity' => '300',
            'uom' => 'kg',
            'expiration_date' => $faker->dateTimeBetween('+1 month', '+1 year')
        ]);


        

        Inventory::create([
            'product_id' => '1',
            'quarantine_user' => User::inRandomOrder()->first()->id,
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'lot_number' => 'abc123',
            'facility_location' => 'quarantine',
            'adjustment_type' => 'receive',
            'quantity' => '600',
            'uom' => 'kg',
            'expiration_date' => $faker->dateTimeBetween('+1 month', '+1 year')
        ]);


        Inventory::create([
            'product_id' => '1',
            'quarantine_user' => User::inRandomOrder()->first()->id,
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'lot_number' => 'abc123',
            'facility_location' => 'quarantine',
            'adjustment_type' => 'receive',
            'quantity' => '100',
            'uom' => 'kg',
            'expiration_date' => $faker->dateTimeBetween('+1 month', '+1 year')
        ]);


        Inventory::create([
            'product_id' => 11,
            'quarantine_user' => User::inRandomOrder()->first()->id,
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'lot_number' => 'xyz567',
            'facility_location' => 'quarantine',
            'adjustment_type' => 'receive',
            'quantity' => '700',
            'uom' => 'kg',
            'expiration_date' => $faker->dateTimeBetween('+1 month', '+1 year')
        ]);


    }
}
