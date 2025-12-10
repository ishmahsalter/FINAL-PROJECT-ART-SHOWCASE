{{-- resources/views/home/public.blade.php --}}
@extends('layouts.app')

@section('title', 'RIOTÉ Showcase | Where Art Comes Alive in rebellion')

@section('content')

<!-- 1. ULTRA IMMERSIVE HERO with Parallax & Particles -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900"
         x-data="heroParallax()"
         @mousemove="handleMouseMove($event)">
    
    <!-- Animated Mesh Gradient Background -->
    <div class="absolute inset-0 opacity-30">
        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500 via-purple-500 to-pink-500 animate-gradient-shift"></div>
    </div>

    <!-- Floating Particles Canvas -->
    <canvas id="particles-canvas" class="absolute inset-0 w-full h-full"></canvas>
    
    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
    
    <!-- Parallax Floating Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-br from-yellow-400/20 to-orange-500/20 rounded-full filter blur-3xl animate-float-slow"
             :style="`transform: translate(${mouseX * 0.02}px, ${mouseY * 0.02}px)`"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-gradient-to-br from-green-400/20 to-teal-500/20 rounded-full filter blur-3xl animate-float-medium"
             :style="`transform: translate(${mouseX * -0.03}px, ${mouseY * -0.03}px)`"></div>
        <div class="absolute top-1/2 right-1/3 w-64 h-64 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full filter blur-3xl animate-float-fast"
             :style="`transform: translate(${mouseX * 0.04}px, ${mouseY * 0.04}px)`"></div>
    </div>

    <!-- Hero Content with 3D Transform -->
    <div class="relative z-10 max-w-6xl mx-auto px-6 text-center text-white"
         :style="`transform: perspective(1000px) rotateX(${mouseY * -0.01}deg) rotateY(${mouseX * 0.01}deg)`">
        
        <!-- Glowing Text Effect -->
        <div class="mb-8">
            <h1 class="font-display text-6xl md:text-8xl lg:text-9xl font-black mb-6 leading-tight tracking-tight animate-text-shimmer bg-clip-text text-transparent bg-gradient-to-r from-white via-yellow-200 to-white bg-[length:200%_auto]">
                <span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">A</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">R</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">T</span><br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-orange-400 to-pink-400 animate-gradient-x">
                    <span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">S</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">H</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">O</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">W</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">C</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">A</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">S</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">E</span>
                </span>
            </h1>
        </div>

        <!-- Subheadline with Typing Effect -->
        <p class="font-body text-2xl md:text-3xl mb-12 max-w-3xl mx-auto leading-relaxed opacity-95 font-light"
           x-data="{ text: 'Where extraordinary talent meets global recognition.', displayed: '', index: 0 }"
           x-init="setInterval(() => { if(index < text.length) { displayed += text[index]; index++; } }, 50)"
           x-text="displayed"></p>

        <!-- Animated Stats -->
        <div class="grid grid-cols-3 gap-12 max-w-2xl mx-auto mb-16">
            <!-- Artworks Count -->
            <div class="text-center group cursor-pointer">
                @php
                    $artworksCount = \App\Models\Artwork::count() ?? 0;
                @endphp
                <div class="font-display text-4xl md:text-5xl font-bold text-yellow-400 mb-2 group-hover:scale-125 transition-transform duration-300"
                    x-data="{ count: 0 }" 
                    x-init="
                        $nextTick(() => {
                            let start = 0;
                            const end = {{ $artworksCount }};
                            const duration = 2000;
                            const increment = end / (duration / 16);
                            const timer = setInterval(() => {
                                start += increment;
                                if (start >= end) {
                                    count = end;
                                    clearInterval(timer);
                                } else {
                                    count = Math.floor(start);
                                }
                            }, 16);
                        })
                    "
                    x-text="count">
                    {{ $artworksCount }}
                </div>
                <div class="font-ui text-sm uppercase tracking-wider opacity-80 group-hover:text-yellow-400 transition-colors">Artworks</div>
                <div class="w-12 h-1 bg-gradient-to-r from-transparent via-yellow-400 to-transparent mx-auto mt-2 group-hover:w-full transition-all duration-500"></div>
            </div>
    
            <!-- Creators Count -->
            <div class="text-center group cursor-pointer">
                @php
                    $creatorsCount = \App\Models\User::where('role', 'member')->count() ?? 0;
                @endphp
                <div class="font-display text-4xl md:text-5xl font-bold text-yellow-400 mb-2 group-hover:scale-125 transition-transform duration-300"
                     x-data="{ count: 0 }" 
                     x-init="
                        $nextTick(() => {
                            let start = 0;
                            const end = {{ $creatorsCount }};
                            const duration = 2000;
                            const increment = end / (duration / 16);
                            const timer = setInterval(() => {
                                start += increment;
                                if (start >= end) {
                                    count = end;
                                    clearInterval(timer);
                                } else {
                                    count = Math.floor(start);
                                }
                            }, 16);
                        })
                     "
                     x-text="count">
                    {{ $creatorsCount }}
                </div>
                <div class="font-ui text-sm uppercase tracking-wider opacity-80 group-hover:text-yellow-400 transition-colors">Creators</div>
                <div class="w-12 h-1 bg-gradient-to-r from-transparent via-yellow-400 to-transparent mx-auto mt-2 group-hover:w-full transition-all duration-500"></div>
            </div>
            
            <!-- Challenges Count -->
            <div class="text-center group cursor-pointer">
                @php
                    $challengesCount = \App\Models\Challenge::count() ?? 0;
                @endphp
                <div class="font-display text-4xl md:text-5xl font-bold text-yellow-400 mb-2 group-hover:scale-125 transition-transform duration-300"
                     x-data="{ count: 0 }" 
                     x-init="
                        $nextTick(() => {
                            let start = 0;
                            const end = {{ $challengesCount }};
                            const duration = 2000;
                            const increment = end / (duration / 16);
                            const timer = setInterval(() => {
                                start += increment;
                                if (start >= end) {
                                    count = end;
                                    clearInterval(timer);
                                } else {
                                    count = Math.floor(start);
                                }
                            }, 16);
                        })
                     "
                     x-text="count">
                    {{ $challengesCount }}
                </div>
                <div class="font-ui text-sm uppercase tracking-wider opacity-80 group-hover:text-yellow-400 transition-colors">Challenges</div>
                <div class="w-12 h-1 bg-gradient-to-r from-transparent via-yellow-400 to-transparent mx-auto mt-2 group-hover:w-full transition-all duration-500"></div>
            </div>
        </div>

        <!-- Magnetic CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            @guest
                <a href="/register" 
                   class="magnetic-button group relative px-12 py-6 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white font-ui font-bold text-xl rounded-2xl shadow-[0_0_40px_rgba(251,191,36,0.6)] hover:shadow-[0_0_60px_rgba(251,191,36,0.8)] transition-all duration-500 transform hover:-translate-y-2 overflow-hidden"
                   x-data="magneticButton()"
                   @mousemove="handleMove($event)"
                   @mouseleave="reset()"
                   :style="`transform: translate(${x}px, ${y}px) translateY(-8px)`">
                    <span class="relative z-10 flex items-center">
                        Start Creating Now 
                        <svg class="w-6 h-6 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500 animate-gradient-x"></div>
                    <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-2xl blur opacity-30 group-hover:opacity-60 transition-opacity duration-500 animate-pulse"></div>
                </a>
                <a href="#featured-gallery" 
                   class="magnetic-button group px-12 py-6 bg-white/10 backdrop-blur-md hover:bg-white/20 text-white font-ui font-bold text-xl rounded-2xl border-2 border-white/30 hover:border-white hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] transition-all duration-500 transform hover:-translate-y-1"
                   x-data="magneticButton()"
                   @mousemove="handleMove($event)"
                   @mouseleave="reset()"
                   :style="`transform: translate(${x}px, ${y}px)`">
                    <span class="flex items-center">
                        Explore Gallery
                        <svg class="w-6 h-6 ml-2 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                </a>
            @else
                <a href="{{ route('member.artworks.create') }}" 
                   class="magnetic-button group relative px-12 py-6 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white font-ui font-bold text-xl rounded-2xl shadow-[0_0_40px_rgba(251,191,36,0.6)] hover:shadow-[0_0_60px_rgba(251,191,36,0.8)] transition-all duration-500 transform hover:-translate-y-2 overflow-hidden"
                   x-data="magneticButton()"
                   @mousemove="handleMove($event)"
                   @mouseleave="reset()"
                   :style="`transform: translate(${x}px, ${y}px) translateY(-8px)`">
                    <span class="relative z-10 flex items-center">
                        Upload Your Art
                        <svg class="w-6 h-6 ml-2 group-hover:scale-125 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </a>
            @endguest
        </div>
    </div>

    <!-- Animated Scroll Indicator with Pulse -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce-slow z-20">
        <div class="flex flex-col items-center space-y-2 cursor-pointer group" onclick="document.querySelector('#featured-gallery').scrollIntoView({behavior: 'smooth'})">
            <span class="text-white/70 text-sm font-ui uppercase tracking-wider group-hover:text-white transition-colors">Scroll to Explore</span>
            <div class="relative">
                <svg class="w-6 h-6 text-white/70 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
                <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
            </div>
        </div>
    </div>
