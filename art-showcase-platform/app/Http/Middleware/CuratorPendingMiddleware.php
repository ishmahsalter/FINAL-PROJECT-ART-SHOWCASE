<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CuratorPendingMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // Hanya curator dengan status pending yang boleh akses
        if ($user->role === 'curator' && $user->status === 'pending') {
            return $next($request);
        }

        // Jika sudah active, redirect ke dashboard
        if ($user->status === 'active') {
            return redirect()->route('curator.dashboard');
        }

        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}