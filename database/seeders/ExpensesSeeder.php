<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colocation;
use App\Models\Categories;
use App\Models\Expenses;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $colocation = Colocation::with(['users', 'categories'])->first();

        if ($colocation && $colocation->users->isNotEmpty() && $colocation->categories->isNotEmpty()) {
            
            for ($i = 0; $i < 15; $i++) {
                Expenses::factory()->create([
                    'colocation_id' => $colocation->id,
                    'user_id'       => $colocation->users->random()->id,
                    'category_id'   => $colocation->categories->random()->id,
                ]);
            }
        }
    }
}