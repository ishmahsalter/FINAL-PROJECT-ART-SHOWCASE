<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to access this page.');
        }
        
        $user = auth()->user();
        
        // Check if user is admin
        if ($user->role !== 'admin') {
            // Log unauthorized access attempt
            \Log::warning('Unauthorized admin access attempt', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'route' => $request->route()->getName(),
                'ip' => $request->ip()
            ]);
            
            // Jika user adalah curator atau member, redirect ke dashboard mereka
            return match($user->role) {
                'curator' => redirect()->route('curator.dashboard')
                    ->with('error', 'Access denied. This area is for administrators only.'),
                'member' => redirect()->route('member.dashboard')
                    ->with('error', 'Access denied. This area is for administrators only.'),
                default => redirect()->route('home')
                    ->with('error', 'Access denied. Admin only.'),
            };
        }
        
        // Additional check: Ensure admin account is active
        if ($user->status !== 'active') {
            \Log::warning('Inactive admin account attempted access', [
                'user_id' => $user->id,
                'admin_status' => $user->status
            ]);
            
            return redirect()->route('home')
                ->with('error', 'Your admin account is ' . $user->status . '. Please contact system administrator.');
        }
        
        return $next($request);
    }
}