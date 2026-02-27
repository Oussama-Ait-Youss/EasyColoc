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
    
    public function index()
    {
        $invitations = Invitations::all();
        return view('invitations.index', compact('invitations'));
    }

   
    public function create()
    {
        return view('invitations.create');
    }

    
    public function store(StoreInvitationsRequest $request)
{
    $user = Auth::user();
    $colocation = $user->activeColocation();

    $invitation = Invitations::create([
        'email' => $request->email,
        'colocation_id' => $colocation->id, 
        'token' => Str::random(32),
        'user_id' => $user->id,
        'status' => 'pending',
        'expires_at' => now()->addDays(7),
    ]);

    Mail::to($invitation->email)
        ->send(new InvitationMail($invitation));

    return redirect()->route('invitations.index')->with('success', 'Invitation envoyée avec succès.');
}

    
    public function show(Invitations $invitations)
    {

    }

   
    public function edit(string $id)
    {
        $invitations = Invitations::findOrFail($id);
        return view('invitations.edit',compact('invitations'));
    }

 
    public function update(StoreInvitationsRequest $request, Invitations $invitations)
    {
        $invitations->update(  [
             'email' => $request->email,
            
        ]);
        return redirect()->route('colocation.index')->with('success','invitations modifier avec success');
    }

    
    public function destroy(Invitations $invitations)
    {
        //
        $invitations->delete();
        return redirect()->route('invitations.index')->with('success','supprimere avec  succes');
    }
    public function join(Request $request)
    {
        $token = $request->query('token');

        if (Auth::guest()) {
            session(['invitation_token' => $token]);
            return redirect()->route('register', ['token' => $token]);
        }

        if ($token) {
            $invitation = Invitations::where('token', $token)
                ->where('status', 'pending')
                ->first();

            if ($invitation) {
                if (!Auth::user()->colocations()->where('colocation_id', $invitation->colocation_id)->exists()) {
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

        return view('invitations.join', compact('token')); 
    }
}
