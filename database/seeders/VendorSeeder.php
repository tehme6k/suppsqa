<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::create([
            'name' => 'Vendor 1',
            'website' => 'www.vendor1.com',
            'email' => 'vendor1@email.com',
            'phone_number' => '6193905358',
            'contact_name' => 'James Bond'
        ]);

        Vendor::create([
            'name' => 'Vendor 2',
            'website' => 'www.vendor2.com',
            'email' => 'vendor2@email.com',
            'phone_number' => '9288677179',
            'contact_name' => 'Bob Dole'
        ]);

        Vendor::create([
            'name' => 'Vendor 3',
        ]);

        Vendor::create([
            'name' => 'Vendor 4',
        ]);

        Vendor::create([
            'name' => 'Vendor 5',
        ]);

        Vendor::create([
            'name' => 'Vendor 6',
        ]);

        Vendor::create([
            'name' => 'Vendor 7',
        ]);

        Vendor::create([
            'name' => 'Vendor 8',
        ]);

        Vendor::create([
            'name' => 'Vendor 9',
        ]);

        Vendor::create([
            'name' => 'Vendor 10',
        ]);

        Vendor::create([
            'name' => 'Vendor 11',
        ]);

        Vendor::create([
            'name' => 'Vendor 12',
        ]);
    }
}
