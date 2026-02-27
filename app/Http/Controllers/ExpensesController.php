<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExpenseRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    
    public function index()
    {
        //
        $expenses = Expenses::all();
        
        return view('expenses.index',compact('expenses'));
    }

   
    public function create()
{
    // 1. On récupère la colocation active de l'utilisateur connecté
    $colocation = Auth::user()->activeColocation();

    // 2. PROTECTION : Si l'utilisateur n'a pas de colocation, on ne va pas plus loin
    if (!$colocation) {
        return redirect()->route('colocation.create')
            ->with('error', 'Vous devez rejoindre une colocation pour ajouter des dépenses.');
    }

    // 3. Ici, on est sûr que $colocation n'est pas NULL
    $categories = Categories::where('colocation_id', $colocation->id)->get();

    // If there are no categories yet, create a set of sensible defaults
    if ($categories->isEmpty()) {
        $defaultCategories = [
            'Rent' => 'Monthly rent payments',
            'Utilities' => 'Electricity, water, gas bills',
            'Groceries' => 'Food and household items',
            'Internet' => 'Internet and cable bills',
            'Cleaning Supplies' => 'Cleaning products and tools',
            'Maintenance' => 'Repairs and maintenance',
            'Entertainment' => 'Shared entertainment expenses',
            'Transportation' => 'Shared transportation costs'
        ];

        foreach (array_keys($defaultCategories) as $name) {
            Categories::firstOrCreate([
                'colocation_id' => $colocation->id,
                'name' => $name,
            ]);
        }

        // reload categories after creating defaults
        $categories = Categories::where('colocation_id', $colocation->id)->get();
    }
    
    return view('expenses.create', compact('categories'));
}

  
    public function store(StoreExpenseRequest $request)
    {
        //
        Expenses::create([
            'title'         => $request->title,
            'amount'        => $request->amount,
            'category_id'   => $request->category_id,
            'date'          => $request->date,
            'colocation_id' => $request->colocation_id,
            'user_id'       => Auth::id(),
        ]);
        // return view('colocation.index');
        return redirect()->route('expenses.index')->with('success','ajouter expenses avec success');

    }

    /**
     * Display the specified resource.
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expenses = Expenses::findOrFail($id);
        return view('expenses.edit',compact('expenses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreExpenseRequest $request, Expenses $expenses)
    {
        $expenses->update([
            'title' => $request->title,
            
            'amount' => $request->amount,

            'date' => $request->date,
        ]);
        return redirect()->route('expenses.index')->with('success','expenses modifier avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expenses)
    {
        $expenses->delete();
        return redirect()->route('expenses.index')->with('success','supprimere avec success');
    }
}
