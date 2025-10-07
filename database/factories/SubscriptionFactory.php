<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class SubscriptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'plan_name' => $this->faker->randomElement(['basic', 'premium']),
            'status' => $this->faker->randomElement(['active', 'canceled', 'expired']),
            'starts_at' => now()->subDays(rand(1, 30)),
            'ends_at' => now()->addDays(rand(15, 90)),
        ];
    }

    public function premium()
    {
        return $this->state(fn() => ['plan_name' => 'premium']);
    }

    public function cancelled()
    {
        return $this->state(fn() => ['status' => 'cancelled']);
    }
}
