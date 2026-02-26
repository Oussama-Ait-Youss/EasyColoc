<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpensesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement([
                'Courses hebdomadaires', 'Facture Électricité', 'Achat Papier Toilette', 
                'Réparation Lavabo', 'Pizza Night', 'Produits ménagers', 'Loyer du mois'
            ]),
            'amount' => $this->faker->randomFloat(2, 5, 1500), // Entre 5 et 1500 DH
            'date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}