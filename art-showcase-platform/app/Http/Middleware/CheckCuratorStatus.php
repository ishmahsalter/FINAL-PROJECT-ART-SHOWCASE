<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCuratorStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->role !== 'curator') {
            abort(403, 'Unauthorized');
        }

        if ($user->status !== 'active') {
            return redirect()->route('curator.pending');
        }

        return $next($request);
    }
}