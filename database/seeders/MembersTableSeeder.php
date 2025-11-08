<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory; 

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $faker = Factory::create();

        $members = [];

        for ($i = 0; $i < 50; $i++) {
            $members[] = [
                'firstname' => $faker->firstname,
                'lastname'  => $faker->lastname,
                'gender'    => $faker->randomElement(['Male', 'Female']),
                'phone'     => $faker->phoneNumber,
                'email'     => $faker->unique()->safeEmail,
                'address'   => $faker->address,
                'created_at'=> now(),
                'updated_at'=> now(),
            ];
        }
         DB::table('members')->insert($members);
    }
}
