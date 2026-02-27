<?php

namespace Tests\Feature;

use App\Models\Colocation;
use App\Models\Memberships;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ColocationMembershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_shows_colocation_and_role(): void
    {
        $user = User::factory()->create();
        $coloc = Colocation::factory()->create();

        // attach user as member
        $membership = Memberships::create([
            'user_id' => $user->id,
            'colocation_id' => $coloc->id,
            'role' => 'member',
            'joined_at' => now(),
        ]);

        // sanity check that record exists in the database
        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id,
            'colocation_id' => $coloc->id,
            'role' => 'member',
            'left_at' => null,
        ]);

        // sanity check that relationship helper works outside HTTP
        $this->assertNotNull($user->activeColocation(), 'activeColocation should return a model after membership creation');

        $response = $this->actingAs($user)->get('/profile');

        $response->assertOk();
        $response->assertSeeText('Colocation actuelle');
        $response->assertSeeText($coloc->name);
        $response->assertSeeText('member');
    }

    public function test_member_can_leave_colocation_from_members_page(): void
    {
        $user = User::factory()->create();
        $coloc = Colocation::factory()->create();

        // create an owner so activeColocation() will return the correct pivot for the user
        $owner = User::factory()->create();
        Memberships::create([
            'user_id' => $owner->id,
            'colocation_id' => $coloc->id,
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        $membership = Memberships::create([
            'user_id' => $user->id,
            'colocation_id' => $coloc->id,
            'role' => 'member',
            'joined_at' => now(),
        ]);

        // load members page and make sure leave button is visible (no errors)
        $response = $this->actingAs($user)->get(route('memberships.index'));
        $response->assertOk();
        $response->assertSee('Quitter');

        // perform leave
        $leave = $this->actingAs($user)->delete(route('memberships.destroy', $membership->id));
        $leave->assertRedirect(route('memberships.index'));
        $leave->assertSessionHas('success', 'Vous avez quitté la colocation avec succès.');

        // membership should have been marked with a left_at timestamp
        $membership->refresh();
        $this->assertNotNull($membership->left_at, 'Membership left_at should be populated after leaving');
    }
}