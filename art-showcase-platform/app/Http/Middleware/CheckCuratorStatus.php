<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCuratorStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user is a curator
        if ($user->role !== 'curator') {
            return redirect()->route('home')->with('error', 'Access denied. Curator only.');
        }
        
        // Check curator status
        if ($user->status === 'pending') {
            return redirect()->route('curator.pending');
        }
        
        if ($user->status !== 'active') {
            return redirect()->route('home')->with('error', 'Your curator account is not active.');
        }
        
        return $next($request);
    }
}