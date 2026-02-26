<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ColocationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' House',
            'invite_token' => Str::random(32),
            'status' => 'active',
        ];
    }
}