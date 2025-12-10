<!-- resources/views/admin/users/show.blade.php -->
@extends('layouts.app')

@section('title', 'User Details - Admin')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                        User Details
                    </h1>
                    <div class="flex items-center space-x-4 text-sm text-slate-600 dark:text-slate-400">
                        <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                            ← Back to Users
                        </a>
                        <span>•</span>
                        <span>User ID: {{ $user->id }}</span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    @if($user->status === 'pending' && $user->role === 'curator')
                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Approve Curator
                            </button>
                        </form>
                    @endif
                    
                    @if($user->status !== 'banned')
                        <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" onclick="return confirm('Are you sure?')" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                {{ $user->role === 'curator' ? 'Reject' : 'Ban User' }}
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Activate User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - User Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Profile Card -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                    <div class="flex items-start space-x-6">
                        <div class="w-24 h-24 rounded-full overflow-hidden bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 flex items-center justify-center text-white text-4xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                                        {{ $user->name }}
                                    </h2>
                                    <p class="text-slate-600 dark:text-slate-400">{{ $user->email }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                                           ($user->role === 'curator' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                           'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $user->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                           ($user->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Joined</p>
                                    <p class="font-medium">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Last Active</p>
                                    <p class="font-medium">{{ $user->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            @if($user->bio)
                                <div class="mt-4">
                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Bio</h3>
                                    <p class="text-slate-700 dark:text-slate-300">{{ $user->bio }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Artworks Section -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                            Artworks ({{ $user->artworks->count() }})
                        </h3>
                        @if($user->artworks->count() > 0)
                            <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                View all
                            </a>
                        @endif
                    </div>
                    
                    @if($user->artworks->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($user->artworks->take(6) as $artwork)
                                <div class="bg-slate-100 dark:bg-slate-700 rounded-lg overflow-hidden group">
                                    <div class="aspect-square bg-gray-300 dark:bg-gray-600 relative overflow-hidden">
                                        @if($artwork->image_path)
                                            <img src="{{ Storage::url($artwork->image_path) }}" 
                                                 alt="{{ $artwork->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h4 class="font-medium text-slate-900 dark:text-white truncate">
                                            {{ $artwork->title }}
                                        </h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $artwork->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-4 text-slate-500 dark:text-slate-400">No artworks uploaded yet</p>
                        </div>
                    @endif
                </div>

                <!-- Challenges Section (for curators) -->
                @if($user->role === 'curator' && $user->challenges->count() > 0)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">
                            Challenges Created ({{ $user->challenges->count() }})
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($user->challenges->take(5) as $challenge)
                                <div class="border border-slate-200 dark:border-slate-700 rounded-lg p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-slate-900 dark:text-white">
                                                {{ $challenge->title }}
                                            </h4>
                                            <div class="flex items-center space-x-4 mt-1 text-sm text-slate-500 dark:text-slate-400">
                                                <span>Start: {{ $challenge->start_date->format('d M Y') }}</span>
                                                <span>•</span>
                                                <span>End: {{ $challenge->end_date->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $challenge->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($challenge->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Actions & Stats -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                        Quick Actions
                    </h3>
                    
                    <div class="space-y-3">
                        @if($user->id !== auth()->id())
                            @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.role.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                            Change Role
                                        </label>
                                        <select name="role" class="w-full border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 bg-white dark:bg-slate-700">
                                            <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                                            <option value="curator" {{ $user->role === 'curator' ? 'selected' : '' }}>Curator</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Update Role
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.users.status.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Change Status
                                    </label>
                                    <select name="status" class="w-full border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 bg-white dark:bg-slate-700">
                                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="banned" {{ $user->status === 'banned' ? 'selected' : '' }}>Banned</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                                    Update Status
                                </button>
                            </form>

                            <form action="{{ route('admin.users.sendMessage', $user->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Send Message
                                    </label>
                                    <textarea name="message" rows="3" 
                                              class="w-full border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 bg-white dark:bg-slate-700"
                                              placeholder="Type your message..."></textarea>
                                </div>
                                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                    Send Message
                                </button>
                            </form>
                        @else
                            <div class="text-center py-4 text-slate-500 dark:text-slate-400">
                                You cannot perform actions on your own account
                            </div>
                        @endif
                    </div>
                </div>

                <!-- User Stats -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                        Statistics
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 dark:text-slate-400">Artworks</span>
                            <span class="font-bold text-slate-900 dark:text-white">{{ $user->artworks->count() }}</span>
                        </div>
                        
                        @if($user->role === 'curator')
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600 dark:text-slate-400">Challenges</span>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $user->challenges->count() }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600 dark:text-slate-400">Member Since</span>
                            <span class="font-medium text-slate-900 dark:text-white">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                @if($user->id !== auth()->id())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-red-800 dark:text-red-300 mb-4">
                            Danger Zone
                        </h3>
                        
                        <div class="space-y-3">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                  onsubmit="return confirm('Permanently delete this user? This cannot be undone!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    Delete User Permanently
                                </button>
                            </form>
                            
                            @if($user->status !== 'banned')
                                <form action="{{ route('admin.users.ban', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Ban this user? They will lose access to their account.')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Ban User Account
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: "#10B981",
        }).showToast();
    </script>
@endif

@if(session('error'))
    <script>
        Toastify({
            text: "{{ session('error') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: "#EF4444",
        }).showToast();
    </script>
@endif
@endsection