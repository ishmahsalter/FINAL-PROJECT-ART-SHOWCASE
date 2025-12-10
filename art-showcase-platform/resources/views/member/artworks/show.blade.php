@extends('layouts.app')

@section('title', $artwork->title . ' | ArtShowcase')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    
    <!-- HEADER -->
    <div class="bg-gradient-to-r from-slate-800/80 to-purple-800/80 backdrop-blur-lg border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <a href="{{ route('member.artworks.index') }}" 
                       class="inline-flex items-center gap-2 text-slate-300 hover:text-white mb-4 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Artworks
                    </a>
                    
                    <h1 class="text-3xl font-bold text-white mb-2">
                        {{ $artwork->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-4">
                        <!-- STATUS BADGE -->
                        @switch($artwork->status)
                            @case('published')
                                <span class="px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-bold rounded-full">
                                    Published
                                </span>
                                @break
                            @case('draft')
                                <span class="px-3 py-1 bg-gradient-to-r from-slate-500 to-slate-600 text-white text-sm font-bold rounded-full">
                                    Draft
                                </span>
                                @break
                            @case('pending_review')
                                <span class="px-3 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-sm font-bold rounded-full">
                                    Pending Review
                                </span>
                                @break
                        @endswitch
                        
                        <!-- VISIBILITY BADGE -->
                        @switch($artwork->visibility)
                            @case('public')
                                <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-sm font-bold rounded-full">
                                    Public
                                </span>
                                @break
                            @case('private')
                                <span class="px-3 py-1 bg-gradient-to-r from-slate-600 to-slate-700 text-white text-sm font-bold rounded-full">
                                    Private
                                </span>
                                @break
                            @case('unlisted')
                                <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-sm font-bold rounded-full">
                                    Unlisted
                                </span>
                                @break
                        @endswitch
                        
                        <!-- CATEGORY -->
                        @if($artwork->category)
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-slate-700/50 text-slate-300 text-sm rounded-full">
                            {{ $artwork->category->name }}
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- STATS -->
                    <div class="hidden md:flex items-center gap-6 bg-slate-800/50 backdrop-blur-sm rounded-xl px-6 py-3">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-400">{{ $artwork->likes_count ?? 0 }}</div>
                            <div class="text-xs text-slate-300">Likes</div>
                        </div>
                        <div class="h-8 w-px bg-slate-600"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-400">{{ $artwork->comments_count ?? 0 }}</div>
                            <div class="text-xs text-slate-300">Comments</div>
                        </div>
                        <div class="h-8 w-px bg-slate-600"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400">{{ $artwork->views ?? 0 }}</div>
                            <div class="text-xs text-slate-300">Views</div>
                        </div>
                    </div>
                    
                    <!-- ACTION BUTTONS -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('member.artworks.edit', $artwork) }}"
                           class="px-6 py-3 bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-600 hover:to-slate-700 text-white font-medium rounded-xl transition-all">
                            Edit
                        </a>
                        
                        <a href="{{ route('artworks.show', $artwork) }}" target="_blank"
                           class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold rounded-xl transition-all">
                            View Public Page
                        </a>
                    </div>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- LEFT COLUMN: ARTWORK IMAGE -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-sm rounded-2xl border border-slate-700/50 overflow-hidden">
                    <div class="aspect-square bg-gradient-to-br from-slate-900 to-purple-900 flex items-center justify-center">
                        <img src="{{ $artwork->image_url ?? Storage::url($artwork->image_path) }}" 
                             alt="{{ $artwork->title }}"
                             class="max-w-full max-h-full object-contain p-4">
                    </div>
                    
                    <!-- IMAGE ACTIONS -->
                    <div class="p-6 border-t border-slate-700/50">
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ $artwork->image_url ?? Storage::url($artwork->image_path) }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download Full Size
                            </a>
                            
                            <button onclick="navigator.clipboard.writeText('{{ route('artworks.show', $artwork) }}')"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Copy Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT COLUMN: DETAILS -->
            <div class="space-y-6">
                <!-- DESCRIPTION CARD -->
                <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-sm rounded-2xl border border-slate-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Description</h3>
                    
                    @if($artwork->description)
                    <div class="prose prose-invert max-w-none">
                        <p class="text-slate-300 whitespace-pre-line">{{ $artwork->description }}</p>
                    </div>
                    @else
                    <p class="text-slate-400 italic">No description provided.</p>
                    @endif
                    
                    <!-- MEDIA USED -->
                    @if($artwork->media_used)
                    <div class="mt-6 pt-6 border-t border-slate-700/50">
                        <h4 class="text-sm font-medium text-slate-300 mb-2">Media Used</h4>
                        <p class="text-white">{{ $artwork->media_used }}</p>
                    </div>
                    @endif
                </div>
                
                <!-- TAGS CARD -->
                @if($artwork->tags && count($artwork->tags) > 0)
                <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-sm rounded-2xl border border-slate-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($artwork->tags as $tag)
                        <span class="px-3 py-1.5 bg-slate-700/50 text-slate-300 text-sm rounded-lg">
                            {{ $tag }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- METADATA CARD -->
                <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-sm rounded-2xl border border-slate-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Artwork Details</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-slate-300 mb-1">Uploaded</h4>
                            <p class="text-white">{{ $artwork->created_at->format('F d, Y') }}</p>
                            <p class="text-sm text-slate-400">{{ $artwork->created_at->diffForHumans() }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-slate-300 mb-1">Last Updated</h4>
                            <p class="text-white">{{ $artwork->updated_at->format('F d, Y') }}</p>
                            <p class="text-sm text-slate-400">{{ $artwork->updated_at->diffForHumans() }}</p>
                        </div>
                        
                        @if($artwork->published_at)
                        <div>
                            <h4 class="text-sm font-medium text-slate-300 mb-1">Published</h4>
                            <p class="text-white">{{ $artwork->published_at->format('F d, Y') }}</p>
                            <p class="text-sm text-slate-400">{{ $artwork->published_at->diffForHumans() }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <h4 class="text-sm font-medium text-slate-300 mb-1">Image File</h4>
                            <p class="text-white truncate" title="{{ $artwork->image_path }}">
                                {{ basename($artwork->image_path) }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- ACTIONS CARD -->
                <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-sm rounded-2xl border border-slate-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('member.artworks.edit', $artwork) }}"
                           class="flex items-center gap-3 w-full p-3 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Edit Artwork</span>
                        </a>
                        
                        <a href="{{ route('artworks.show', $artwork) }}" target="_blank"
                           class="flex items-center gap-3 w-full p-3 bg-gradient-to-r from-yellow-500/20 to-orange-500/20 hover:from-yellow-500/30 hover:to-orange-500/30 border border-yellow-500/30 text-yellow-400 hover:text-yellow-300 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>View Public Page</span>
                        </a>
                        
                        <form action="{{ route('member.artworks.destroy', $artwork) }}" method="POST" 
                              class="delete-form" data-title="{{ $artwork->title }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="flex items-center gap-3 w-full p-3 bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-400 hover:text-red-300 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Delete Artwork</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

// Copy link feedback
document.querySelector('button[onclick*="copyText"]')?.addEventListener('click', function() {
    const originalText = this.innerHTML;
    this.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Copied!';
    
    setTimeout(() => {
        this.innerHTML = originalText;
    }, 2000);
});
</script>
@endpush