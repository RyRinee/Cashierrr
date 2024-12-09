<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Petit',
            'email' => 'petitmaharaya@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'address' => 'Soekorno',
            'notelp' => '082141793277',
            'image' => 'Admin1.png',
        ]);
        User::create([
            'name' => 'Ryan',
            'email' => 'ryanputra@gmail.com',
            'password' => Hash::make('cashier'),
            'role' => 'cashier',
            'address' => 'Semboro-Babatan',
            'notelp' => '085823623958',
            'image' => 'Admin1.png',
        ]);
        User::create([
            'name' => 'Zidan Ganteng',
            'email' => 'zidankuat@gmail.com',
            'password' => Hash::make('employee'),
            'role' => 'employee',
            'address' => 'Semboro-Babatan',
            'notelp' => '089505365581',
            'image' => 'user2.jpg',  
        ]);
    }
}
