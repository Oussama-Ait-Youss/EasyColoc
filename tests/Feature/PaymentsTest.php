<?php

namespace Tests\Feature;

use App\Models\Colocation;
use App\Models\Memberships;
use App\Models\Payments;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_record_payment_from_coloc_member()
    {
        // create colocation and two users with membership
        $coloc = Colocation::factory()->create();
        $owner = User::factory()->create();
        $member = User::factory()->create();

        Memberships::create([
            'user_id' => $owner->id,
            'colocation_id' => $coloc->id,
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        Memberships::create([
            'user_id' => $member->id,
            'colocation_id' => $coloc->id,
            'role' => 'member',
            'joined_at' => now(),
        ]);

        // owner logs in and creates a payment from member to him
        $response = $this->actingAs($owner)->post(route('payments.store'), [
            'amount' => 50,
            'from_user_id' => $member->id,
            'colocation_id' => $coloc->id,
        ]);

        $response->assertRedirect(route('payments.index'));
        $this->assertDatabaseHas('payments', [
            'amount' => 50,
            'from_user_id' => $member->id,
            'to_user_id' => $owner->id,
            'colocation_id' => $coloc->id,
        ]);
    }
}