</section>

<!-- 2. MASONRY GALLERY with 3D Hover Effects -->
<section id="featured-gallery" class="py-24 bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800 relative overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-10">
        <div class="absolute top-20 -left-20 w-72 h-72 bg-purple-400 rounded-full filter blur-3xl animate-blob"></div>
        <div class="absolute top-40 -right-20 w-72 h-72 bg-yellow-400 rounded-full filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-20 left-1/2 w-72 h-72 bg-pink-400 rounded-full filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <!-- Section Header with Slide-in Animation -->
        <div class="text-center mb-20" 
             x-data="{ show: false }"
             x-intersect="show = true"
             x-show="show"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 -translate-y-10"
             x-transition:enter-end="opacity-100 translate-y-0">
            <h2 class="font-display text-5xl md:text-6xl font-bold text-slate-900 dark:text-white mb-6">
                Featured <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500">Gallery</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 mx-auto mb-6 rounded-full"></div>
            <p class="font-body text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Discover incredible artworks from our global community of talented creators
            </p>
        </div>

        <!-- Enhanced Masonry Grid with Stagger Animation -->
        <div class="masonry-grid">
            @foreach($artworks->take(12) as $index => $artwork)
                <div class="masonry-item group"
                     x-data="{ 
                         show: false, 
                         liked: false,
                         likeCount: {{ $artwork->likes_count ?? 0 }}
                     }"
                     x-intersect="show = true"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-10"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     style="transition-delay: {{ $index * 100 }}ms;">
                    
                    <div class="relative bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02]">
                        <!-- Image with 3D Tilt Effect -->
                        <div class="relative overflow-hidden aspect-square group-hover:aspect-[4/3] transition-all duration-700"
                             x-data="tiltEffect()"
                             @mousemove="handleTilt($event)"
                             @mouseleave="reset()"
                             :style="`transform: perspective(1000px) rotateX(${tiltY}deg) rotateY(${tiltX}deg) scale3d(1.05, 1.05, 1.05)`">
                            
                            <img src="{{ Storage::url($artwork->image_path) }}" 
                                 alt="{{ $artwork->title }}"
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                 loading="lazy">
                            
                            <!-- Gradient Overlay with Shimmer -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            </div>

                            <!-- Floating Action Buttons -->
                            <div class="absolute inset-0 flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-all duration-500">
                                <button @click="$dispatch('quick-view', { id: {{ $artwork->id }} })"
                                        class="transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 bg-white/90 backdrop-blur-sm hover:bg-white text-slate-900 rounded-full p-4 shadow-2xl hover:shadow-3xl hover:scale-110">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                
                                <button @click="liked = !liked; likeCount += liked ? 1 : -1"
                                        class="transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 delay-75 backdrop-blur-sm rounded-full p-4 shadow-2xl hover:shadow-3xl hover:scale-110"
                                        :class="liked ? 'bg-pink-500 text-white' : 'bg-white/90 hover:bg-white text-slate-900'">
                                    <svg class="w-6 h-6 transition-transform" :class="liked ? 'scale-110' : ''" fill="none" :stroke="liked ? 'currentColor' : 'currentColor'" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Category Badge with Glassmorphism -->
                            @if($artwork->category)
                            <div class="absolute top-4 left-4">
                                <span class="px-4 py-2 bg-white/80 backdrop-blur-md text-slate-700 text-xs font-bold rounded-full uppercase tracking-wide shadow-lg border border-white/20 hover:bg-white transition-all duration-300 cursor-default">
                                    {{ $artwork->category->name }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Artwork Info with Slide-up Animation -->
                        <div class="p-6 transform transition-all duration-500 group-hover:translate-y-0">
                            <h3 class="font-display text-xl font-bold text-slate-900 dark:text-white mb-2 line-clamp-1 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-yellow-400 group-hover:to-pink-500 transition-all duration-300">
                                {{ $artwork->title }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                                {{ $artwork->description }}
                            </p>
                            
                            <!-- Creator Info -->
                            <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg hover:scale-110 transition-transform duration-300 cursor-pointer">
                                            {{ substr($artwork->user->name, 0, 1) }}
                                        </div>
                                        <div class="absolute -inset-1 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full blur opacity-30 group-hover:opacity-60 transition-opacity"></div>
                                    </div>
                                    <div>
                                        <div class="font-ui font-semibold text-slate-900 dark:text-white text-sm hover:text-orange-500 transition-colors cursor-pointer">
                                            {{ $artwork->user->display_name ?? $artwork->user->name }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2 text-slate-500 dark:text-slate-400 text-sm">
                                    <svg class="w-5 h-5" :class="liked ? 'text-pink-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="font-bold" x-text="likeCount">{{ $artwork->likes_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Glow Effect on Hover -->
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-3xl opacity-0 group-hover:opacity-20 blur transition-opacity duration-500"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- View More with Ripple Effect -->
        <div class="text-center mt-20">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 hover:from-pink-500 hover:via-orange-500 hover:to-yellow-400 text-white font-ui font-bold text-lg rounded-2xl shadow-[0_10px_40px_rgba(251,191,36,0.3)] hover:shadow-[0_20px_60px_rgba(251,191,36,0.5)] transition-all duration-500 transform hover:-translate-y-2 relative overflow-hidden group"
               x-data="{ ripple: false }"
               @click="ripple = true; setTimeout(() => ripple = false, 600)">
                <span class="relative z-10 flex items-center">
                    Explore All Artworks
                    <svg class="w-6 h-6 ml-3 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>
                <span x-show="ripple" 
                      x-transition:enter="transition ease-out duration-300"
                      x-transition:enter-start="scale-0 opacity-100"
                      x-transition:enter-end="scale-150 opacity-0"
                      class="absolute inset-0 bg-white rounded-2xl"></span>
            </a>
        </div>
    </div>
</section>

<!-- 3. CHALLENGES SECTION with Card Flip Effect -->
@if($challenges->count() > 0)
<section class="py-24 bg-slate-900 relative overflow-hidden">
    <!-- Animated Grid Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251, 191, 36, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(251, 191, 36, 0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-20"
             x-data="{ show: false }"
             x-intersect="show = true"
             x-show="show"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <h2 class="font-display text-5xl md:text-6xl font-bold text-white mb-6">
                Active <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500">Challenges</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 mx-auto mb-6 rounded-full"></div>
            <p class="font-body text-xl text-slate-300">
                Join now, showcase your talent, and win amazing prizes
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($challenges->take(3) as $index => $challenge)
                <div class="challenge-card"
                     x-data="{ 
                         show: false, 
                         flipped: false 
                     }"
                     x-intersect="show = true"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 translate-y-10"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="transition-delay: {{ $index * 150 }}ms;"
                     @click="flipped = !flipped">
                    
                    <div class="relative perspective-1000 h-full">
                        <div class="card-inner" :class="flipped ? 'flipped' : ''">
                            <!-- Front of Card -->
                            <div class="card-face card-front">
                                <div class="group relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl overflow-hidden shadow-2xl hover:shadow-[0_20px_60px_rgba(251,191,36,0.3)] transition-all duration-500 h-full border border-slate-700 hover:border-yellow-400/50">
                                    <!-- Challenge Image -->
                                    @if($challenge->banner_image)
                                        <div class="aspect-[16/9] overflow-hidden">
                                            <img src="{{ Storage::url($challenge->banner_image) }}" 
                                                 alt="{{ $challenge->title }}" 
                                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        </div>
                                    @else
                                        <div class="aspect-[16/9] bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 flex items-center justify-center relative overflow-hidden">
                                            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 20px 20px;"></div>
                                            <svg class="w-20 h-20 text-white opacity-90 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Content -->
                                    <div class="p-8">
                                        <h3 class="font-display text-2xl font-bold text-white mb-3 line-clamp-1 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-yellow-400 group-hover:to-pink-500 transition-all">
                                            {{ $challenge->title }}
                                        </h3>
                                        <p class="text-slate-300 text-base mb-6 line-clamp-2 leading-relaxed">
                                            {{ $challenge->description }}
                                        </p>
                                        
                                        <div class="flex items-center justify-between mb-6">
                                            <div class="flex items-center space-x-2 text-slate-400">
                                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-ui font-semibold">{{ $challenge->end_date->diffForHumans() }}</span>
                                            </div>
                                            <span class="px-4 py-2 bg-green-500/20 border border-green-500/50 text-green-400 rounded-full text-sm font-bold uppercase tracking-wide backdrop-blur-sm">
                                                Active
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-center text-slate-400 text-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Click to see details
                                        </div>
                                    </div>

                                    <!-- Glow Effect -->
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-3xl opacity-0 group-hover:opacity-20 blur transition-opacity duration-500"></div>
                                </div>
                            </div>

                            <!-- Back of Card -->
                            <div class="card-face card-back">
                                <div class="bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-3xl p-8 h-full flex flex-col justify-between shadow-2xl">
                                    <div>
                                        <h3 class="font-display text-2xl font-bold text-white mb-4">
                                            Challenge Details
                                        </h3>
                                        <div class="space-y-4 text-white/90">
                                            <div>
                                                <div class="font-bold text-sm uppercase tracking-wide mb-1">Prize</div>
                                                <div class="text-lg">{{ $challenge->prize ?? 'To be announced' }}</div>
                                            </div>
                                            <div>
                                                <div class="font-bold text-sm uppercase tracking-wide mb-1">Submissions</div>
                                                <div class="text-lg">{{ $challenge->submissions->count() }} entries</div>
                                            </div>
                                            <div>
                                                <div class="font-bold text-sm uppercase tracking-wide mb-1">Organized by</div>
                                                <div class="text-lg">{{ $challenge->curator->display_name ?? $challenge->curator->name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <a href="{{ route('challenges.show', $challenge->id) }}" 
                                           class="block w-full text-center px-6 py-4 bg-white hover:bg-slate-100 text-slate-900 font-ui font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                                            View Full Challenge
                                        </a>
                                        <button @click.stop="flipped = false" 
                                                class="w-full px-6 py-3 border-2 border-white/50 hover:border-white text-white font-ui font-semibold rounded-xl transition-all duration-300">
                                            Back to Card
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<style>
/* Enhanced Animations */
@keyframes gradient-shift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

@keyframes text-shimmer {
    0% { background-position: 0% 50%; }
    100% { background-position: 200% 50%; }
}

@keyframes float-slow {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(120deg); }
    66% { transform: translate(-20px, 20px) rotate(240deg); }
}

@keyframes float-medium {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(-30px, 30px) rotate(120deg); }
    66% { transform: translate(20px, -20px) rotate(240deg); }
}

@keyframes float-fast {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(20px, -20px) scale(1.1); }
}

@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

.animate-gradient-shift { animation: gradient-shift 15s ease infinite; background-size: 200% 200%; }
.animate-gradient-x { animation: gradient-x 3s ease infinite; background-size: 200% auto; }
.animate-text-shimmer { animation: text-shimmer 3s linear infinite; }
.animate-float-slow { animation: float-slow 20s ease-in-out infinite; }
.animate-float-medium { animation: float-medium 15s ease-in-out infinite; }
.animate-float-fast { animation: float-fast 10s ease-in-out infinite; }
.animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
.animate-blob { animation: blob 7s ease-in-out infinite; }
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }

/* Masonry Grid */
.masonry-grid {
    column-count: 1;
    column-gap: 2rem;
}

@media (min-width: 640px) {
    .masonry-grid { column-count: 2; }
}

@media (min-width: 1024px) {
    .masonry-grid { column-count: 3; }
}

.masonry-item {
    break-inside: avoid;
    margin-bottom: 2rem;
}

/* 3D Card Flip */
.perspective-1000 { perspective: 1000px; }

.card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.8s;
    transform-style: preserve-3d;
}

