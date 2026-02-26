<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvitationsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail(),
            'token' => Str::random(32),
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ];
    }
}