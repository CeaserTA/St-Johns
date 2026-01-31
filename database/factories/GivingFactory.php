<?php

namespace Database\Factories;

use App\Models\Giving;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GivingFactory extends Factory
{
    protected $model = Giving::class;

    public function definition(): array
    {
        // Get a random member (will be null for guest givings)
        $member = Member::inRandomOrder()->first();
        
        $amount = $this->faker->numberBetween(10000, 500000);
        $processingFee = $this->faker->randomElement([0, $amount * 0.01]); // Some have processing fees
        $netAmount = $amount - $processingFee;

        return [
            'member_id' => $member?->id,
            'guest_name' => null,
            'guest_email' => null,
            'guest_phone' => null,

            'giving_type' => $this->faker->randomElement(['tithe', 'offering', 'donation', 'special_offering']),
            'amount' => $amount,
            'currency' => 'UGX',
            'purpose' => $this->faker->randomElement([
                'General Fund', 
                'Building Fund', 
                'Missions', 
                'Youth Ministry',
                'Children Ministry',
                'Outreach Program',
                null
            ]),
            'notes' => $this->faker->optional(0.3)->sentence(),

            'payment_method' => $this->faker->randomElement(['cash', 'mobile_money', 'bank_transfer']),
            'transaction_reference' => $this->faker->optional(0.8)->bothify('TXN########'),
            'payment_provider' => $this->faker->randomElement(['MTN', 'Airtel', null]),
            'payment_account' => $this->faker->optional(0.7)->numerify('077#######'),

            'status' => $this->faker->randomElement(['completed', 'pending', 'failed']),
            'payment_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'confirmed_at' => $this->faker->optional(0.8)->dateTimeBetween('-2 years', 'now'),
            'confirmed_by' => $this->faker->optional(0.8)->numberBetween(1, 3), // Admin user IDs

            'receipt_number' => 'RCPT-' . strtoupper($this->faker->bothify('#####')),
            'receipt_sent' => $this->faker->boolean(70), // 70% chance receipt was sent
            'processing_fee' => $processingFee,
            'net_amount' => $netAmount,

            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'metadata' => null,
        ];
    }

    /**
     * Create a guest giving (no member association)
     */
    public function guest(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'member_id' => null,
                'guest_name' => $this->faker->name(),
                'guest_email' => $this->faker->optional(0.7)->safeEmail(),
                'guest_phone' => $this->faker->optional(0.8)->numerify('077#######'),
            ];
        });
    }

    /**
     * Create a completed giving
     */
    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
                'confirmed_at' => now(),
                'confirmed_by' => 1,
                'receipt_sent' => true,
            ];
        });
    }

    /**
     * Create a pending giving
     */
    public function pending(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'confirmed_at' => null,
                'confirmed_by' => null,
                'receipt_sent' => false,
            ];
        });
    }
}
