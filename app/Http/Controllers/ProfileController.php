<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    
    public function edit(Request $request): View
    {
        $user = $request->user();
        $colocation = $user->activeColocation();
        $role = $colocation ? $colocation->pivot->role : null;

        return view('profile.edit', [
            'user' => $user,
            'colocation' => $colocation,
            'role' => $role,
        ]);
    }

    
    public function updateReputation(Request $request, User $user, string $action): RedirectResponse
{
    $currentUser = Auth::user();
    $colocation = $currentUser->activeColocation();

    if ($currentUser->id === $user->id) {
        return back()->with('error', 'Auto-évaluation interdite par le protocole.');
    }

    $membership = $user->colocations()
        ->where('colocation_id', $colocation->id)
        ->first()
        ->pivot;

    $currentScore = $membership->reputation ?? 0;
    $adjustment = ($action === 'up') ? 1 : -1;
    $newScore = max(0, min(100, $currentScore + $adjustment));

    $user->colocations()->updateExistingPivot($colocation->id, [
        'reputation' => $newScore
    ]);

    return back()->with('success', 'Indice de fiabilité mis à jour.');
}

    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
