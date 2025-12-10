{{-- resources/views/artworks/show.blade.php --}}
@extends('layouts.app')

@section('title', $artwork->title . ' | ArtShowcase')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');

/* Glassmorphism Effects */
.glass-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.glass-dark {
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Gradient Text */
.text-gradient-yellow-pink {
    background: linear-gradient(135deg, #fbbf24, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.text-gradient-purple-pink {
    background: linear-gradient(135deg, #8b5cf6, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

@keyframes pulse-glow {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 1; }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-pulse-glow {
    animation: pulse-glow 2s ease-in-out infinite;
}

.animate-slide-up {
    animation: slideUp 0.6s ease-out;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #fbbf24, #ec4899);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #ec4899, #fbbf24);
}

/* Selection */
::selection {
    background: rgba(245, 158, 11, 0.3);
    color: white;
}

/* Image Hover Effects */
.artwork-image {
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

.artwork-image:hover {
    transform: scale(1.02);
}

/* Button Animations */
.btn-hover-glow {
    position: relative;
    overflow: hidden;
}

.btn-hover-glow::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.btn-hover-glow:hover::after {
    left: 100%;
}

/* Like Animation */
@keyframes heartBeat {
    0% { transform: scale(1); }
    14% { transform: scale(1.3); }
    28% { transform: scale(1); }
    42% { transform: scale(1.3); }
    70% { transform: scale(1); }
}

.heart-beat {
    animation: heartBeat 1.2s ease-in-out;
}

/* Comment Animation */
.comment-enter {
    animation: slideUp 0.5s ease-out;
}

/* Shimmer Effect */
.shimmer {
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    background-size: 200% 100%;
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* Progress Bar */
.progress-bar {
    background: linear-gradient(90deg, #8b5cf6, #ec4899, #fbbf24);
    background-size: 200% 100%;
    animation: gradient-x 3s ease infinite;
}

@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Badge Glow */
.badge-glow {
    box-shadow: 0 0 20px rgba(245, 158, 11, 0.5);
}

/* Line Clamp */
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

/* Loading Skeleton */
.skeleton {
    background: linear-gradient(90deg, rgba(255,255,255,0.1) 25%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0.1) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
}

/* Responsive Typography */
@media (max-width: 640px) {
    .text-responsive-4xl {
        font-size: 1.875rem !important;
    }
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900">
    
    <!-- Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-gradient-to-br from-yellow-400/10 to-orange-500/10 rounded-full filter blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 -right-32 w-96 h-96 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full filter blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-br from-indigo-500/5 to-pink-500/5 rounded-full filter blur-3xl animate-pulse-glow"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10">
        <!-- Hero Section -->
        <section class="relative pt-8 md:pt-12 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <div class="flex items-center space-x-2 text-sm">
                        <a href="{{ route('home') }}" class="text-purple-300 hover:text-white transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Home
                        </a>
                        <span class="text-purple-400">›</span>
                        <a href="{{ route('artworks.index') }}" class="text-purple-300 hover:text-white transition-colors">Artworks</a>
                        <span class="text-purple-400">›</span>
                        <span class="text-white font-medium truncate max-w-[200px]">{{ $artwork->title }}</span>
                    </div>
                </nav>

                <!-- Artwork Display Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-slide-up">
                    <!-- Artwork Image Column -->
                    <div class="lg:col-span-2">
                        <!-- Main Image Container -->
                        <div class="relative bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl overflow-hidden border border-purple-500/30 shadow-2xl group">
                            <!-- Image -->
                            <div class="aspect-square md:aspect-[4/3] bg-gradient-to-br from-purple-950 to-indigo-950">
                                <img src="{{ Storage::url($artwork->image_path) }}" 
                                     alt="{{ $artwork->title }}"
                                     class="w-full h-full object-contain p-4 md:p-8 artwork-image"
                                     id="main-artwork-image">
                            </div>
                            
                            <!-- Overlay Controls -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <div class="absolute bottom-6 left-6 right-6 flex justify-between items-center">
                                    <!-- Zoom Controls -->
                                    <div class="flex gap-2">
                                        <button onclick="zoomIn()"
                                                class="w-12 h-12 glass-dark rounded-xl flex items-center justify-center text-white hover:text-yellow-400 hover:scale-110 transition-all transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                            </svg>
                                        </button>
                                        <button onclick="zoomOut()"
                                                class="w-12 h-12 glass-dark rounded-xl flex items-center justify-center text-white hover:text-yellow-400 hover:scale-110 transition-all transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Download Button -->
                                    @if($artwork->allow_download)
                                    <a href="{{ Storage::url($artwork->image_path) }}" 
                                       download="{{ Str::slug($artwork->title) }}.jpg"
                                       class="flex items-center gap-2 px-4 py-3 glass-dark rounded-xl text-white hover:text-yellow-400 hover:scale-105 transition-all transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        <span class="font-semibold text-sm">Download</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Category Badge -->
                            @if($artwork->category)
                            <div class="absolute top-6 left-6">
                                <span class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 text-sm font-bold rounded-full badge-glow flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $artwork->category->name }}
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Additional Images -->
                        @if($artwork->hasAdditionalImages())
                        <div class="mt-6">
                            <h3 class="text-white text-lg font-bold mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Additional Views
                            </h3>
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($artwork->additional_images as $index => $image)
                                <button onclick="changeImage('{{ Storage::url($image) }}')"
                                        class="aspect-square rounded-xl overflow-hidden border-2 border-purple-500/30 hover:border-yellow-400 transition-all duration-300 transform hover:scale-105">
                                    <img src="{{ Storage::url($image) }}" 
                                         alt="View {{ $index + 1 }}"
                                         class="w-full h-full object-cover">
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Artwork Info Column -->
                    <div class="space-y-6">
                        <!-- Artwork Header -->
                        <div class="glass-card rounded-3xl p-6 shadow-2xl">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex-1">
                                    <h1 class="font-['Playfair_Display'] text-3xl md:text-4xl font-bold text-white mb-3 line-clamp-2">
                                        {{ $artwork->title }}
                                    </h1>
                                    <div class="flex items-center gap-2 text-purple-300 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Uploaded {{ $artwork->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                
                                <!-- Actions Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                            class="w-10 h-10 glass-dark rounded-xl flex items-center justify-center text-white hover:text-yellow-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 mt-2 w-56 glass-dark rounded-xl shadow-2xl py-2 z-50 border border-purple-500/30">
                                        @auth
                                            @if(auth()->id() === $artwork->user_id)
                                                <a href="{{ route('member.artworks.edit', $artwork->id) }}"
                                                   class="flex items-center px-4 py-3 text-white hover:bg-white/5 transition-colors">
                                                    <svg class="w-5 h-5 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit Artwork
                                                </a>
                                                <button onclick="confirmDelete()"
                                                        class="flex items-center w-full px-4 py-3 text-red-400 hover:bg-white/5 transition-colors">
                                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete Artwork
                                                </button>
                                            @else
                                                <button onclick="openReportModal('artwork', {{ $artwork->id }})"
                                                        class="flex items-center w-full px-4 py-3 text-red-400 hover:bg-white/5 transition-colors">
                                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                                    </svg>
                                                    Report Artwork
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}"
                                               class="flex items-center px-4 py-3 text-white hover:bg-white/5 transition-colors">
                                                <svg class="w-5 h-5 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                                </svg>
                                                Login to interact
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Creator Info -->
                            <div class="flex items-center gap-4 mb-6 p-4 bg-gradient-to-r from-purple-900/30 to-indigo-900/30 rounded-2xl border border-purple-500/30">
                                <a href="{{ route('profile.show', $artwork->user->username ?? $artwork->user->id) }}"
                                   class="flex items-center gap-4 group flex-1">
                                    <div class="relative">
                                        @if($artwork->user->avatar)
                                        <img src="{{ Storage::url($artwork->user->avatar) }}" 
                                             alt="{{ $artwork->user->name }}"
                                             class="w-14 h-14 rounded-full object-cover border-2 border-purple-500 group-hover:border-yellow-400 transition-colors">
                                        @else
                                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-xl group-hover:scale-110 transition-transform">
                                            {{ substr($artwork->user->name, 0, 1) }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-white group-hover:text-yellow-300 transition-colors">
                                            {{ $artwork->user->name }}
                                        </div>
                                        <div class="text-purple-300 text-sm flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $artwork->user->role === 'member' ? 'Creator' : ucfirst($artwork->user->role) }}
                                        </div>
                                    </div>
                                </a>
                                
                                <!-- Follow Button -->
                                @auth
                                    @if(auth()->id() !== $artwork->user_id)
                                    <button onclick="toggleFollow({{ $artwork->user->id }})"
                                            id="follow-btn-{{ $artwork->user->id }}"
                                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white text-sm font-bold rounded-xl transition-all transform hover:scale-105">
                                        Follow
                                    </button>
                                    @endif
                                @endauth
                            </div>
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="text-center p-4 glass-dark rounded-2xl hover:scale-105 transition-transform">
                                    <div class="text-2xl font-bold text-white mb-1">{{ $artwork->likes_count }}</div>
                                    <div class="text-purple-300 text-sm">Likes</div>
                                </div>
                                <div class="text-center p-4 glass-dark rounded-2xl hover:scale-105 transition-transform">
                                    <div class="text-2xl font-bold text-white mb-1">{{ $artwork->comments_count }}</div>
                                    <div class="text-purple-300 text-sm">Comments</div>
                                </div>
                                <div class="text-center p-4 glass-dark rounded-2xl hover:scale-105 transition-transform">
                                    <div class="text-2xl font-bold text-white mb-1">{{ $artwork->views }}</div>
                                    <div class="text-purple-300 text-sm">Views</div>
                                </div>
                            </div>
                            
                            <!-- Interaction Buttons -->
                            <div class="grid grid-cols-2 gap-3">
                                @auth
                                    <!-- Like Button -->
                                    <button onclick="toggleLike({{ $artwork->id }})"
                                            id="like-btn-{{ $artwork->id }}"
                                            class="flex items-center justify-center gap-3 px-6 py-4 glass-dark rounded-xl hover:border-yellow-400 transition-all transform hover:scale-105 btn-hover-glow {{ $artwork->isLikedBy(auth()->user()) ? 'border-yellow-400' : 'border-purple-500/30' }}">
                                        <svg id="like-icon-{{ $artwork->id }}" 
                                             class="w-6 h-6 {{ $artwork->isLikedBy(auth()->user()) ? 'text-yellow-400 fill-current' : 'text-purple-300' }}" 
                                             fill="{{ $artwork->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" 
                                             stroke="currentColor" 
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <span class="font-bold {{ $artwork->isLikedBy(auth()->user()) ? 'text-yellow-400' : 'text-white' }}">
                                            <span id="like-count-{{ $artwork->id }}">{{ $artwork->likes_count }}</span> Likes
                                        </span>
                                    </button>
                                    
                                    <!-- Favorite Button -->
                                    <button onclick="toggleFavorite({{ $artwork->id }})"
                                            id="favorite-btn-{{ $artwork->id }}"
                                            class="flex items-center justify-center gap-3 px-6 py-4 glass-dark rounded-xl hover:border-pink-400 transition-all transform hover:scale-105 btn-hover-glow {{ $artwork->isFavoritedBy(auth()->user()) ? 'border-pink-400' : 'border-purple-500/30' }}">
                                        <svg id="favorite-icon-{{ $artwork->id }}"
                                             class="w-6 h-6 {{ $artwork->isFavoritedBy(auth()->user()) ? 'text-pink-400 fill-current' : 'text-purple-300' }}"
                                             fill="{{ $artwork->isFavoritedBy(auth()->user()) ? 'currentColor' : 'none' }}" 
                                             stroke="currentColor" 
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                        <span class="font-bold {{ $artwork->isFavoritedBy(auth()->user()) ? 'text-pink-400' : 'text-white' }}">
                                            Favorite
                                        </span>
                                    </button>
                                    
                                    <!-- Share Button -->
                                    <button onclick="shareArtwork()"
                                            class="flex items-center justify-center gap-3 px-6 py-4 glass-dark rounded-xl hover:border-purple-400 transition-all transform hover:scale-105 btn-hover-glow border-purple-500/30">
                                        <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                        <span class="font-bold text-white">Share</span>
                                    </button>
                                    
                                    <!-- Buy/Support Button -->
                                    @if($artwork->price)
                                    <button onclick="openPurchaseModal()"
                                            class="flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-gray-900 font-bold rounded-xl transition-all transform hover:scale-105 shadow-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        <span>Buy ${{ number_format($artwork->price, 2) }}</span>
                                    </button>
                                    @else
                                    <button onclick="supportArtist()"
                                            class="flex items-center justify-center gap-3 px-6 py-4 glass-dark rounded-xl hover:border-green-400 transition-all transform hover:scale-105 btn-hover-glow border-purple-500/30">
                                        <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-bold text-white">Support Artist</span>
                                    </button>
                                    @endif
                                @else
                                    <!-- Guest Buttons -->
                                    <a href="{{ route('login') }}"
                                       class="flex items-center justify-center gap-3 px-6 py-4 glass-dark rounded-xl hover:border-yellow-400 transition-all transform hover:scale-105 btn-hover-glow">
                                        <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <span class="font-bold text-white">Login to Like</span>
                                    </a>
                                    
                                    <a href="{{ route('login') }}"
                                       class="flex items-center justify-center gap-3 px-6 py-4 glass-dark rounded-xl hover:border-pink-400 transition-all transform hover:scale-105 btn-hover-glow">
                                        <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                        <span class="font-bold text-white">Login to Favorite</span>
                                    </a>
                                    
                                    <button onclick="shareArtwork()"
                                            class="flex items-center justify-center gap-3 px-6 py-4 glass-dark rounded-xl hover:border-purple-400 transition-all transform hover:scale-105 btn-hover-glow">
                                        <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                        <span class="font-bold text-white">Share</span>
                                    </button>
                                    
                                    <a href="{{ route('register') }}"
                                       class="flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-xl transition-all transform hover:scale-105 shadow-lg">
                                        <span>Join Free</span>
                                    </a>
                                @endauth
                            </div>
                        </div>
                        
                        <!-- Description Card -->
                        <div class="glass-card rounded-3xl p-6 shadow-2xl">
                            <h3 class="text-white text-xl font-bold mb-4 flex items-center gap-3">
                                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Description
                            </h3>
                            <div class="prose prose-lg max-w-none">
                                <p class="text-purple-200 whitespace-pre-line leading-relaxed">{{ $artwork->description }}</p>
                            </div>
                            
                            <!-- Tags -->
                            @if($artwork->tags && count($artwork->tags) > 0)
                            <div class="mt-8 pt-6 border-t border-purple-500/30">
                                <h4 class="text-white text-lg font-bold mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    Tags
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($artwork->tags as $tag)
                                    <a href="{{ route('search') }}?q={{ urlencode($tag) }}&type=artworks"
                                       class="px-4 py-2 glass-dark hover:bg-white/5 text-purple-300 hover:text-white rounded-xl text-sm transition-all transform hover:scale-105">
                                        #{{ $tag }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Details Card -->
                        <div class="glass-card rounded-3xl p-6 shadow-2xl">
                            <h3 class="text-white text-xl font-bold mb-6 flex items-center gap-3">
                                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Artwork Details
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <div class="text-purple-300 text-sm">Upload Date</div>
                                    <div class="text-white font-medium">{{ $artwork->created_at->format('F j, Y') }}</div>
                                </div>
                                @if($artwork->category)
                                <div class="space-y-1">
                                    <div class="text-purple-300 text-sm">Category</div>
                                    <div class="text-white font-medium">{{ $artwork->category->name }}</div>
                                </div>
                                @endif
                                @if($artwork->width && $artwork->height)
                                <div class="space-y-1">
                                    <div class="text-purple-300 text-sm">Dimensions</div>
                                    <div class="text-white font-medium">{{ $artwork->width }} × {{ $artwork->height }} px</div>
                                </div>
                                @endif
                                @if($artwork->software)
                                <div class="space-y-1">
                                    <div class="text-purple-300 text-sm">Software</div>
                                    <div class="text-white font-medium">{{ $artwork->software }}</div>
                                </div>
                                @endif
                                @if($artwork->license)
                                <div class="space-y-1">
                                    <div class="text-purple-300 text-sm">License</div>
                                    <div class="text-white font-medium">{{ $artwork->license }}</div>
                                </div>
                                @endif
                                @if($artwork->allow_commercial_use)
                                <div class="space-y-1">
                                    <div class="text-purple-300 text-sm">Commercial Use</div>
                                    <div class="text-green-400 font-medium">Allowed</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Comments Section -->
        <section class="py-12 px-4 sm:px-6">
            <div class="max-w-4xl mx-auto">
                <div class="glass-card rounded-3xl shadow-2xl overflow-hidden">
                    <!-- Comments Header -->
                    <div class="p-6 border-b border-purple-500/30">
                        <h2 class="font-['Playfair_Display'] text-2xl md:text-3xl font-bold text-white flex items-center gap-3">
                            <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Comments (<span id="comment-count">{{ $artwork->comments_count }}</span>)
                        </h2>
                        <p class="text-purple-300 mt-2">Share your thoughts about this artwork</p>
                    </div>
                    
                    <!-- Comment Form -->
                    @auth
                    <div class="p-6 border-b border-purple-500/30">
                        <form id="comment-form" action="{{ route('artworks.comments.store', $artwork) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex gap-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" 
                                         alt="{{ auth()->user()->name }}"
                                         class="w-12 h-12 rounded-full object-cover border-2 border-purple-500">
                                    @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Form Content -->
                                <div class="flex-1">
                                    <textarea id="comment-content"
                                              name="content"
                                              rows="3"
                                              placeholder="Write your comment here..."
                                              class="w-full px-4 py-3 glass-dark rounded-xl border border-purple-500/30 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 text-white placeholder-purple-400 transition-all resize-none"></textarea>
                                    <div class="mt-4 flex justify-end">
                                        <button type="submit"
                                                class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-gray-900 font-bold rounded-xl transition-all transform hover:scale-105 shadow-lg">
                                            Post Comment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @else
                    <!-- Guest Comment Prompt -->
                    <div class="p-8 text-center border-b border-purple-500/30">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-2xl flex items-center justify-center border border-purple-500/30">
                            <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        <h3 class="text-white text-lg font-bold mb-2">Join the Conversation</h3>
                        <p class="text-purple-300 mb-6">Sign in to leave a comment and connect with other art lovers</p>
                        <div class="flex gap-4 justify-center">
                            <a href="{{ route('login') }}"
                               class="px-6 py-3 glass-dark border border-purple-500/30 hover:border-yellow-400 text-white font-medium rounded-xl transition-all transform hover:scale-105">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}"
                               class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-xl transition-all transform hover:scale-105">
                                Create Account
                            </a>
                        </div>
                    </div>
                    @endauth
                    
                    <!-- Comments List -->
                    <div id="comments-container" class="divide-y divide-purple-500/30">
                        @if($artwork->comments->count() > 0)
                            @foreach($artwork->comments->sortByDesc('created_at') as $comment)
                            <div class="p-6 comment-enter" id="comment-{{ $comment->id }}">
                                <div class="flex gap-4">
                                    <!-- Commenter Avatar -->
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('profile.show', $comment->user->username ?? $comment->user->id) }}"
                                           class="block group">
                                            @if($comment->user->avatar)
                                            <img src="{{ Storage::url($comment->user->avatar) }}" 
                                                 alt="{{ $comment->user->name }}"
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-purple-500 group-hover:border-yellow-400 transition-colors">
                                            @else
                                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg group-hover:scale-110 transition-transform">
                                                {{ substr($comment->user->name, 0, 1) }}
                                            </div>
                                            @endif
                                        </a>
                                    </div>
                                    
                                    <!-- Comment Content -->
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <a href="{{ route('profile.show', $comment->user->username ?? $comment->user->id) }}"
                                                   class="font-bold text-white hover:text-yellow-300 transition-colors">
                                                    {{ $comment->user->name }}
                                                </a>
                                                <span class="text-purple-400 text-sm ml-3">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @auth
                                                    @if(auth()->id() === $comment->user_id)
                                                        <button onclick="deleteComment({{ $comment->id }})"
                                                                class="text-red-400 hover:text-red-300 transition-colors">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    @else
                                                        <button onclick="openReportModal('comment', {{ $comment->id }})"
                                                                class="text-purple-400 hover:text-red-400 transition-colors">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-purple-200 whitespace-pre-line leading-relaxed">{{ $comment->content }}</p>
                                        </div>
                                        
                                        <!-- Comment Actions -->
                                        <div class="flex items-center gap-4">
                                            <button onclick="toggleCommentLike({{ $comment->id }})"
                                                    class="flex items-center gap-2 text-purple-400 hover:text-yellow-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                                </svg>
                                                <span class="text-sm">Like</span>
                                            </button>
                                            
                                            <button onclick="replyToComment({{ $comment->id }})"
                                                    class="flex items-center gap-2 text-purple-400 hover:text-yellow-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                </svg>
                                                <span class="text-sm">Reply</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <!-- Empty Comments -->
                            <div class="p-12 text-center">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-2xl flex items-center justify-center border border-purple-500/30">
                                    <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <h3 class="text-white text-xl font-bold mb-3">No comments yet</h3>
                                <p class="text-purple-300 mb-6 max-w-md mx-auto">Be the first to share your thoughts about this artwork!</p>
                                @auth
                                <button onclick="document.getElementById('comment-content').focus()"
                                        class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-gray-900 font-bold rounded-xl transition-all transform hover:scale-105">
                                    Write First Comment
                                </button>
                                @else
                                <a href="{{ route('login') }}"
                                   class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-xl transition-all transform hover:scale-105">
                                    Login to Comment
                                </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Report Modal -->
<div id="report-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/70" onclick="closeReportModal()"></div>
        <div class="inline-block align-bottom bg-gradient-to-br from-purple-900 to-indigo-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-purple-500/30">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Report Content</h3>
                    <button onclick="closeReportModal()" class="text-purple-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form id="report-form" class="space-y-6">
                    @csrf
                    <input type="hidden" id="report-type" name="type">
                    <input type="hidden" id="report-id" name="id">
                    
                    <div>
                        <label class="block text-white mb-4">Select reason for reporting:</label>
                        <div class="space-y-2">
                            @foreach(['inappropriate' => 'Inappropriate Content', 'copyright' => 'Copyright Issue', 'spam' => 'Spam', 'other' => 'Other'] as $value => $label)
                            <label class="flex items-center p-3 glass-dark rounded-xl hover:bg-white/5 cursor-pointer">
                                <input type="radio" name="reason" value="{{ $value }}" class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-purple-500">
                                <span class="ml-3 text-white">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <div>
                        <textarea id="report-description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Additional details..."
                                  class="w-full px-4 py-3 glass-dark rounded-xl border border-purple-500/30 text-white placeholder-purple-400"></textarea>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" onclick="closeReportModal()"
                                class="flex-1 px-4 py-3 glass-dark text-white rounded-xl hover:bg-white/5 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold rounded-xl transition-all">
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/70" onclick="closeDeleteModal()"></div>
        <div class="inline-block align-bottom bg-gradient-to-br from-purple-900 to-indigo-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-red-500/30">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Delete Artwork</h3>
                    <button onclick="closeDeleteModal()" class="text-purple-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <p class="text-purple-200 mb-8">
                    Are you sure you want to delete "<span class="text-white font-semibold">{{ $artwork->title }}</span>"? This action cannot be undone and all associated data will be permanently removed.
                </p>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-3 glass-dark text-white rounded-xl hover:bg-white/5 transition-colors">
                        Cancel
                    </button>
                    <form action="{{ route('member.artworks.destroy', $artwork->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold rounded-xl transition-all">
                            Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Image zoom functionality
let currentScale = 1;
function zoomIn() {
    currentScale += 0.2;
    document.getElementById('main-artwork-image').style.transform = `scale(${currentScale})`;
}

function zoomOut() {
    if (currentScale > 1) {
        currentScale -= 0.2;
        document.getElementById('main-artwork-image').style.transform = `scale(${currentScale})`;
    }
}

function changeImage(src) {
    document.getElementById('main-artwork-image').src = src;
    currentScale = 1;
    document.getElementById('main-artwork-image').style.transform = 'scale(1)';
}

// Like functionality
async function toggleLike(artworkId) {
    const likeBtn = document.getElementById(`like-btn-${artworkId}`);
    const likeIcon = document.getElementById(`like-icon-${artworkId}`);
    const likeCount = document.getElementById(`like-count-${artworkId}`);
    
    likeIcon.classList.add('heart-beat');
    
    try {
        const response = await fetch(`/member/artworks/${artworkId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            setTimeout(() => likeIcon.classList.remove('heart-beat'), 1200);
            
            if (data.liked) {
                likeIcon.classList.add('text-yellow-400', 'fill-current');
                likeIcon.classList.remove('text-purple-300');
                likeBtn.classList.add('border-yellow-400');
                likeBtn.classList.remove('border-purple-500/30');
                likeCount.textContent = data.likes_count;
                likeCount.parentElement.classList.add('text-yellow-400');
                likeCount.parentElement.classList.remove('text-white');
            } else {
                likeIcon.classList.remove('text-yellow-400', 'fill-current');
                likeIcon.classList.add('text-purple-300');
                likeBtn.classList.remove('border-yellow-400');
                likeBtn.classList.add('border-purple-500/30');
                likeCount.textContent = data.likes_count;
                likeCount.parentElement.classList.remove('text-yellow-400');
                likeCount.parentElement.classList.add('text-white');
            }
        }
    } catch (error) {
        console.error('Error toggling like:', error);
        likeIcon.classList.remove('heart-beat');
        showToast('Failed to update like', 'error');
    }
}

// Favorite functionality
async function toggleFavorite(artworkId) {
    const favoriteBtn = document.getElementById(`favorite-btn-${artworkId}`);
    const favoriteIcon = document.getElementById(`favorite-icon-${artworkId}`);
    
    favoriteIcon.classList.add('heart-beat');
    
    try {
        const response = await fetch(`/member/artworks/${artworkId}/favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            setTimeout(() => favoriteIcon.classList.remove('heart-beat'), 1200);
            
            if (data.favorited) {
                favoriteIcon.classList.add('text-pink-400', 'fill-current');
                favoriteIcon.classList.remove('text-purple-300');
                favoriteBtn.classList.add('border-pink-400');
                favoriteBtn.classList.remove('border-purple-500/30');
                favoriteBtn.querySelector('span').classList.add('text-pink-400');
                favoriteBtn.querySelector('span').classList.remove('text-white');
            } else {
                favoriteIcon.classList.remove('text-pink-400', 'fill-current');
                favoriteIcon.classList.add('text-purple-300');
                favoriteBtn.classList.remove('border-pink-400');
                favoriteBtn.classList.add('border-purple-500/30');
                favoriteBtn.querySelector('span').classList.remove('text-pink-400');
                favoriteBtn.querySelector('span').classList.add('text-white');
            }
        }
    } catch (error) {
        console.error('Error toggling favorite:', error);
        favoriteIcon.classList.remove('heart-beat');
        showToast('Failed to update favorite', 'error');
    }
}

// Share functionality
function shareArtwork() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $artwork->title }}',
            text: 'Check out this amazing artwork on ArtShowcase!',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        showToast('Link copied to clipboard!', 'success');
    }
}

