{{-- resources/views/member/collections/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Collections - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                        My Collections
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        Organize your favorite artworks into themed collections
                    </p>
                </div>
                <a href="{{ route('member.collections.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Collection
                </a>
            </div>
        </div>

        @if($collections->count() > 0)
        <!-- Collections Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($collections as $collection)
            <div class="group bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
                <!-- Collection Cover -->
                <a href="{{ route('member.collections.show', $collection->id) }}" class="block">
                    <div class="aspect-square overflow-hidden bg-gradient-to-br from-purple-500 to-pink-500">
                        @if($collection->cover_image)
                            <img src="{{ $collection->cover_image }}" 
                                 alt="{{ $collection->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @elseif($collection->artworks->count() > 0)
                            <div class="grid grid-cols-2 gap-1 p-1 w-full h-full">
                                @foreach($collection->artworks->take(4) as $artwork)
                                <div class="overflow-hidden">
                                    <img src="{{ $artwork->image_url }}" 
                                         alt="{{ $artwork->title }}"
                                         class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </a>
                
                <!-- Collection Info -->
                <div class="p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('member.collections.show', $collection->id) }}" 
                               class="block">
                                <h3 class="font-medium text-slate-900 dark:text-white truncate group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                    {{ $collection->name }}
                                </h3>
                            </a>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                {{ $collection->artworks_count }} artworks
                            </p>
                        </div>
                        
                        <!-- Collection Menu -->
                        <div class="relative flex-shrink-0" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="p-1 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 py-1 z-10">
                                <a href="{{ route('member.collections.edit', $collection->id) }}" 
                                   class="flex items-center px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('member.collections.destroy', $collection->id) }}" method="POST" class="block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this collection?')"
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-slate-100 dark:hover:bg-slate-700">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Collection Description -->
                    @if($collection->description)
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-3 line-clamp-2">
                            {{ $collection->description }}
                        </p>
                    @endif
                    
                    <!-- Collection Visibility -->
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                            {{ $collection->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300' }}">
                            {{ $collection->is_public ? 'Public' : 'Private' }}
                        </span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            {{ $collection->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($collections->hasPages())
        <div class="flex items-center justify-between border-t border-slate-200 dark:border-slate-700 pt-8">
            <div class="text-sm text-slate-600 dark:text-slate-400">
                Showing {{ $collections->firstItem() }} to {{ $collections->lastItem() }} of {{ $collections->total() }} results
            </div>
            <div class="flex space-x-2">
                @if($collections->onFirstPage())
                    <span class="px-3 py-2 bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 rounded-lg cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $collections->previousPageUrl() }}" class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Previous
                    </a>
                @endif

                @foreach($collections->getUrlRange(max(1, $collections->currentPage() - 2), min($collections->lastPage(), $collections->currentPage() + 2)) as $page => $url)
                    @if($page == $collections->currentPage())
                        <span class="px-3 py-2 bg-purple-600 text-white rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if($collections->hasMorePages())
                    <a href="{{ $collections->nextPageUrl() }}" class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
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
            <div class="w-24 h-24 mx-auto mb-6 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-2xl font-medium text-slate-900 dark:text-white mb-4">No collections yet</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                Create your first collection to organize and save your favorite artworks in one place.
            </p>
            <div class="space-x-4">
                <a href="{{ route('member.collections.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Collection
                </a>
                <a href="{{ route('member.favorites.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    Browse Favorites
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection