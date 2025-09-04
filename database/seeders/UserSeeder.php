<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mothy',
            'email' => 'mothy@email.com',
            'password' => bcrypt('altoidz012'), // Hash the password
        ]);

        User::create([
            'name' => 'Timz',
            'email' => 'moshimoshi6k@gmail.com',
            'password' => bcrypt('altoidz012'),
        ]);
    }
}
