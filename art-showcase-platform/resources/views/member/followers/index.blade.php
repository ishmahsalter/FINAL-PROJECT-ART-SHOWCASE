{{-- resources/views/member/followers/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Followers - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-2">
                        My Followers
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        People who follow your creative journey
                    </p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('member.dashboard') }}" 
                       class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        ← Back to Dashboard
                    </a>
                    <a href="{{ route('member.following') }}" 
                       class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                        View Following
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Total Followers</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $followers->total() }}</p>
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
                        <p class="text-sm text-slate-600 dark:text-slate-400">New This Month</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $newFollowersCount ?? 0 }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Mutual Follows</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $mutualFollowersCount ?? 0 }}
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

        <!-- Followers List -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            @if($followers->count() > 0)
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($followers as $follower)
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-5 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($follower->avatar_url)
                                            <img src="{{ $follower->avatar_url }}" 
                                                 alt="{{ $follower->name }}"
                                                 class="w-14 h-14 rounded-full object-cover">
                                        @else
                                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                                {{ strtoupper(substr($follower->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-slate-900 dark:text-white">{{ $follower->name }}</h3>
                                        @if($follower->username)
                                            <p class="text-sm text-slate-500 dark:text-slate-400">@{{ $follower->username }}</p>
                                        @endif
                                        <div class="flex items-center space-x-4 mt-1">
                                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $follower->artworks_count ?? 0 }} artworks
                                            </span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $follower->followers_count ?? 0 }} followers
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                @php
                                    $isFollowingBack = auth()->user()->isFollowing($follower->id);
                                @endphp
                                
                                <form action="{{ route('member.follow.toggle', $follower->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="px-4 py-2 text-sm rounded-lg transition-colors 
                                                {{ $isFollowingBack 
                                                    ? 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-600' 
                                                    : 'bg-purple-600 hover:bg-purple-700 text-white' }}">
                                        {{ $isFollowingBack ? 'Following' : 'Follow Back' }}
                                    </button>
                                </form>
                            </div>
                            
                            <div class="space-y-3">
                                @if($follower->bio)
                                <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                    {{ $follower->bio }}
                                </p>
                                @endif
                                
                                <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                                    <a href="{{ route('profile.show', $follower->username ?? $follower->id) }}" 
                                       class="text-sm text-purple-600 dark:text-purple-400 hover:underline">
                                        View Profile
                                    </a>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">
                                        Followed {{ $follower->pivot->created_at->diffForHumans() ?? 'recently' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($followers->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $followers->links() }}
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-slate-100 dark:bg-slate-900 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-slate-900 dark:text-white mb-3">No followers yet</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                        Share your artwork and engage with the community to get your first followers!
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('member.artworks.create') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg transition-all shadow-lg hover:shadow-xl">
                            Upload Artwork
                        </a>
                        <a href="{{ route('explore.creators') }}" 
                           class="px-6 py-3 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            Explore Community
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection