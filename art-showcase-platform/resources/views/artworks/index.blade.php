<!-- resources/views/artworks/index.blade.php -->
@extends('layouts.app')

@section('title', 'Discover Amazing Artworks | ArtShowcase')

@push('styles')
<style>
/* Import Playfair Display Font */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');

/* OVERRIDE HERO TITLE dengan Playfair Display */
.gallery-hero-title {
    font-family: 'Playfair Display', serif !important;
    font-size: 6rem !important;
    font-weight: 900 !important;
    letter-spacing: -0.03em !important;
    line-height: 1.2 !important;
    margin-bottom: 3rem !important;
    padding-bottom: 2rem !important;
    overflow: visible !important;
    height: auto !important;
}

@media (min-width: 640px) {
    .gallery-hero-title {
        font-size: 8rem !important;
    }
}

@media (min-width: 768px) {
    .gallery-hero-title {
        font-size: 10rem !important;
    }
}

@media (min-width: 1024px) {
    .gallery-hero-title {
        font-size: 12rem !important;
    }
}

@media (min-width: 1280px) {
    .gallery-hero-title {
        font-size: 14rem !important;
    }
}

/* Full Dark Background for Search Section */
.search-dark-bg {
    background: #0f172a !important; /* slate-900 */
}

/* Instagram Style Grid */
.instagram-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.instagram-card {
    background: rgba(30, 41, 59, 0.8); /* slate-800 with opacity */
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.instagram-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.instagram-image {
    aspect-ratio: 1;
    object-fit: cover;
    width: 100%;
    transition: transform 0.5s ease;
}

.instagram-card:hover .instagram-image {
    transform: scale(1.05);
}

/* Instagram Overlay Effects */
.instagram-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-end;
    padding: 20px;
}

.instagram-card:hover .instagram-overlay {
    opacity: 1;
}

.instagram-stats {
    display: flex;
    gap: 20px;
    color: white;
    font-size: 14px;
    font-weight: 600;
}

.instagram-stats-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Quick Actions Bar */
.quick-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 10px;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.instagram-card:hover .quick-actions {
    opacity: 1;
    transform: translateY(0);
}

/* Creator Info */
.creator-info {
    position: absolute;
    top: 15px;
    left: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(10px);
    padding: 8px 12px;
    border-radius: 20px;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.instagram-card:hover .creator-info {
    opacity: 1;
    transform: translateY(0);
}

/* Hover Content */
.hover-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
    padding: 20px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.instagram-card:hover .hover-content {
    transform: translateY(0);
}

/* Floating Animations */
@keyframes float-slow { 
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-30px); }
}

@keyframes float-medium { 
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(20px); }
}

.animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
.animate-float-medium { animation: float-medium 6s ease-in-out infinite; }

/* Gradient Text */
.text-gradient-yellow-pink {
    background: linear-gradient(135deg, #fbbf24, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(15, 23, 42, 0.5);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #fbbf24, #ec4899);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #ec4899, #fbbf24);
}

/* Glassmorphism */
.glass-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .instagram-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .gallery-hero-title {
        font-size: 4rem !important;
    }
}

@media (max-width: 480px) {
    .instagram-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
}

/* Bounce Animation */
@keyframes bounce {
    0%, 100% { transform: translateY(0) translateX(-50%); }
    50% { transform: translateY(-10px) translateX(-50%); }
}

