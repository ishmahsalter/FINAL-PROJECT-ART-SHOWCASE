<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to access member area.');
        }
        
        $user = auth()->user();
        
        if ($user->role !== 'member') {
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard')
                    ->with('error', 'Access denied. This area is for members only.'),
                'curator' => redirect()->route('curator.dashboard')
                    ->with('error', 'Access denied. This area is for members only.'),
                default => redirect()->route('home')
                    ->with('error', 'Access denied. Member only.'),
            };
        }
        
        // Check if member account is active
        if (!in_array($user->status, ['active', 'pending'])) {
            return redirect()->route('home')
                ->with('error', 'Your account is ' . $user->status . '. Please contact support.');
        }
        
        return $next($request);
    }
}