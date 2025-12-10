{{-- resources/views/member/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Member Dashboard - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                Welcome back, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                Ready to create your next masterpiece? Your creative journey continues here.
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Artworks Count -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-ui font-semibold text-slate-600 dark:text-slate-400 mb-1">
                            Your Artworks
                        </p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $artworksCount }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('member.artworks.create') }}" 
                   class="mt-4 inline-flex items-center text-sm text-purple-600 dark:text-purple-400 hover:underline">
                    Upload new artwork
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            </div>

            <!-- Favorites Count -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-ui font-semibold text-slate-600 dark:text-slate-400 mb-1">
                            Favorites
                        </p>
                        <p class="text-2xl font-bold text-pink-600 dark:text-pink-400">
                            {{ $favoritesCount }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('member.favorites.index') }}" 
                   class="mt-4 inline-flex items-center text-sm text-pink-600 dark:text-pink-400 hover:underline">
                    View all favorites
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Followers Count -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-ui font-semibold text-slate-600 dark:text-slate-400 mb-1">
                            Followers
                        </p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $followersCount }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('member.followers') }}" 
                   class="mt-4 inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:underline">
                    Manage followers
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Submissions Count -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-ui font-semibold text-slate-600 dark:text-slate-400 mb-1">
                            Active Submissions
                        </p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $submissionsCount }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('member.submissions.index') }}" 
                   class="mt-4 inline-flex items-center text-sm text-green-600 dark:text-green-400 hover:underline">
                    View submissions
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Upload Artwork -->
            <a href="{{ route('member.artworks.create') }}" 
               class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-ui font-semibold text-white mb-2">Upload Artwork</h3>
                <p class="text-purple-100 text-sm">Share your latest creation with the community</p>
            </a>

            <!-- My Artworks -->
            <a href="{{ route('member.artworks.index') }}" 
               class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-ui font-semibold text-white mb-2">My Artworks</h3>
                <p class="text-pink-100 text-sm">Manage and edit your uploaded artworks</p>
            </a>

            <!-- Profile Management -->
            <a href="{{ route('member.profile.edit') }}" 
               class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-ui font-semibold text-white mb-2">Profile Management</h3>
                <p class="text-blue-100 text-sm">Update your profile information and settings</p>
            </a>

            <!-- My Collections -->
            <a href="{{ route('member.collections.index') }}" 
               class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-ui font-semibold text-white mb-2">My Collections</h3>
                <p class="text-green-100 text-sm">Organize your favorite artworks into collections</p>
            </a>
        </div>

        <!-- Three Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Recent Artworks -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-ui font-semibold text-slate-900 dark:text-white">
                                Recent Artworks
                            </h2>
                            <a href="{{ route('member.artworks.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:underline">
                                View all
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($recentArtworks->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($recentArtworks as $artwork)
                            <a href="{{ route('member.artworks.show', $artwork->id) }}" 
                               class="group block bg-slate-50 dark:bg-slate-900 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="aspect-video overflow-hidden bg-slate-200 dark:bg-slate-700">
                                    <img src="{{ $artwork->image_url }}" 
                                         alt="{{ $artwork->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-medium text-slate-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                        {{ Str::limit($artwork->title, 40) }}
                                    </h3>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $artwork->created_at->diffForHumans() }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                            {{ $artwork->visibility === 'public' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                               ($artwork->visibility === 'unlisted' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                                               'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300') }}">
                                            {{ ucfirst($artwork->visibility) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">No artworks yet</h3>
                            <p class="text-slate-600 dark:text-slate-400 mb-6">Start your creative journey by uploading your first artwork!</p>
                            <a href="{{ route('member.artworks.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Upload First Artwork
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Following Feed -->
                @if($followingFeed->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-ui font-semibold text-slate-900 dark:text-white">
                                Following Feed
                            </h2>
                            <a href="{{ route('member.following.feed') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                View all
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($followingFeed as $artwork)
                            <div class="flex items-center space-x-4 p-3 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-slate-200 dark:bg-slate-700">
                                    <img src="{{ $artwork->image_url }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 dark:text-white truncate">
                                        {{ $artwork->title }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        by {{ $artwork->user->name }} • {{ $artwork->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <a href="{{ route('artworks.show', $artwork->id) }}" 
                                   class="flex-shrink-0 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Active Challenges - UPDATEAN YANG KAMU KASIH -->
                @if($activeChallenges->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">Active Challenges</h3>
                    
                    <div class="space-y-4">
                        @foreach($activeChallenges as $challenge)
                        <a href="{{ route('challenges.show', $challenge->id) }}" 
                           class="block group">
                            <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-medium text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        {{ Str::limit($challenge->title, 50) }}
                                    </h4>
                                    @if($challenge->prize)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                        {{ $challenge->prize }}
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                                    <span>
                                        {{ $challenge->submissions_count ?? 0 }} submissions
                                        @php
                                            $userSubmission = $challenge->submissions->firstWhere('user_id', Auth::id());
                                        @endphp
                                        @if($userSubmission)
                                            • <span class="text-green-600 dark:text-green-400">✓ Submitted</span>
                                        @endif
                                    </span>
                                    
                                    @if($challenge->deadline)
                                    <span class="text-red-600 dark:text-red-400">
                                        {{ $challenge->deadline->format('M d') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    
                    <!-- Quick Submit Button -->
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Your Submissions</p>
                                <p class="text-xl font-bold text-purple-600 dark:text-purple-400">
                                    {{ $userChallengeSubmissions ?? 0 }}
                                </p>
                            </div>
                            <a href="{{ route('member.submissions.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                View Submissions
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Profile Quick View -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">Profile Quick View</h3>
                    
                    <div class="flex items-center space-x-4 mb-6">
                        @if(Auth::user()->avatar_url)
                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-16 h-16 rounded-full">
                        @else
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-medium text-slate-900 dark:text-white">{{ Auth::user()->name }}</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</p>
                            @if(Auth::user()->username)
                                <p class="text-xs text-slate-400 dark:text-slate-500">@{{ Auth::user()->username }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('member.profile.edit') }}" 
                           class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-slate-700 dark:text-slate-300">Edit Profile</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('member.favorites.index') }}" 
                           class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="text-slate-700 dark:text-slate-300">My Favorites</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('member.collections.index') }}" 
                           class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="text-slate-700 dark:text-slate-300">My Collections</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- My Collections -->
                @if($collections->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">My Collections</h3>
                    
                    <div class="space-y-4">
                        @foreach($collections as $collection)
                        <a href="{{ route('member.collections.show', $collection->id) }}" 
                           class="block group">
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-gradient-to-br from-purple-500 to-pink-500">
                                        @if($collection->cover_image)
                                            <img src="{{ $collection->cover_image }}" alt="{{ $collection->name }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-slate-900 dark:text-white">{{ $collection->name }}</h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $collection->artworks_count }} artworks</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    
                    <a href="{{ route('member.collections.index') }}" 
                       class="mt-4 inline-flex items-center text-sm text-purple-600 dark:text-purple-400 hover:underline w-full justify-center">
                        View all collections
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                @endif

                <!-- Suggested Artists -->
                @if($suggestedArtists->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">Suggested Artists</h3>
                    
                    <div class="space-y-4">
                        @foreach($suggestedArtists as $artist)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($artist->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-slate-900 dark:text-white">{{ $artist->name }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $artist->artworks_count }} artworks</p>
                                </div>
                            </div>
                            <button onclick="toggleFollow({{ $artist->id }})" 
                                    class="text-sm px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                                Follow
                            </button>
                        </div>
                        @endforeach
                    </div>
                    
                    <a href="{{ route('explore.creators') }}" 
                       class="mt-4 inline-flex items-center text-sm text-purple-600 dark:text-purple-400 hover:underline w-full justify-center">
                        Explore more artists
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                @endif

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">Recent Activity</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 p-3 bg-slate-50 dark:bg-slate-900 rounded-lg">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-700 dark:text-slate-300">Your artwork got 5 new likes</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">2 hours ago</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 p-3 bg-slate-50 dark:bg-slate-900 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-700 dark:text-slate-300">JohnDoe started following you</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Yesterday</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 p-3 bg-slate-50 dark:bg-slate-900 rounded-lg">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-700 dark:text-slate-300">Your submission was accepted</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">3 days ago</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('member.notifications') }}" 
                    class="mt-4 inline-flex items-center text-sm text-purple-600 dark:text-purple-400 hover:underline w-full justify-center">
                        View all activity
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            <!-- End Right Column -->
        </div>
        <!-- End Three Column Layout -->
    </div>
</div>

@push('scripts')
<script>
function toggleFollow(userId) {
    fetch(`/member/follow/${userId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endpush
@endsection