.card-inner.flipped {
    transform: rotateY(180deg);
}

.card-face {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
}

.card-back {
    transform: rotateY(180deg);
}

/* Line Clamp */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth Scroll */
html { scroll-behavior: smooth; }

/* Custom Scrollbar */
::-webkit-scrollbar { width: 12px; }
::-webkit-scrollbar-track { background: #1e293b; }
::-webkit-scrollbar-thumb { background: linear-gradient(to bottom, #fbbf24, #f97316); border-radius: 6px; }
::-webkit-scrollbar-thumb:hover { background: linear-gradient(to bottom, #f59e0b, #ea580c); }
</style>

<script>
// Particles Canvas Animation
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('particles-canvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    let particles = [];
    
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    
    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 3 + 1;
            this.speedX = Math.random() * 2 - 1;
            this.speedY = Math.random() * 2 - 1;
            this.opacity = Math.random() * 0.5 + 0.2;
        }
        
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            
            if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
            if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
        }
        
        draw() {
            ctx.fillStyle = `rgba(251, 191, 36, ${this.opacity})`;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }
    
    function init() {
        particles = [];
        for (let i = 0; i < 100; i++) {
            particles.push(new Particle());
        }
    }
    
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(particle => {
            particle.update();
            particle.draw();
        });
        requestAnimationFrame(animate);
    }
    
    init();
    animate();
    
    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        init();
    });
});

