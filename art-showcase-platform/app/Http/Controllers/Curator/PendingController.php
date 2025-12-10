<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PendingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Debug: lihat siapa yang mengakses
        \Log::info('PendingController accessed:', [
            'user_id' => $user ? $user->id : 'guest',
            'role' => $user ? $user->role : 'guest',
            'status' => $user ? $user->status : 'guest',
            'url' => request()->fullUrl()
        ]);
        
        // SCENARIO 1: User sudah login dan adalah curator ACTIVE
        if ($user && $user->role === 'curator' && $user->status === 'active') {
            return redirect()->route('curator.dashboard')
                ->with('info', 'Your account is already approved.');
        }
        
        // SCENARIO 2: User sudah login dan adalah curator PENDING (boleh akses)
        if ($user && $user->role === 'curator' && $user->status === 'pending') {
            return view('auth.pending-approval', [
                'user' => $user,
                'message' => 'Your curator account is pending admin approval.',
                'showLogout' => true
            ]);
        }
        
        // SCENARIO 3: User login tapi BUKAN curator
        if ($user && $user->role !== 'curator') {
            return redirect()->route('home')
                ->with('error', 'This page is for curators only.');
        }
        
        // SCENARIO 4: User TIDAK login (guest) - BOLEH AKSES
        // Ini untuk user yang baru register sebagai curator
        return view('auth.pending-approval', [
            'message' => 'Your curator account is pending admin approval.',
            'showLogout' => false  // Tampilkan "Go to Login" bukan "Back to Login"
        ]);
    }
}