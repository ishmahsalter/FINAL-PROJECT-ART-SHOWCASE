<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount(['artworks', 'challenges']);
        
        // Filter berdasarkan status jika ada
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan role jika ada
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }
        
        // Search by name/email jika ada
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('display_name', 'LIKE', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        $pendingCurators = User::where('role', User::ROLE_CURATOR)
                              ->where('status', User::STATUS_PENDING)
                              ->count();

        return view('admin.users.index', compact('users', 'pendingCurators'));
    }

    public function show($id)
    {
        $user = User::with(['artworks', 'challenges'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        
        // Prevent deleting other admins (optional)
        if ($user->role === User::ROLE_ADMIN) {
            return redirect()->back()->with('error', 'Cannot delete admin accounts.');
        }

        $user->delete();
        
        Log::info('User deleted by admin', [
            'deleted_user_id' => $user->id,
            'deleted_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // ========== METHOD UNTUK USER MANAGEMENT ==========
    
    /**
     * Update user role
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent self-role change
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }
        
        $request->validate([
            'role' => 'required|in:' . implode(',', [User::ROLE_MEMBER, User::ROLE_CURATOR, User::ROLE_ADMIN]),
        ]);
        
        $oldRole = $user->role;
        $user->update([
            'role' => $request->role,
            'status' => $request->role === User::ROLE_CURATOR ? User::STATUS_PENDING : User::STATUS_ACTIVE
        ]);
        
        return back()->with('success', "User role changed from {$oldRole} to {$request->role}!");
    }
    
    /**
     * Update user status
     */
    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent self-status change
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own status.');
        }
        
        $request->validate([
            'status' => 'required|in:' . implode(',', [
                User::STATUS_ACTIVE, 
                User::STATUS_PENDING, 
                User::STATUS_SUSPENDED, 
                User::STATUS_BANNED
            ]),
        ]);
        
        $oldStatus = $user->status;
        $user->update(['status' => $request->status]);
        
        return back()->with('success', "User status changed from {$oldStatus} to {$request->status}!");
    }
    
    /**
     * Send message to user
     */
    public function sendMessage(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);
        
        // Here you can:
        // 1. Save to database (create notifications table)
        // 2. Send email
        // 3. Send in-app notification
        
        return back()->with('success', 'Message sent to user successfully!');
    }
    
    /**
     * Ban user account
     */
    public function ban($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent self-ban
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot ban your own account.');
        }
        
        $user->update(['status' => User::STATUS_BANNED]);
        
        Log::info('User banned by admin', [
            'user_id' => $user->id,
            'banned_by' => auth()->id()
        ]);
        
        return back()->with('success', 'User account has been banned!');
    }
    
    /**
     * Activate user account
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent self-activation (not really needed but good to have)
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot activate your own account.');
        }
        
        $user->update(['status' => User::STATUS_ACTIVE]);
        
        Log::info('User activated by admin', [
            'user_id' => $user->id,
            'activated_by' => auth()->id()
        ]);

        return back()->with('success', 'User activated successfully.');
    }
    
    /**
     * Deactivate user account (suspend)
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['status' => User::STATUS_SUSPENDED]);
        
        Log::info('User deactivated by admin', [
            'user_id' => $user->id,
            'deactivated_by' => auth()->id()
        ]);

        return back()->with('success', 'User account deactivated (suspended).');
    }
    
    /**
     * Approve curator application
     */
    public function approveCurator($id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan hanya curator yang pending yang bisa di-approve
        if ($user->role !== User::ROLE_CURATOR || $user->status !== User::STATUS_PENDING) {
            return back()->with('error', 'Invalid user for approval. Only pending curators can be approved.');
        }

        $user->update(['status' => User::STATUS_ACTIVE]);
        
        // Log approval
        Log::info('Curator approved by admin', [
            'curator_id' => $user->id,
            'curator_email' => $user->email,
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        return back()->with('success', '🎉 Curator approved successfully! They can now access their dashboard.');
    }
    
    /**
     * Reject curator application
     */
    public function rejectCurator($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== User::ROLE_CURATOR) {
            return back()->with('error', 'User is not a curator applicant.');
        }
        
        // Ubah role jadi member dan aktifkan
        $user->update([
            'role' => User::ROLE_MEMBER,
            'status' => User::STATUS_ACTIVE
        ]);
        
        Log::info('Curator rejected by admin', [
            'curator_id' => $user->id,
            'rejected_by' => auth()->id()
        ]);
        
        return back()->with('success', 'Curator application rejected! User changed to member.');
    }
}