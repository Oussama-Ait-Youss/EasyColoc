<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colocation;
use App\Models\Invitations;
use App\Models\User;

class InvitationsSeeder extends Seeder
{
    public function run(): void
    {
        $colocation = Colocation::first();
        $sender = User::first();

        if ($colocation && $sender) {
            // On génère 3 invitations en attente pour tester l'affichage
            Invitations::factory(3)->create([
                'colocation_id' => $colocation->id,
                'user_id' => $sender->id, // L'utilisateur qui invite
            ]);
        }
    }
}