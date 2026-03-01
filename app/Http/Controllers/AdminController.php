<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expenses;
use App\Models\Colocation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_colocations' => Colocation::count(),
            'total_expenses' => Expenses::sum('amount'),
            'banned_users' => User::where('is_banned', true)->count(),
        ];

        $users = User::paginate(10);
        return view('admin.dashboard', compact('stats', 'users'));
    }

    public function toggleBan(User $user)
    {
        // On inverse le statut de bannissement
        $user->update(['is_banned' => !$user->is_banned]);
        
        $status = $user->is_banned ? 'banni' : 'débanni';
        return back()->with('success', "L'utilisateur {$user->name} a été {$status}.");
    }
}