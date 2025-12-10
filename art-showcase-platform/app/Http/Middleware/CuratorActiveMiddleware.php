<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CuratorActiveMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // Hanya curator dengan status active yang boleh akses
        if ($user->role === 'curator' && $user->status === 'active') {
            return $next($request);
        }

        // Jika pending, redirect ke pending page
        if ($user->status === 'pending') {
            return redirect()->route('pending.approval')
                ->with('info', 'Your curator account is pending approval.');
        }

        // Jika rejected/banned
        return redirect()->route('curator.dashboard')
            ->with('error', 'Your curator account is not active. Status: ' . $user->status);
    }
}