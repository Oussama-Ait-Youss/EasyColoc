<?php

namespace App\Http\Controllers;

use App\Models\Invitations;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvitationsRequest;

class InvitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        Invitations::create([
            'email' => $request->email,
            
            'colocation_id' => $request->colocation_id,
        ]);
        return redirect()->route('invitation.index')->with('success','create invitation avec success');
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
        Invitations::updated(  [
             'email' => $request->email,
            
            'colocation_id' => $request->colocation_id,
        ]);
        return redirect()->route('colocation.index')->with('success','invitations modifier avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invitations $invitations)
    {
        //
    }
}
