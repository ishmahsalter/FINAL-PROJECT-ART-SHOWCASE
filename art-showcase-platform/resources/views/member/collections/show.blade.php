{{-- resources/views/member/collections/show.blade.php --}}
@extends('layouts.app')

@section('title', $collection->name . ' - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Collection Header -->
        <div class="mb-8">
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white">
                            {{ $collection->name }}
                        </h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $collection->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300' }}">
                            {{ $collection->is_public ? 'Public' : 'Private' }}
                        </span>
                    </div>
                    
                    @if($collection->description)
                        <p class="text-slate-600 dark:text-slate-400 mb-4 max-w-3xl">
                            {{ $collection->description }}
                        </p>
                    @endif
                    
                    <div class="flex items-center space-x-6 text-sm text-slate-500 dark:text-slate-400">
                        <span>{{ $collection->artworks->count() }} artworks</span>
                        <span>Created {{ $collection->created_at->diffForHumans() }}</span>
                        @if($collection->updated_at != $collection->created_at)
                            <span>Updated {{ $collection->updated_at->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('member.collections.edit', $collection->id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('member.collections.destroy', $collection->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this collection?')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Collection Content -->
        @if($collection->artworks->count() > 0)
        <div class="mb-8">
            <!-- Grid View -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($collection->artworks as $artwork)
                <div class="group bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
                    <!-- Artwork Image -->
                    <a href="{{ route('artworks.show', $artwork->id) }}" class="block">
                        <div class="aspect-square overflow-hidden bg-slate-200 dark:bg-slate-700">
                            <img src="{{ $artwork->image_url }}" 
                                 alt="{{ $artwork->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    </a>
                    
                    <!-- Artwork Info -->
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('artworks.show', $artwork->id) }}" 
                                   class="block">
                                    <h3 class="font-medium text-slate-900 dark:text-white truncate group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                        {{ $artwork->title }}
                                    </h3>
                                </a>
                                <a href="{{ route('profile.show', $artwork->user->username ?? $artwork->user->id) }}" 
                                   class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-300 transition-colors">
                                    by {{ $artwork->user->name }}
                                </a>
                            </div>
                            
                            <!-- Remove from Collection -->
                            <form action="{{ route('member.collections.remove-artwork', ['collection' => $collection->id, 'artwork' => $artwork->id]) }}" 
                                  method="POST" 
                                  class="flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Remove this artwork from collection?')"
                                        class="p-1 text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition-colors"
                                        title="Remove from collection">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Artwork Stats -->
                        <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    {{ $artwork->like_count ?? 0 }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    {{ $artwork->comment_count ?? 0 }}
                                </span>
                            </div>
                            <span class="text-xs">
                                {{ $artwork->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <!-- Empty Collection State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <h3 class="text-2xl font-medium text-slate-900 dark:text-white mb-4">Collection is empty</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                This collection doesn't have any artworks yet. Start adding your favorite artworks!
            </p>
            <div class="space-x-4">
                <a href="{{ route('artworks.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Explore Artworks
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

        <!-- Back to Collections -->
        <div class="pt-8 border-t border-slate-200 dark:border-slate-700">
            <a href="{{ route('member.collections.index') }}" 
               class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:underline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Collections
            </a>
        </div>
    </div>
</div>
@endsection