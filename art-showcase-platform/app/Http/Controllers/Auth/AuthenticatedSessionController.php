<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Cek jika user sudah login, redirect sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'curator') {
                return redirect()->route('curator.dashboard');
            } else {
                return redirect()->route('member.dashboard');
            }
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // VALIDASI INPUT
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // ATTEMPT LOGIN MANUAL
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        
        // Debug log
        \Log::info('User logged in:', [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'status' => $user->status
        ]);
        
        // Jika curator pending, redirect ke pending page
        if ($user->role === 'curator' && $user->status === 'pending') {
            return redirect()->route('pending.approval')
                ->with('info', 'Your curator account is pending admin approval.');
        }

        // Jika curator rejected/banned/suspended
        if ($user->role === 'curator' && $user->status !== 'active') {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Your curator account is ' . $user->status . '. Please contact admin.');
        }

        // Cek status user untuk semua role
        if (in_array($user->status, ['suspended', 'banned', 'inactive'])) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Your account is ' . $user->status . '. Please contact support.');
        }

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, Admin!');
        } elseif ($user->role === 'curator') {
            return redirect()->route('curator.dashboard')
                ->with('success', 'Welcome back, Curator!');
        } else {
            return redirect()->intended(route('member.dashboard', absolute: false))
                ->with('success', 'Welcome back!');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Simpan info user sebelum logout untuk log
        $user = Auth::user();
        
        if ($user) {
            \Log::info('User logged out:', [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);
        }
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}