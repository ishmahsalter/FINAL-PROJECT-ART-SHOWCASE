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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:member,curator'],
    ]);

    $status = ($request->role === 'curator') ? 'pending' : 'active';

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'status' => $status,
        'display_name' => $request->name,
    ]);

    event(new Registered($user));

    // Debug log
    \Log::info('User registered:', [
        'id' => $user->id,
        'email' => $user->email,
        'role' => $user->role,
        'status' => $user->status,
        'redirecting_to' => $request->role === 'curator' ? '/pending-approval' : '/home'
    ]);

    // PERHATIAN: Curator TIDAK auto-login!
    if ($request->role === 'curator') {
        // JANGAN login dulu, langsung redirect ke pending page
        return redirect()->route('pending.approval')
            ->with('info', 'Your curator account is pending admin approval. Please login to check your status.');
    }

    // Hanya member yang auto-login
    Auth::login($user);

    return redirect()->route('home')
        ->with('success', 'Registration successful! Welcome to ArtShowcase.');
}
}
