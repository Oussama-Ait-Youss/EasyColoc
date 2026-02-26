<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colocation;
use App\Models\Payments;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $colocation = Colocation::with('users')->first();

        if ($colocation && $colocation->users->count() >= 2) {
            $users = $colocation->users;

            // On crée 5 paiements aléatoires entre les membres
            for ($i = 0; $i < 5; $i++) {
                // On mélange les utilisateurs pour en prendre deux au hasard
                $pair = $users->random(2);
                
                Payments::factory()->create([
                    'colocation_id' => $colocation->id,
                    'from_user_id'  => $pair[0]->id, // Le débiteur
                    'to_user_id'    => $pair[1]->id, // Le créancier
                ]);
            }
        }
    }
}