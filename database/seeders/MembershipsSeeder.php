<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colocation;
use App\Models\User;
use App\Models\Memberships;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $colocation = Colocation::first();

        if ($colocation) {
            // Créer 3 nouveaux colocataires
            $newUsers = User::factory(3)->create();

            foreach ($newUsers as $user) {
                // On utilise attach() sur la relation définie dans le modèle Colocation
                $colocation->users()->attach($user->id, [
                    'role' => 'member',
                    'joined_at' => now()->subDays(rand(1, 30)),
                    'reputation' => rand(80, 100),
                ]);
            }
        }
    }
}