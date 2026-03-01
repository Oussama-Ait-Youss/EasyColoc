<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExpenseRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Payments;

class ExpensesController extends Controller
{
    
    public function index()
    {
        
        $user = Auth::user();

        $colocation = $user ? $user->activeColocation() : null;

        if ($colocation) {
            $expenses = Expenses::where('colocation_id', $colocation->id)
                ->with(['user', 'category'])
                ->orderBy('date', 'desc')
                ->get();
        } else {
        
            $expenses = collect();
        }

        return view('expenses.index', compact('expenses'));
    }

   
    public function create()
{
    
    $colocation = Auth::user()->activeColocation();

    
    if (!$colocation) {
        return redirect()->route('colocation.create')
            ->with('error', 'Vous devez rejoindre une colocation pour ajouter des dépenses.');
    }

    $categories = Categories::where('colocation_id', $colocation->id)->get();

    
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

        $categories = Categories::where('colocation_id', $colocation->id)->get();
    }
    
    return view('expenses.create', compact('categories'));
}

  
    public function store(StoreExpenseRequest $request)
    {
       
        $colocation = Auth::user() ? Auth::user()->activeColocation() : null;

        if (!$colocation) {
            return redirect()->route('colocation.create')
                ->with('error', "Vous devez rejoindre une colocation pour ajouter des dépenses.");
        }

        Expenses::create([
            'title'         => $request->title,
            'amount'        => $request->amount,
            'category_id'   => $request->category_id,
            'date'          => $request->date,
            'colocation_id' => $colocation->id,
            'user_id'       => Auth::id(),
        ]);
        return redirect()->route('expenses.index')->with('success','ajouter expenses avec success');

    }

  
    public function show(Expenses $expenses)
    {
        //
    }

  
    public function edit(string $id)
    {
        $colocation = Auth::user()->activeColocation();
        if (!$colocation) {
            return redirect()->route('colocation.create')
                ->with('error', 'Vous devez rejoindre une colocation.');
        }

        $expenses = Expenses::findOrFail($id);
        
        // Verify expense belongs to current colocation
        if ((int)$expenses->colocation_id !== (int)$colocation->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Categories::where('colocation_id', $colocation->id)->get();
        return view('expenses.edit',compact('expenses','categories'));
    }

    
    public function update(StoreExpenseRequest $request, Expenses $expenses)
    {
        $expenses->update([
            'title' => $request->title,
            
            'amount' => $request->amount,

            'date' => $request->date,
        ]);
        return redirect()->route('expenses.index')->with('success','expenses modifier avec success');
    }

    public function destroy(Expenses $expenses) 
{
    $user = Auth::user();
    $colocation = $user->activeColocation();

    if (!$colocation) {
        return redirect()->route('colocation.create')
            ->with('error', 'Vous devez rejoindre une colocation.');
    }

    
    if ((int)$expenses->colocation_id !== (int)$colocation->id) {
        abort(403, 'Unauthorized action. Cette dépense n\'appartient pas à votre colocation.');
    }

    $expenses->delete();
    
    return redirect()->route('expenses.index')->with('success', 'Dépense supprimée avec succès');
}

    /**
     * Mark a specific expense as paid by the current user (creates a Payments record).
     */
    public function pay(Expenses $expense)
    {
        $user = Auth::user();
        $colocation = $user ? $user->activeColocation() : null;

        if (!$colocation) {
            return redirect()->route('colocation.create')
                ->with('error', 'Vous devez appartenir à une colocation.');
        }

        if ((int)$expense->colocation_id !== (int)$colocation->id) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent paying your own expense
        if ((int)$expense->user_id === (int)$user->id) {
            return redirect()->route('expenses.index')->with('error', 'Vous ne pouvez pas vous payer vous-même.');
        }

        // Determine share: split evenly among active members
        $memberCount = $colocation->users()->wherePivot('left_at', null)->count() ?: 1;
        $share = round($expense->amount / $memberCount, 2);

        Payments::create([
            'amount' => $share,
            'from_user_id' => $user->id,
            'to_user_id' => $expense->user_id,
            'colocation_id' => $colocation->id,
            'paid_at' => now(),
        ]);

        return redirect()->route('expenses.index')->with('success', 'Paiement enregistré.');
    }
}
