<?php

namespace App\Http\Controllers;

use App\Models\Memberships;
use App\Models\Invitations;
use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMembershipsRequest;
use Illuminate\Support\Facades\Auth;

class MembershipsController extends Controller
{
    /**
     * Affiche la liste des membres de la colocation actuelle de l'utilisateur.
     */
    public function index()
    {
        // On récupère la colocation active de l'utilisateur connecté
        $colocation = Colocation::all()
            ->wherePivot('left_at', null)
            ->first();

        $members = $colocation ? $colocation->memberships()->with('user')->get() : [];

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

  
    public function destroy(Memberships $membership)
    {
        
        $membership->update([
            'left_at' => now()
        ]);

        return redirect()->route('memberships.index')
            ->with('success', 'Le membre a été retiré de la colocation avec succès.');
    }
}