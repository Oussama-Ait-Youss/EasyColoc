<?php

namespace App\Http\Controllers;

use App\Models\Invitations;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvitationsRequest;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;

class InvitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invitations = Invitations::all();
        return view('invitations.index', compact('invitations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invitations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvitationsRequest $request)
{
    // the form request already ensured the current user is an owner of an active colocation
    $user = Auth::user();
    $colocation = $user->activeColocation();

    $invitation = Invitations::create([
        'email' => $request->email,
        'colocation_id' => $colocation->id, // utilise l'ID de la coloc active
        'token' => Str::random(32),
        'user_id' => $user->id,
        'status' => 'pending',
        'expires_at' => now()->addDays(7),
    ]);

    // send notification email
    Mail::to($invitation->email)
        ->send(new InvitationMail($invitation));

    return redirect()->route('invitations.index')->with('success', 'Invitation envoyée avec succès.');
}

    /**
     * Display the specified resource.
     */
    public function show(Invitations $invitations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invitations = Invitations::findOrFail($id);
        return view('invitations.edit',compact('invitations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreInvitationsRequest $request, Invitations $invitations)
    {
        $invitations->update(  [
             'email' => $request->email,
            
        ]);
        return redirect()->route('colocation.index')->with('success','invitations modifier avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invitations $invitations)
    {
        //
        $invitations->delete();
        return redirect()->route('invitations.index')->with('success','supprimere avec  succes');
    }
    public function join(Request $request)
    {
        $token = $request->query('token');

        // if the visitor is not logged in, store the token and send them to registration
        if (Auth::guest()) {
            session(['invitation_token' => $token]);
            return redirect()->route('register', ['token' => $token]);
        }

        // user is authenticated
        if ($token) {
            // try to resolve invitation and auto‑join
            $invitation = Invitations::where('token', $token)
                ->where('status', 'pending')
                ->first();

            if ($invitation) {
                // don't duplicate membership if somehow already in place
                if (!Auth::user()->colocations()->where('colocation_id', $invitation->colocation_id)->exists()) {
                    // use Memberships model directly to keep pivot data consistent
                    \App\Models\Memberships::create([
                        'user_id'       => Auth::id(),
                        'colocation_id' => $invitation->colocation_id,
                        'role'          => 'member',
                        'joined_at'     => now(),
                    ]);
                }

                $invitation->update(['status' => 'accepted']);

                return redirect()->route('colocation.index')
                    ->with('success', 'Vous avez rejoint la colocation.');
            }
        }

        // fallback: show manual join form
        return view('invitations.join', compact('token')); // Crée cette vue simple avec un champ "Token"
    }
}