.animate-bounce {
    animation: bounce 2s ease-in-out infinite;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900">

    <!-- HERO SECTION -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900"></div>
        
        <div class="absolute inset-0 opacity-40">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 via-orange-500/20 to-pink-500/20 animate-gradient-shift"></div>
        </div>

        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/3 left-1/4 w-[500px] h-[500px] bg-gradient-to-br from-yellow-400/10 to-orange-500/10 rounded-full filter blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-1/3 right-1/4 w-[450px] h-[450px] bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full filter blur-3xl animate-float-medium"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center overflow-visible">
            <div class="mb-8 md:mb-12">
                <h1 class="gallery-hero-title">
                    <span class="block text-white opacity-90 hover:scale-110 transition-transform duration-300 cursor-default">
                        EXPLORE
                    </span>
                    <span class="block mt-2 md:mt-4 text-gradient-yellow-pink hover:scale-110 transition-transform duration-300 cursor-default">
                        GALLERY
                    </span>
                </h1>
            </div>

            <p class="font-body text-xl sm:text-2xl md:text-3xl lg:text-4xl text-white/80 mb-10 md:mb-14 max-w-4xl mx-auto leading-relaxed font-light px-4">
                Discover extraordinary artworks from talented creators worldwide
            </p>

            <div class="grid grid-cols-3 gap-6 md:gap-10 max-w-3xl mx-auto mb-10 md:mb-16">
                <div class="text-center">
                    <div class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-yellow-400 mb-2">
                        {{ \App\Models\Category::count() ?? 0 }}
                    </div>
                    <div class="font-ui text-sm md:text-lg uppercase tracking-widest text-white/70">Categories</div>
                </div>
                <div class="text-center">
                    <div class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-yellow-400 mb-2">
                        {{ \App\Models\User::where('role', 'member')->count() ?? 0 }}
                    </div>
                    <div class="font-ui text-sm md:text-lg uppercase tracking-widest text-white/70">Creators</div>
                </div>
                <div class="text-center">
                    <div class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-yellow-400 mb-2">
                        {{ $artworks->total() ?? 0 }}
                    </div>
                    <div class="font-ui text-sm md:text-lg uppercase tracking-widest text-white/70">Artworks</div>
                </div>
            </div>

            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg class="w-8 h-8 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- SEARCH & FILTER SECTION (FULL DARK BACKGROUND) -->
    <section class="relative z-20 -mt-20 md:-mt-32 px-4 sm:px-6 search-dark-bg">
        <div class="max-w-5xl mx-auto">
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 backdrop-blur-2xl rounded-3xl p-8 border border-slate-700 shadow-2xl">

                <div class="mb-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                        <h3 class="text-white text-2xl md:text-3xl font-bold flex items-center gap-3">
                            <svg class="w-7 h-7 md:w-8 md:h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            DISCOVER ARTWORKS
                        </h3>

                        <div class="flex flex-wrap justify-center md:justify-end gap-3">
                            @foreach(['latest' => 'Latest', 'popular' => 'Popular', 'trending' => 'Trending'] as $key => $label)
                            <a href="{{ route('artworks.index', array_merge(request()->except('sort'), ['sort' => $key])) }}"
                               class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300
                                      {{ request('sort', 'latest') == $key 
                                         ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 shadow-lg' 
                                         : 'bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                                @switch($key)
                                    @case('latest') ⚡ @break
                                    @case('popular') 🔥 @break
                                    @case('trending') 📈 @break
                                @endswitch
                                {{ $label }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- SEARCH BAR -->
                    <form action="{{ route('artworks.index') }}" method="GET" class="relative">
                        <div class="relative flex items-center">
                            <div class="absolute left-6 pointer-events-none">
                                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search artworks, creators, or tags..."
                                   class="w-full pl-16 pr-48 py-5 bg-slate-800/60 border-2 border-slate-600 rounded-2xl text-white placeholder-slate-400 
                                          focus:outline-none focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 text-lg transition-all duration-300">

                            @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif

                            <button type="submit" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 px-8 py-3.5 bg-gradient-to-r from-yellow-400 to-orange-500 
                                           text-gray-900 font-bold rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-lg">
                                Search
                            </button>
                        </div>
                    </form>

                    <!-- Category Filters -->
                    <div class="mt-6">
                        <div class="flex flex-wrap gap-3 justify-center">
                            <a href="{{ route('artworks.index', array_merge(request()->except('category'), ['search' => request('search')])) }}" 
                               class="px-4 py-2.5 rounded-full border transition-all duration-300 {{ !request('category') ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white border-yellow-400 shadow-lg' : 'border-slate-600 text-slate-300 hover:border-yellow-400 hover:text-white' }}">
                                All Categories
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('artworks.index', array_merge(request()->except('category'), ['category' => $category->id, 'search' => request('search')])) }}" 
                               class="px-4 py-2.5 rounded-full border transition-all duration-300 {{ request('category') == $category->id ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white border-yellow-400 shadow-lg' : 'border-slate-600 text-slate-300 hover:border-yellow-400 hover:text-white' }}">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                @auth
                @if(auth()->user()->role === 'member')
                <div class="text-center pt-6 border-t border-slate-700">
                    <a href="{{ route('member.artworks.create') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-bold rounded-xl 
                              hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload New Artwork
                    </a>
                </div>
                @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- INSTAGRAM STYLE GALLERY GRID -->
    <section class="py-16 md:py-24 relative bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($artworks->count() > 0)
            <!-- Instagram Style Grid -->
            <div class="instagram-grid" x-data="instagramGallery()">
                @foreach($artworks as $artwork)
                <div class="instagram-card group" 
                     x-data="{ hover: false }" 
                     @mouseenter="hover = true" 
                     @mouseleave="hover = false"
                     onclick="window.location.href='{{ route('artworks.show', $artwork) }}'"
                     style="animation-delay: {{ $loop->index * 0.1 }}s">

                    <!-- Quick Actions (Like, Favorite) -->
                    <div class="quick-actions">
                        @auth
                            <!-- Like Button -->
                            <form action="{{ route('artworks.like', $artwork) }}" method="POST" class="like-form">
                                @csrf
                                <button type="submit" class="p-2.5 bg-black/80 backdrop-blur-sm rounded-full hover:bg-black transition-colors">
                                    <svg class="w-5 h-5 {{ $artwork->isLikedBy(auth()->user()) ? 'text-red-500 fill-red-500' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </form>
                            
                            <!-- Favorite Button -->
                            <form action="{{ route('artworks.favorite', $artwork) }}" method="POST" class="favorite-form">
                                @csrf
                                <button type="submit" class="p-2.5 bg-black/80 backdrop-blur-sm rounded-full hover:bg-black transition-colors">
                                    <svg class="w-5 h-5 {{ $artwork->isFavoritedBy(auth()->user()) ? 'text-yellow-400 fill-yellow-400' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                </button>
                            </form>
                        @endauth
                    </div>

                    <!-- Creator Info -->
                    <div class="creator-info">
                        @if($artwork->user->avatar)
                        <img src="{{ Storage::url($artwork->user->avatar) }}" 
                             alt="{{ $artwork->user->name }}"
                             class="w-8 h-8 rounded-full object-cover">
                        @else
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-yellow-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($artwork->user->name, 0, 1) }}
                        </div>
                        @endif
                        <span class="text-white text-sm font-medium">{{ $artwork->user->name }}</span>
                    </div>

                    <!-- Artwork Image -->
                    <div class="relative overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900">
                        <img src="{{ Storage::url($artwork->image_path) }}" 
                             alt="{{ $artwork->title }}"
                             class="instagram-image"
                             loading="lazy">
                    </div>

                    <!-- Hover Overlay with Stats -->
                    <div class="instagram-overlay">
                        <div class="w-full">
                            <!-- Artwork Title -->
                            <h3 class="text-white font-bold text-lg mb-3 line-clamp-1">
                                {{ $artwork->title }}
                            </h3>
                            
                            <!-- Stats -->
                            <div class="instagram-stats">
                                <div class="instagram-stats-item">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $artwork->likes_count ?? 0 }}</span>
                                </div>
                                
                                <div class="instagram-stats-item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span>{{ $artwork->comments_count ?? 0 }}</span>
                                </div>
                                
                                <div class="instagram-stats-item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>{{ $artwork->views ?? 0 }}</span>
                                </div>
                            </div>
                            
                            <!-- View Button -->
                            <div class="mt-4">
                                <a href="{{ route('artworks.show', $artwork) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-sm font-bold rounded-lg hover:shadow-lg transition-all transform hover:scale-105">
                                    View Details
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Category Badge -->
                    @if($artwork->category)
                    <div class="absolute bottom-4 left-4">
                        <span class="px-3 py-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-bold rounded-full">
                            {{ $artwork->category->name }}
                        </span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($artworks->hasPages())
            <div class="mt-16">
                <div class="flex justify-center">
                    {{ $artworks->onEachSide(1)->links('vendor.pagination.instagram') }}
                </div>
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-slate-800/50 to-slate-900/50 rounded-3xl flex items-center justify-center border border-slate-700/30">
                    <svg class="w-20 h-20 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">No artworks found</h3>
                <p class="text-slate-300 mb-8 max-w-md mx-auto">
                    @if(request('search') || request('category'))
                    Try adjusting your search or filter criteria
                    @else
                    Be the first to showcase your artwork!
                    @endif
                </p>
                @auth
                @if(auth()->user()->role === 'member')
                <a href="{{ route('artworks.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-bold rounded-xl hover:shadow-[0_0_30px_rgba(245,158,11,0.3)] transition-all transform hover:-translate-y-1">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Upload Your First Artwork
                </a>
                @endif
                @endauth
            </div>
            @endif
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="py-20 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(251, 191, 36, 0.2) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-32 w-64 h-64 bg-gradient-to-r from-yellow-400/10 to-orange-500/10 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-1/4 -right-32 w-64 h-64 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-full blur-3xl animate-float-medium"></div>
        </div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6">
                Ready to <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">Showcase</span> Your Art?
            </h2>
            
            <p class="text-xl text-purple-200 max-w-2xl mx-auto mb-10">
                Join our community of talented creators and get your work discovered by thousands
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                @auth
                    @if(auth()->user()->role === 'member')
                        <a href="{{ route('member.artworks.create') }}"
                           class="group relative px-10 py-5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 shadow-[0_0_40px_rgba(245,158,11,0.3)]">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                🎨 UPLOAD ARTWORK
                                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500 animate-gradient-x"></div>
                        </a>
                        
                        <a href="{{ route('challenges.index') }}?status=active"
                           class="group relative px-10 py-5 bg-gradient-to-br from-purple-600 to-indigo-700 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 border-2 border-purple-500/30 hover:border-yellow-400">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                🏆 JOIN CHALLENGES
                                <svg class="w-6 h-6 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-md"></div>
                        </a>
                    @endif
                @else
                    <!-- For Guests: Join Platform -->
                    <a href="{{ route('register') }}"
                       class="group relative px-10 py-5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 shadow-[0_0_40px_rgba(245,158,11,0.3)]">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            ✨ JOIN FOR FREE
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500 animate-gradient-x"></div>
                    </a>
                    
                    <!-- Explore Gallery -->
                    <a href="{{ route('artworks.index') }}"
                       class="group relative px-10 py-5 bg-gradient-to-br from-purple-600 to-indigo-700 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 border-2 border-purple-500/30 hover:border-yellow-400">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            🔍 EXPLORE GALLERY
                            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-md"></div>
                    </a>
                @endauth
            </div>
            
            <!-- Additional Stats -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">{{ $artworks->total() ?? 0 }}</div>
                    <div class="text-sm text-purple-300 mt-2">Artworks</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">{{ \App\Models\User::where('role', 'member')->count() ?? 0 }}</div>
                    <div class="text-sm text-purple-300 mt-2">Creators</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">{{ \App\Models\Category::count() ?? 0 }}</div>
                    <div class="text-sm text-purple-300 mt-2">Categories</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">100%</div>
                    <div class="text-sm text-purple-300 mt-2">Community Driven</div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// Instagram Gallery Effects
