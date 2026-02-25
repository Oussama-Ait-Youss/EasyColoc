<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;
use App\Models\Expenses;
use App\Models\Memberships;
use App\Models\Payments;
use App\Models\Colocation;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    
    public function run(): void {
    $admin = User::factory()->create([
        'name' => 'Oussama Ait Youss',
        'email' => 'admin@easycoloc.com',
        'is_admin' => true,
    ]);

    $coloc = Colocation::factory()->create(['name' => 'YouCode Arena House']);

    $coloc->memberships()->create([
        'user_id' => $admin->id,
        'role' => 'owner',
    ]);

    $members = User::factory(3)->create();
    foreach ($members as $member) {
        $coloc->memberships()->create([
            'user_id' => $member->id,
            'role' => 'member',
        ]);
    }

    $category = Categories::create(['colocation_id' => $coloc->id, 'name' => 'Courses']);
    
    Expenses::create([
        'colocation_id' => $coloc->id,
        'user_id' => $admin->id, 
        'category_id' => $category->id,
        'amount' => 120.00,
        'title' => 'Courses Carrefour',
        'date' => now(),
    ]);

    Payments::create([
        'colocation_id' => $coloc->id,
        'from_user_id' => $members[0]->id,
        'to_user_id' => $admin->id,
        'amount' => 30.00,
        'paid_at' => now(),
    ]);
}
}
