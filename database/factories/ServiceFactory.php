<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $isFree = $this->faker->boolean(30); // 30% chance of being free
        
        return [
            'name' => $this->faker->randomElement([
                'Baptism',
                'Wedding',
                'Funeral',
                'Dedication',
                'Counseling',
                'Prayer Meeting',
            ]),
            'description' => $this->faker->sentence(),
            'schedule' => $this->faker->randomElement([
                'Sundays after service',
                'By appointment',
                'Saturdays 10am',
                'Weekdays 2pm',
            ]),
            'fee' => $isFree ? 0 : $this->faker->numberBetween(50000, 500000),
            'is_free' => $isFree,
            'currency' => 'UGX',
        ];
    }

    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'fee' => 0,
            'is_free' => true,
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'fee' => $this->faker->numberBetween(50000, 500000),
            'is_free' => false,
        ]);
    }
}
