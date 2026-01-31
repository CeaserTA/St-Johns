<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class MemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Automatically creates linked user

            'full_name' => $this->faker->name(),
            'date_of_birth' => $this->faker->date('Y-m-d', '2005-01-01'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'marital_status' => $this->faker->randomElement(['single', 'married', 'divorced', 'widowed']),

            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),

            'date_joined' => $this->faker->dateTimeBetween('-10 years', 'now'),

            'cell' => $this->faker->randomElement([
                'north',
                'east', 
                'south',
                'west',
            ]),

            'profile_image' => null,
        ];
    }
}
