<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use App\Models\Giving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders in the correct order
        $this->call([
            AdminSeeder::class,
            MembersTableSeeder::class,
            GivingsTableSeeder::class,
        ]);
    }
}
