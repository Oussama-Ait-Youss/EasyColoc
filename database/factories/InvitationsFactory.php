<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitations>
 */
class InvitationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
    return [
        'email' => fake()->safeEmail(),
        'token' => Str::random(32),
        'status' => 'pending',
        'expires_at' => now()->addDays(7),
    ];
}
}
