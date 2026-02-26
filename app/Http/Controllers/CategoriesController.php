<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoriesRequest;

class CategoriesController extends Controller
{
    
    public function index()
    {
        $categories = Categories::all();
        return view('categories.index', compact('categories'));
    }

    
    public function create()
    {
        return view('categories.create');
    }

    
    public function store(StoreCategoriesRequest $request)
    {
        Categories::create([
                'name' => $request->name,
            
                'colocation_id' => $request->colocation_id,
        ]);
        return redirect()->route('categories.index')->with('success','create category avec success');
    }

    public function show(Categories $categories)
    {
        
    }

    public function edit(string $id)
    {
        $categories = Categories::findOrFail($id);
        return view('categories.edit',compact('categories'));
    }

   
    public function update(StoreCategoriesRequest $request, Categories $categories)
    {
        $categories->update([

            'name' => $request->name,
            'colocation_id' => $request->colocation_id,
            
        ]);
        return redirect()->route('categories.index')->with('success','category modifier avec success');
    }

    
    public function destroy(Categories $categories)
    {
        
        $categories->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée');
    }
}
