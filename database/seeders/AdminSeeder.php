<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default admin user
        User::firstOrCreate(
            ['email' => 'ciscocherry6@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345'), // Change this password after first login!
                'role' => 'admin',
            ]
        );

        // Optional: Create another admin user
        User::firstOrCreate(
            ['email' => 'ceaser@gmail.com'],
            [
                'name' => 'Chaplain',
                'password' => Hash::make('ceaser@12345'), // Change this password after first login!
                'role' => 'admin',
            ]
        );

        // Optional: Create a regular user for testing
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('user@12345'),
                'role' => 'user',
            ]
        );
    }
}
