<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCuratorRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        
        $user = Auth::user();
        
        if ($user->role !== 'curator') {
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'member') {
                return redirect()->route('member.dashboard');
            }
            return redirect()->route('home')->with('error', 'Access denied. Curator area only.');
        }
        
        return $next($request);
    }
}