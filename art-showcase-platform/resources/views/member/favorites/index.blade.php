{{-- resources/views/member/favorites/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Favorites - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                        My Favorites
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        All artworks you've saved as favorites
                    </p>
                </div>
                <div class="text-sm text-slate-600 dark:text-slate-400">
                    <span class="font-semibold text-purple-600 dark:text-purple-400">{{ $favorites->total() }}</span> favorites
                </div>
            </div>
        </div>

        @if($favorites->count() > 0)
        <!-- Filter Bar -->
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-slate-600 dark:text-slate-400">Sort by:</span>
                <select class="bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option>Recently Added</option>
                    <option>Most Popular</option>
                    <option>Oldest</option>
                </select>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-2 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>
                <div class="flex items-center border border-slate-300 dark:border-slate-700 rounded-lg overflow-hidden">
                    <button class="p-2 bg-white dark:bg-slate-800 border-r border-slate-300 dark:border-slate-700">
                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </button>
                    <button class="p-2 bg-slate-100 dark:bg-slate-700">
                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Artworks Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($favorites as $favorite)
                @if($favorite->artwork)
                <div class="group bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
                    <!-- Artwork Image -->
                    <a href="{{ route('artworks.show', $favorite->artwork->id) }}" class="block">
                        <div class="aspect-square overflow-hidden bg-slate-200 dark:bg-slate-700">
                            <img src="{{ $favorite->artwork->image_url }}" 
                                 alt="{{ $favorite->artwork->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    </a>
                    
                    <!-- Artwork Info -->
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('artworks.show', $favorite->artwork->id) }}" 
                                   class="block">
                                    <h3 class="font-medium text-slate-900 dark:text-white truncate group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                        {{ $favorite->artwork->title }}
                                    </h3>
                                </a>
                                <a href="{{ route('profile.show', $favorite->artwork->user->username ?? $favorite->artwork->user->id) }}" 
                                   class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-300 transition-colors">
                                    by {{ $favorite->artwork->user->name }}
                                </a>
                            </div>
                            <form action="{{ route('member.favorites.store', $favorite->artwork->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <button type="submit" 
                                        class="text-pink-600 dark:text-pink-400 hover:text-pink-800 dark:hover:text-pink-300 transition-colors"
                                        title="Remove from favorites">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Stats -->
                        <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    {{ $favorite->artwork->like_count ?? 0 }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    {{ $favorite->artwork->comment_count ?? 0 }}
                                </span>
                            </div>
                            <span class="text-xs">
                                {{ $favorite->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <!-- Pagination -->
        @if($favorites->hasPages())
        <div class="flex items-center justify-between border-t border-slate-200 dark:border-slate-700 pt-8">
            <div class="text-sm text-slate-600 dark:text-slate-400">
                Showing {{ $favorites->firstItem() }} to {{ $favorites->lastItem() }} of {{ $favorites->total() }} results
            </div>
            <div class="flex space-x-2">
                @if($favorites->onFirstPage())
                    <span class="px-3 py-2 bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 rounded-lg cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $favorites->previousPageUrl() }}" class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Previous
                    </a>
                @endif

                @foreach($favorites->getUrlRange(max(1, $favorites->currentPage() - 2), min($favorites->lastPage(), $favorites->currentPage() + 2)) as $page => $url)
                    @if($page == $favorites->currentPage())
                        <span class="px-3 py-2 bg-purple-600 text-white rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if($favorites->hasMorePages())
                    <a href="{{ $favorites->nextPageUrl() }}" class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Next
                    </a>
                @else
                    <span class="px-3 py-2 bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 rounded-lg cursor-not-allowed">
                        Next
                    </span>
                @endif
            </div>
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-pink-100 dark:bg-pink-900/30 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-medium text-slate-900 dark:text-white mb-4">No favorites yet</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                Start exploring amazing artworks and save your favorites by clicking the heart icon on any artwork.
            </p>
            <div class="space-x-4">
                <a href="{{ route('artworks.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Explore Artworks
                </a>
                <a href="{{ route('explore.creators') }}" 
                   class="inline-flex items-center px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    Discover Artists
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection