<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'role' => $this->faker->randomElement(['member', 'admin']),
            'joined_at' => now(),
            'is_banned' => false,
            'reputation' => 100,
        ];
    }
}