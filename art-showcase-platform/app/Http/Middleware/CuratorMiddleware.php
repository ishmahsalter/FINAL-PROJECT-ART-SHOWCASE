<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CuratorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to access curator area.');
        }
        
        $user = auth()->user();
        
        if ($user->role !== 'curator') {
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard')
                    ->with('error', 'Access denied. This area is for curators only.'),
                'member' => redirect()->route('member.dashboard')
                    ->with('error', 'Access denied. This area is for curators only.'),
                default => redirect()->route('home')
                    ->with('error', 'Access denied. Curator only.'),
            };
        }
        
        // Curator bisa akses meski status pending (untuk pending approval page)
        // Status check akan dilakukan di controller atau middleware khusus
        
        return $next($request);
    }
}