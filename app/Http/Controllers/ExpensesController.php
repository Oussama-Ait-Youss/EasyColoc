<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExpenseRequest;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $expenses = Expenses::all();
        return view('colocation.index',compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        //
        Expenses::create([
            'title' => $request->title,
            
            'amount' => $request->amount,
            
            'category_id' => $request->category_id,
            
            'date' => $request->date,
            
            'colocation_id' => $request->coloction_id,
           
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
        Expenses::update([
            'title' => $request->title,
            
            'amount' => $request->amount,
            
            'category_id' => $request->category_id,
            
            'date' => $request->date,
            
            'colocation_id' => $request->colocation_id,
        ]);
        return redirect()->route('expenses.index')->with('success','expenses modifier avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expenses)
    {
        //
    }
}