// Hero Parallax Effect
function heroParallax() {
    return {
        mouseX: 0,
        mouseY: 0,
        handleMouseMove(e) {
            const rect = e.currentTarget.getBoundingClientRect();
            this.mouseX = (e.clientX - rect.left - rect.width / 2) / 10;
            this.mouseY = (e.clientY - rect.top - rect.height / 2) / 10;
        }
    };
}

// Magnetic Button Effect
function magneticButton() {
    return {
        x: 0,
        y: 0,
        handleMove(e) {
            const rect = e.currentTarget.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            this.x = (e.clientX - centerX) / 8;
            this.y = (e.clientY - centerY) / 8;
        },
        reset() {
            this.x = 0;
            this.y = 0;
        }
    };
}

// 3D Tilt Effect
function tiltEffect() {
    return {
        tiltX: 0,
        tiltY: 0,
        handleTilt(e) {
            const rect = e.currentTarget.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            this.tiltX = ((e.clientX - centerX) / (rect.width / 2)) * 10;
            this.tiltY = ((e.clientY - centerY) / (rect.height / 2)) * -10;
        },
        reset() {
            this.tiltX = 0;
            this.tiltY = 0;
        }
    };
}

// Quick View Modal
function quickViewModal() {
    return {
        isOpen: false,
        currentArtwork: null,
        artworks: [
            @foreach($artworks as $artwork)
            {
                id: {{ $artwork->id }},
                title: "{{ addslashes($artwork->title) }}",
                description: "{{ addslashes($artwork->description) }}",
                image_url: "{{ Storage::url($artwork->image_path) }}",
                user_name: "{{ addslashes($artwork->user->display_name ?? $artwork->user->name) }}",
                user_initial: "{{ substr($artwork->user->name, 0, 1) }}",
                detail_url: "{{ route('artworks.show', $artwork->id) }}"
            },
            @endforeach
        ],
        open(artworkId) {
            this.currentArtwork = this.artworks.find(a => a.id === artworkId);
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.isOpen = false;
            this.currentArtwork = null;
            document.body.style.overflow = 'auto';
        }
    };
}

