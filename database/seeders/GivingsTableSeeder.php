<?php

namespace Database\Seeders;

use App\Models\Giving;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GivingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have members to associate givings with
        $memberCount = Member::count();
        
        if ($memberCount === 0) {
            $this->command->warn('No members found. Creating some members first...');
            Member::factory()->count(10)->create();
        }

        // Create member givings (80% of givings)
        $this->command->info('Creating member givings...');
        Giving::factory()->count(40)->create();

        // Create guest givings (20% of givings)
        $this->command->info('Creating guest givings...');
        Giving::factory()->guest()->count(10)->create();

        $this->command->info('Created 50 giving records successfully!');
    }
}