<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Youth Ministry',
                'Women\'s Fellowship',
                'Men\'s Fellowship',
                'Choir',
                'Prayer Warriors',
                'Bible Study Group',
            ]),
            'description' => $this->faker->sentence(),
            'meeting_day' => $this->faker->randomElement([
                'Sunday',
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
            ]),
            'location' => $this->faker->randomElement([
                'Main Hall',
                'Prayer Room',
                'Fellowship Hall',
                'Church Grounds',
            ]),
            'is_active' => true,
            'sort_order' => $this->faker->numberBetween(1, 100),
            'icon' => $this->faker->randomElement(['👥', '🙏', '📖', '🎵']),
            'category' => $this->faker->randomElement(['ministry', 'fellowship', 'service']),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
