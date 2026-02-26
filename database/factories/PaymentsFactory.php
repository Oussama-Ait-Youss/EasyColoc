<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 50, 1000),
            'paid_at' => now()->subDays(rand(1, 15)),
        ];
    }
}