function instagramGallery() {
    return {
        init() {
            // Add staggered animation delays
            this.$nextTick(() => {
                const cards = this.$el.querySelectorAll('.instagram-card');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                });
            });
        }
    };
}

// Handle form submissions for like/favorite
document.addEventListener('DOMContentLoaded', function() {
    // Prevent card click when clicking on forms
    document.querySelectorAll('.like-form, .favorite-form').forEach(form => {
        form.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
    
    // Handle like form submissions with AJAX
    document.querySelectorAll('.like-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const button = this.querySelector('button');
            const svg = button.querySelector('svg');
            const formData = new FormData(this);
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Toggle like state
                    if (data.liked) {
                        svg.classList.add('text-red-500', 'fill-red-500');
                        svg.classList.remove('text-white');
                    } else {
                        svg.classList.remove('text-red-500', 'fill-red-500');
                        svg.classList.add('text-white');
                    }
                    
                    // Find and update like count
                    const card = this.closest('.instagram-card');
                    const likeCountSpan = card.querySelector('.instagram-stats-item:nth-child(1) span');
                    if (likeCountSpan) {
                        likeCountSpan.textContent = data.likes_count;
                    }
                }
            } catch (error) {
                console.error('Error liking artwork:', error);
            }
        });
    });
    
    // Handle favorite form submissions with AJAX
    document.querySelectorAll('.favorite-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const button = this.querySelector('button');
            const svg = button.querySelector('svg');
            const formData = new FormData(this);
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Toggle favorite state
                    if (data.favorited) {
                        svg.classList.add('text-yellow-400', 'fill-yellow-400');
                        svg.classList.remove('text-white');
                    } else {
                        svg.classList.remove('text-yellow-400', 'fill-yellow-400');
                        svg.classList.add('text-white');
                    }
                }
            } catch (error) {
                console.error('Error favoriting artwork:', error);
            }
        });
    });
});
</script>
@endpush