<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Invitations;
use App\Models\Memberships;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // if a token is already stored in the session, include it in the view
        $token = request('token') ?? session('invitation_token');
        return view('auth.register', compact('token'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $isFirstUser = User::count() === 0;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'token' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $isFirstUser
        ]);

        event(new Registered($user));

        Auth::login($user);

        // determine token either from request (hidden input) or session
        $token = $request->filled('token') ? $request->token : $request->session()->pull('invitation_token');

        if ($token) {
            $invitation = Invitations::where('token', $token)
                ->where('status', 'pending')
                ->first();

            if ($invitation) {
                Memberships::create([
                    'user_id' => $user->id,
                    'colocation_id' => $invitation->colocation_id,
                    'role' => 'member',
                    'joined_at' => now(),
                ]);

                $invitation->update(['status' => 'accepted']);

                return redirect()->route('colocation.index')
                    ->with('success', 'Inscription réussie ! Vous avez rejoint la colocation.');
            }
        }

        return redirect(route('dashboard', absolute: false));
    }
}
