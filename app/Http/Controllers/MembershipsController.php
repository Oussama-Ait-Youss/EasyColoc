<?php

namespace App\Http\Controllers;

use App\Models\Memberships;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMembershipsRequest;

class MembershipsController extends Controller
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
        return view('memberships.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembershipsRequest $request)
    {
        Memberships::create([
            'token' => $request->token,
            
            'colocation_id' => $request->colocation_id,
        ]);
        return redirect()->route('memberships.index')->with('success','create Memberships avec success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Memberships $memberships)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $memberships = Memberships::findOrFail($id);
        return view('memberships.edit',compact('memberships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMembershipsRequest $request, Memberships $memberships)
    {
        // Memberships::update([

        //     'token' => $request->token,
            
        //     'colocation_id' => $request->colocation_id,
        // ]);
        // return redirect()->route('memberships.index')->with('success','update avec success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Memberships $memberships)
    {
        //
    }
}