// Follow functionality
async function toggleFollow(userId) {
    const followBtn = document.getElementById(`follow-btn-${userId}`);
    if (!followBtn) return;
    
    const originalText = followBtn.innerHTML;
    followBtn.innerHTML = '<span class="animate-spin">⟳</span>';
    followBtn.disabled = true;
    
    try {
        const response = await fetch(`/users/${userId}/follow`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            followBtn.innerHTML = data.following ? 'Following' : 'Follow';
            followBtn.className = data.following 
                ? 'px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-sm font-bold rounded-xl transition-all transform hover:scale-105'
                : 'px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white text-sm font-bold rounded-xl transition-all transform hover:scale-105';
            
            showToast(data.message || 'Follow status updated', 'success');
        }
    } catch (error) {
        console.error('Error toggling follow:', error);
        followBtn.innerHTML = originalText;
        showToast('Failed to update follow status', 'error');
    } finally {
        followBtn.disabled = false;
    }
}

// Toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-6 right-6 px-6 py-3 rounded-xl glass-dark border ${type === 'success' ? 'border-green-500/30' : type === 'error' ? 'border-red-500/30' : 'border-yellow-500/30'} text-white z-50 animate-slide-up`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 ${type === 'success' ? 'text-green-400' : type === 'error' ? 'text-red-400' : 'text-yellow-400'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : type === 'error' ? 'M6 18L18 6M6 6l12 12' : 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'}"/>
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Comment functionality
document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('comment-form');
    const commentsContainer = document.getElementById('comments-container');
    
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Posting...
            `;
            submitBtn.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('comment-content').value = '';
                    
                    // Create new comment element
                    const commentHTML = `
                        <div class="p-6 comment-enter" id="comment-${data.comment.id}">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    ${data.user.avatar ? 
                                        `<img src="${data.user.avatar_url}" 
                                              alt="${data.user.name}"
                                              class="w-12 h-12 rounded-full object-cover border-2 border-purple-500 hover:border-yellow-400 transition-colors">` :
                                        `<div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            ${data.user.name ? data.user.name.charAt(0) : 'U'}
                                        </div>`
                                    }
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <a href="${data.user.profile_url}" class="font-bold text-white hover:text-yellow-400 transition-colors">${data.user.name}</a>
                                            <span class="text-purple-400 text-sm ml-3">Just now</span>
                                        </div>
                                        <button onclick="deleteComment(${data.comment.id})" class="text-purple-400 hover:text-red-400 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-purple-200 whitespace-pre-line leading-relaxed">${data.comment.content}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <button onclick="toggleCommentLike(${data.comment.id})" class="flex items-center gap-2 text-purple-400 hover:text-yellow-400 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                            </svg>
                                            <span class="text-sm">Like</span>
                                        </button>
                                        <button onclick="replyToComment(${data.comment.id})" class="flex items-center gap-2 text-purple-400 hover:text-yellow-400 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                            </svg>
                                            <span class="text-sm">Reply</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Add comment to top
                    if (commentsContainer.firstChild) {
                        commentsContainer.insertAdjacentHTML('afterbegin', commentHTML);
                    } else {
                        commentsContainer.innerHTML = commentHTML;
                    }
                    
                    // Update comment count
                    const commentCount = document.getElementById('comment-count');
                    if (commentCount) {
                        const currentCount = parseInt(commentCount.textContent) || 0;
                        commentCount.textContent = currentCount + 1;
                    }
                    
                    // Animation
                    const newComment = document.getElementById(`comment-${data.comment.id}`);
                    newComment.style.opacity = '0';
                    newComment.style.transform = 'translateY(-20px)';
                    
                    setTimeout(() => {
                        newComment.style.transition = 'all 0.3s ease';
                        newComment.style.opacity = '1';
                        newComment.style.transform = 'translateY(0)';
                    }, 10);
                    
                    showToast('Comment posted successfully!', 'success');
                } else {
                    showToast(data.message || 'Failed to post comment', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred while posting comment', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            });
        });
    }
});

