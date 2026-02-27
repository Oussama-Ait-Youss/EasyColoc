<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreColocationRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
   
    public function index()
{
  
    $colocation = auth()->user()->activeColocation();

    if (!$colocation) {
        return redirect()->route('colocation.create')
            ->with('info', 'Vous devez d\'abord créer ou rejoindre une colocation.');
    }

    return view('colocations.index', compact('colocation'));
}

    public function create()
    {
        return view('colocations.create');
    }

   
    public function store(StoreColocationRequest $request)
    {
        $colocation = Colocation::create([
            'name' => $request->name,
            'invite_token' => Str::random(32),
           
        ]);
        $colocation->memberships()->create([
            'user_id' => Auth::id(),
            'role' => 'owner',
            'joined_at' => now(),
        ]);
        return redirect()->route('colocation.index')->with('success','create colocation avec success');
    }

   
    public function show(Colocation $colocation)
    {
        //
    }

    
    public function edit(string $id)
    {
        $colocations = Colocation::findOrFail($id);
        return view('colocations.edit',compact('colocations'));
    }

    
    public function update(StoreColocationRequest $request, Colocation $colocation)
    {
        $colocation->update([
            'name' => $request->name,
            
        ]);
        return redirect()->route('colocations.index')->with('success','colocation modifier avec success');
    }

    
    public function destroy(Colocation $colocation)
    {
        $colocation->delete();
        return redirect()->route('colocations.index')->with('success', 'colocation supprimée avec success');

    }
}
