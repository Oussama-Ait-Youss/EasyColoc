<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colocation;
use App\Models\Categories;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $colocation = Colocation::first();

        if ($colocation) {
            $defaultCategories = ['Loyer', 'Courses', 'Électricité', 'Internet'];

            foreach ($defaultCategories as $name) {
                Categories::create([
                    'name' => $name,
                    'colocation_id' => $colocation->id
                ]);
            }

            Categories::factory(2)->create([
                'colocation_id' => $colocation->id
            ]);
        }
    }
}