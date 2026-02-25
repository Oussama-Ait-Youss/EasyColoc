<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreColocationRequest;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = Colocation::all();
        return view('colocation.index',compact('colocations'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colocation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColocationRequest $request)
    {
        //
        Colocation::create([
            'name' => $request->name,
           
        ]);
        // return view('colocation.index');
        return redirect()->route('colocation.index')->with('success','create colocation avec success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $colocations = Colocation::findOrFail($id);
        return view('colocations.edit',compact('colocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreColocationRequest $request, Colocation $colocation)
    {
        Colocation::updated([
            'name' => $request->name,
        ]);
        return redirect()->route('colocation.index')->with('success','colocation modifier avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        //
    }
}
