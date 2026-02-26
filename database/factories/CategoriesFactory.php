<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
    public function definition(): array
    {
        return [
            // On pioche dans une liste de catégories communes pour une coloc
            'name' => $this->faker->randomElement([
                'Loyer', 'Courses', 'Électricité', 'Internet', 
                'Eau', 'Assurance', 'Produits ménagers', 'Loisirs'
            ]),
        ];
    }
}