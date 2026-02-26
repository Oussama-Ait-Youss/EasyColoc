<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expenses;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $colocation = $user->activeColocation();

    if (!$colocation) {
        return redirect()->route('colocation.create');
    }

    $members = $colocation->users()->wherePivot('left_at', null)->get();
    $memberCount = $members->count();
    $totalExpenses = Expenses::where('colocation_id', $colocation->id)->sum('amount');
    $sharePerPerson = $memberCount > 0 ? $totalExpenses / $memberCount : 0;

    $memberBalances = $members->map(function ($member) use ($colocation, $sharePerPerson) {
        $paidByMember = Expenses::where('colocation_id', $colocation->id)
            ->where('user_id', $member->id)
            ->sum('amount');

        return [
            'name' => $member->name,
            'paid' => $paidByMember,
            'balance' => $paidByMember - $sharePerPerson,
        ];
    });

    // --- LA PARTIE MANQUANTE ---
    // On groupe les dépenses par catégorie pour le graphique
   // On groupe les dépenses par catégorie pour le graphique
$categoriesData = Expenses::where('expenses.colocation_id', $colocation->id) // Ajout de "expenses." ici
    ->join('categories', 'expenses.category_id', '=', 'categories.id')
    ->selectRaw('categories.name as label, SUM(expenses.amount) as total')
    ->groupBy('categories.name')
    ->get();

    // N'oublie pas d'ajouter 'categoriesData' dans le compact()
    return view('dashboard', compact(
        'colocation', 
        'totalExpenses', 
        'sharePerPerson', 
        'memberBalances', 
        'memberCount', 
        'categoriesData'
    ));
}
}