// Event listener for quick view
document.addEventListener('quick-view', (event) => {
    Alpine.store('modal').open(event.detail.id);
});
</script>

<!-- Quick View Modal (same as before but with better styling) -->
<div x-data="quickViewModal()" x-cloak>
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         @click="close">
         
        <div x-show="isOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="bg-white dark:bg-slate-800 rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-hidden shadow-2xl"
             @click.stop>
             
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 bg-slate-100 dark:bg-slate-900 flex items-center justify-center p-8">
                    <img x-bind:src="currentArtwork?.image_url" 
                         x-bind:alt="currentArtwork?.title"
                         class="max-h-[60vh] w-auto object-contain rounded-2xl shadow-xl">
                </div>
                
                <div class="md:w-1/2 p-8 flex flex-col">
                    <div class="flex-1">
                        <h2 x-text="currentArtwork?.title" class="font-display text-3xl font-bold text-slate-900 dark:text-white mb-4"></h2>
                        <p x-text="currentArtwork?.description" class="text-slate-600 dark:text-slate-300 mb-6 leading-relaxed"></p>
                        
                        <div class="flex items-center space-x-4 mb-6 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-slate-700 dark:to-slate-600 rounded-xl">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                <span x-text="currentArtwork?.user_initial"></span>
                            </div>
                            <div>
                                <div x-text="currentArtwork?.user_name" class="font-bold text-slate-900 dark:text-white text-lg"></div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Creator</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <a x-bind:href="currentArtwork?.detail_url" 
                           class="flex-1 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 hover:from-pink-500 hover:via-orange-500 hover:to-yellow-400 text-white font-ui font-bold py-4 px-6 rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            View Full Details
                        </a>
                        <button @click="close" 
                                class="px-6 py-4 border-2 border-slate-300 dark:border-slate-600 hover:border-slate-400 dark:hover:border-slate-500 rounded-xl font-ui font-semibold text-slate-700 dark:text-slate-300 transition-all duration-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection