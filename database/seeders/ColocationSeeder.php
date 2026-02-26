<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colocation;
use App\Models\User;

class ColocationSeeder extends Seeder
{
    public function run(): void
    {
        $colocation = Colocation::factory()->create([
            'name' => 'YouCode Villa'
        ]);

        $user = User::first() ?? User::factory()->create([
            'name' => 'Oussama',
            'email' => 'oussama@example.com',
        ]);

        $colocation->users()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now()
        ]);
    }
}