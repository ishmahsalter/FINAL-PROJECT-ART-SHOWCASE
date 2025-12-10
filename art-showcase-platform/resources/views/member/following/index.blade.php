{{-- resources/views/member/following/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Following - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-2">
                        Following
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        Artists and creators you follow
                    </p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('member.dashboard') }}" 
                       class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        ← Back to Dashboard
                    </a>
                    <a href="{{ route('member.followers') }}" 
                       class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                        View Followers
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Total Following</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $following->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Active This Week</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $activeFollowingCount ?? 0 }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Mutual Follows</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $mutualFollowingCount ?? 0 }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Following List -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            @if($following->count() > 0)
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($following as $followed)
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-5 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($followed->avatar_url)
                                            <img src="{{ $followed->avatar_url }}" 
                                                 alt="{{ $followed->name }}"
                                                 class="w-14 h-14 rounded-full object-cover">
                                        @else
                                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                                {{ strtoupper(substr($followed->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-slate-900 dark:text-white">{{ $followed->name }}</h3>
                                        @if($followed->username)
                                            <p class="text-sm text-slate-500 dark:text-slate-400">@{{ $followed->username }}</p>
                                        @endif
                                        <div class="flex items-center space-x-4 mt-1">
                                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $followed->artworks_count ?? 0 }} artworks
                                            </span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $followed->followers_count ?? 0 }} followers
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <form action="{{ route('member.follow.toggle', $followed->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-800 text-red-600 dark:text-red-400 text-sm rounded-lg transition-colors">
                                        Unfollow
                                    </button>
                                </form>
                            </div>
                            
                            <div class="space-y-3">
                                @if($followed->bio)
                                <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                    {{ $followed->bio }}
                                </p>
                                @endif
                                
                                @php
                                    $recentArtwork = $followed->artworks()->latest()->first();
                                @endphp
                                
                                @if($recentArtwork)
                                <div class="pt-3 border-t border-slate-200 dark:border-slate-700">
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Recent artwork</p>
                                    <a href="{{ route('artworks.show', $recentArtwork->id) }}" 
                                       class="flex items-center space-x-3 group">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-slate-200 dark:bg-slate-700">
                                            <img src="{{ $recentArtwork->image_url }}" 
                                                 alt="{{ $recentArtwork->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-slate-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 truncate">
                                                {{ $recentArtwork->title }}
                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $recentArtwork->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                @endif
                                
                                <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                                    <a href="{{ route('profile.show', $followed->username ?? $followed->id) }}" 
                                       class="text-sm text-purple-600 dark:text-purple-400 hover:underline">
                                        View Profile
                                    </a>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">
                                        Following {{ $followed->pivot->created_at->diffForHumans() ?? 'recently' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($following->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $following->links() }}
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-slate-100 dark:bg-slate-900 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 115 0 2.5 2.5 0 01-5 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-slate-900 dark:text-white mb-3">Not following anyone yet</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                        Discover amazing artists and creators to follow!
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('explore.creators') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg transition-all shadow-lg hover:shadow-xl">
                            Explore Creators
                        </a>
                        <a href="{{ route('explore.featured') }}" 
                           class="px-6 py-3 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            View Featured
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection