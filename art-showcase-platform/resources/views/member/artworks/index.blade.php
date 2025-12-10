@extends('layouts.app')

@section('title', 'My Artworks | ArtShowcase')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    
    <!-- HEADER -->
    <div class="bg-gradient-to-r from-slate-800/80 to-purple-800/80 backdrop-blur-lg border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                        My Artworks
                    </h1>
                    <p class="text-slate-300">
                        Manage your creative portfolio
                    </p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-4 bg-slate-800/50 backdrop-blur-sm rounded-xl px-4 py-2">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400">{{ $artworks->total() }}</div>
                            <div class="text-xs text-slate-300">Total</div>
                        </div>
                        <div class="h-8 w-px bg-slate-600"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-400">
                                {{ $artworks->where('status', 'published')->count() }}
                            </div>
                            <div class="text-xs text-slate-300">Published</div>
                        </div>
                        <div class="h-8 w-px bg-slate-600"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-400">
                                {{ $artworks->where('status', 'draft')->count() }}
                            </div>
                            <div class="text-xs text-slate-300">Draft</div>
                        </div>
                    </div>
                    
                    <a href="{{ route('member.artworks.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-bold rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload New Artwork
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 rounded-xl">
            <div class="flex items-center gap-3 text-green-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if($artworks->isEmpty())
        <!-- EMPTY STATE -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-slate-800 to-purple-800 rounded-2xl flex items-center justify-center border border-slate-700">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">No artworks yet</h3>
            <p class="text-slate-300 mb-8 max-w-md mx-auto">
                Start building your portfolio by uploading your first artwork.
            </p>
            <a href="{{ route('member.artworks.create') }}"
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-bold rounded-xl hover:shadow-[0_0_30px_rgba(245,158,11,0.3)] transition-all transform hover:-translate-y-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Upload Your First Artwork
            </a>
        </div>
        @else
        <!-- ARTWORKS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($artworks as $artwork)
            <div class="group bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-sm rounded-2xl border border-slate-700/50 overflow-hidden hover:border-yellow-500/30 transition-all duration-300 hover:transform hover:-translate-y-1">
                
                <!-- ARTWORK IMAGE -->
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-slate-900 to-purple-900">
                    <img src="{{ $artwork->image_url ?? Storage::url($artwork->image_path) }}" 
                         alt="{{ $artwork->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    <!-- STATUS BADGE -->
                    <div class="absolute top-3 left-3">
                        @switch($artwork->status)
                            @case('published')
                                <span class="px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-bold rounded-full">
                                    Published
                                </span>
                                @break
                            @case('draft')
                                <span class="px-3 py-1 bg-gradient-to-r from-slate-500 to-slate-600 text-white text-xs font-bold rounded-full">
                                    Draft
                                </span>
                                @break
                            @case('pending_review')
                                <span class="px-3 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold rounded-full">
                                    Pending
                                </span>
                                @break
                        @endswitch
                    </div>
                    
                    <!-- VISIBILITY BADGE -->
                    <div class="absolute top-3 right-3">
                        @switch($artwork->visibility)
                            @case('public')
                                <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs font-bold rounded-full">
                                    Public
                                </span>
                                @break
                            @case('private')
                                <span class="px-3 py-1 bg-gradient-to-r from-slate-600 to-slate-700 text-white text-xs font-bold rounded-full">
                                    Private
                                </span>
                                @break
                            @case('unlisted')
                                <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold rounded-full">
                                    Unlisted
                                </span>
                                @break
                        @endswitch
                    </div>
                </div>
                
                <!-- ARTWORK INFO -->
                <div class="p-5">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-bold text-white text-lg truncate" title="{{ $artwork->title }}">
                            {{ $artwork->title }}
                        </h3>
                        
                        <!-- QUICK ACTIONS -->
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('member.artworks.edit', $artwork) }}"
                               class="p-2 bg-slate-700/50 hover:bg-slate-600/50 rounded-lg transition-colors"
                               title="Edit">
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            
                            <form action="{{ route('member.artworks.destroy', $artwork) }}" method="POST" 
                                  class="delete-form" data-title="{{ $artwork->title }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-500/20 hover:bg-red-500/30 rounded-lg transition-colors"
                                        title="Delete">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <p class="text-slate-300 text-sm line-clamp-2 mb-4">
                        {{ $artwork->description ?: 'No description provided.' }}
                    </p>
                    
                    <!-- CATEGORY -->
                    @if($artwork->category)
                    <div class="mb-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-slate-700/50 rounded-full">
                            <svg class="w-3 h-3 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-xs text-slate-300">{{ $artwork->category->name }}</span>
                        </span>
                    </div>
                    @endif
                    
                    <!-- STATS -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-700/50">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-slate-300">{{ $artwork->likes_count ?? 0 }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span class="text-sm text-slate-300">{{ $artwork->comments_count ?? 0 }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span class="text-sm text-slate-300">{{ $artwork->views ?? 0 }}</span>
                            </div>
                        </div>
                        
                        <!-- VIEW BUTTON -->
                        <a href="{{ route('artworks.show', $artwork) }}"
                           class="text-xs font-medium text-yellow-400 hover:text-yellow-300 transition-colors">
                            View →
                        </a>
                    </div>
                    
                    <!-- UPDATED TIME -->
                    <div class="mt-3 text-xs text-slate-400">
                        Updated {{ $artwork->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- PAGINATION -->
        @if($artworks->hasPages())
        <div class="mt-8">
            {{ $artworks->links('vendor.pagination.custom') }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Delete confirmation
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const title = this.getAttribute('data-title');
        
        if (confirm(`Are you sure you want to delete "${title}"? This action cannot be undone.`)) {
            this.submit();
        }
    });
});
</script>
@endpush