// Comment like functionality
async function toggleCommentLike(commentId) {
    try {
        const response = await fetch(`/comments/${commentId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            showToast('Comment liked!', 'success');
        }
    } catch (error) {
        console.error('Error liking comment:', error);
        showToast('Failed to like comment', 'error');
    }
}

// Delete comment
async function deleteComment(commentId) {
    if (!confirm('Are you sure you want to delete this comment?')) return;
    
    try {
        const response = await fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            const commentElement = document.getElementById(`comment-${commentId}`);
            commentElement.style.opacity = '1';
            commentElement.style.transform = 'translateY(0)';
            
            setTimeout(() => {
                commentElement.style.transition = 'all 0.3s ease';
                commentElement.style.opacity = '0';
                commentElement.style.transform = 'translateY(-20px)';
                
                setTimeout(() => {
                    commentElement.remove();
                    
                    const commentCount = document.getElementById('comment-count');
                    if (commentCount) {
                        const currentCount = parseInt(commentCount.textContent) || 1;
                        commentCount.textContent = Math.max(0, currentCount - 1);
                    }
                }, 300);
            }, 10);
            
            showToast('Comment deleted successfully', 'success');
        }
    } catch (error) {
        console.error('Error deleting comment:', error);
        showToast('Failed to delete comment', 'error');
    }
}

function replyToComment(commentId) {
    const textarea = document.getElementById('comment-content');
    if (textarea) {
        textarea.value = `@${commentId} `;
        textarea.focus();
        textarea.scrollIntoView({ behavior: 'smooth' });
    }
}

function supportArtist() {
    showToast('Support feature coming soon!', 'info');
}

function openPurchaseModal() {
    showToast('Purchase feature coming soon!', 'info');
}

// Modal functions
function openReportModal(type, id) {
    document.getElementById('report-type').value = type;
    document.getElementById('report-id').value = id;
    document.getElementById('report-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeReportModal() {
    document.getElementById('report-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    document.getElementById('report-form').reset();
}

function confirmDelete() {
    document.getElementById('delete-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Submit report
document.getElementById('report-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    if (!formData.get('reason')) {
        showToast('Please select a reason for reporting', 'error');
        return;
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="animate-spin">⟳</span> Submitting...';
    submitBtn.disabled = true;
    
    try {
        const endpoint = formData.get('type') === 'artwork' 
            ? `/member/report/artwork/${formData.get('id')}`
            : `/member/report/comment/${formData.get('id')}`;
        
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                reason: formData.get('reason'),
                description: formData.get('description')
            })
        });
        
        const data = await response.json();
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        if (data.success) {
            closeReportModal();
            showToast('Report submitted successfully. Thank you!', 'success');
        } else {
            showToast('Failed to submit report. Please try again.', 'error');
        }
    } catch (error) {
        console.error('Error submitting report:', error);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        showToast('An error occurred. Please try again.', 'error');
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeReportModal();
        closeDeleteModal();
    }
    if (e.key === '+' && e.ctrlKey) {
        e.preventDefault();
        zoomIn();
    }
    if (e.key === '-' && e.ctrlKey) {
        e.preventDefault();
        zoomOut();
    }
});

// Initialize animations
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects
    document.querySelectorAll('button, a').forEach(el => {
        el.addEventListener('mouseenter', () => {
            el.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });
});
</script>
@endpush