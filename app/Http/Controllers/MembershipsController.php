<?php

namespace App\Http\Controllers;

use App\Models\Memberships;
use App\Models\User;
use App\Models\Invitations;
use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMembershipsRequest;
use Illuminate\Support\Facades\Auth;

class MembershipsController extends Controller
{
    
    public function index()
{
$colocation = Auth::user()->activeColocation();
    if (!$colocation) {
        return redirect()->route('colocation.create')
            ->with('error', 'Vous devez appartenir à une colocation pour voir les membres.');
    }


    $members = $colocation->users()
        ->wherePivot('left_at', null)
        ->get();

    return view('memberships.index', compact('members', 'colocation'));
}

   
    public function store(StoreMembershipsRequest $request)
    {
        $invitation = Invitations::where('token', $request->token)
            ->where('status', 'pending')
            ->firstOrFail();

        Memberships::create([
            'user_id'       => Auth::id(),
            'colocation_id' => $invitation->colocation_id,
            'role'          => 'member', 
            'joined_at'     => now(),
        ]);

        $invitation->update(['status' => 'accepted']);

        return redirect()->route('colocation.index')
            ->with('success', 'Félicitations ! Vous avez rejoint la colocation.');
    }
    public function leave($colocationId)
{
    $user = auth()->user();
    
    
    $user->colocations()->updateExistingPivot($colocationId, [
        'left_at' => now()
    ]);

    return redirect()->route('colocation.create')
        ->with('success', 'Vous avez quitté la colocation avec succès.');
}

  
    public function destroy(Memberships $membership)
    {
        $user = Auth::user();

        
        if ($membership->user_id !== $user->id && $user->activeColocation()->pivot->role !== 'owner') {
            abort(403);
        }

        if ($membership->role === 'owner' && $membership->user_id === $user->id) {
            return redirect()->route('memberships.index')
                ->with('error', 'Le propriétaire ne peut pas quitter la colocation. Supprimez-la ou transférez la propriété.');
        }

        $membership->update([
            'left_at' => now()
        ]);

        $message = $membership->user_id === $user->id
            ? 'Vous avez quitté la colocation avec succès.'
            : 'Le membre a été retiré de la colocation avec succès.';

        return redirect()->route('memberships.index')
            ->with('success', $message);
    }
}