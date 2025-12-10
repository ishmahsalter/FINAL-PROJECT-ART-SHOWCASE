@extends('layouts.app')

@section('title', 'Discover Amazing Artworks')

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
                <span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">R</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">I</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">O</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">T</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">É</span><br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-orange-400 to-pink-400 animate-gradient-x">
                    <span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">A<span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">R<span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">T<span>&nbsp;<span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">S</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">H</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">O</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">W</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">C</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">A</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">S</span><span class="inline-block hover:scale-110 transition-transform duration-300 cursor-default">E</span>
                </span>
            </h1>
        </div>

        <!-- Subheadline with Typing Effect -->
        <p class="font-body text-2xl md:text-3xl mb-12 max-w-3xl mx-auto leading-relaxed opacity-95 font-light"
           x-data="{ text: 'Where extraordinary talent meets global recognition.', displayed: '', index: 0 }"
           x-init="setInterval(() => { if(index < text.length) { displayed += text[index]; index++; } }, 50)"
           x-text="displayed"></p>

        <!-- Animated Stats with Pulse -->
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

        <!-- CTA Buttons with Magnetic Effect -->
        <div class="flex flex-col sm:flex-row gap-6 mt-8"
             x-data="magneticContainer()">
            @guest
                <a href="{{ route('register') }}"
                   class="magnetic-button group relative px-16 py-6 text-xl font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500"
                   :style="`transform: translate(${button1.x}px, ${button1.y}px) hover:-translate-y-2`"
                   @mousemove="handleMove($event, 'button1')"
                   @mouseleave="reset('button1')">
                   <span class="relative z-10 flex items-center">
                        <span class="mr-3">🚀</span>
                        START YOUR JOURNEY
                        <svg class="w-6 h-6 ml-3 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                   </span>
                   <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500"></div>
                   <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500 animate-gradient-x"></div>
                   <div class="absolute -inset-4 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 blur-xl opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
                </a>
            @else
                <a href="{{ route('member.artworks.create') }}"
                   class="magnetic-button group relative px-16 py-6 text-xl font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500"
                   :style="`transform: translate(${button1.x}px, ${button1.y}px) hover:-translate-y-2`"
                   @mousemove="handleMove($event, 'button1')"
                   @mouseleave="reset('button1')">
                   <span class="relative z-10 flex items-center">
                        <span class="mr-3">🎨</span>
                        UPLOAD YOUR ART
                        <svg class="w-6 h-6 ml-3 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                   </span>
                   <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500"></div>
                   <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500 animate-gradient-x"></div>
                   <div class="absolute -inset-4 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 blur-xl opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
                </a>
            @endguest

            <a href="#featured-artworks"
               class="magnetic-button group relative px-16 py-6 text-xl font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 border-2 border-white/30 hover:border-white"
               :style="`transform: translate(${button2.x}px, ${button2.y}px) hover:-translate-y-2`"
               @mousemove="handleMove($event, 'button2')"
               @mouseleave="reset('button2')">
               <span class="relative z-10 flex items-center">
                    <span class="mr-3">✨</span>
                    EXPLORE MASTERPIECES
                    <svg class="w-6 h-6 ml-3 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
               </span>
               <div class="absolute inset-0 bg-white/10 backdrop-blur-md"></div>
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce-slow z-20">
        <div class="flex flex-col items-center text-white/60 hover:text-white transition-colors cursor-pointer"
             onclick="document.querySelector('#featured-artworks').scrollIntoView({ behavior: 'smooth' })">
            <span class="text-sm uppercase tracking-widest mb-2">DISCOVER MORE</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>
</section>

<div id="main-content">
    <!-- Search & Filter -->
    @include('home.partials.search-filter')
    
    <!-- Featured Artworks -->
    @include('home.partials.featured-artworks')
    
    <!-- Popular Artworks -->
    @include('home.partials.popular-artworks')
    
    <!-- Active Challenges -->
    @include('home.partials.active-challenges')
    
    <!-- Latest Artworks -->
    @include('home.partials.latest-artworks')
</div>

<!-- FEATURED ARTWORKS - INFINITE SLIDER -->
<section id="featured-artworks" class="py-32 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900 overflow-hidden">
    <div class="container mx-auto px-6">
        <!-- Section Header -->
        <div class="text-center mb-20 mt-32">
            <h2 class="font-display text-6xl md:text-7xl font-bold text-white mb-6">
                FEATURED <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500">GALLERY</span>
            </h2>
            <p class="text-xl text-purple-200 max-w-2xl mx-auto">
                Curated collection of exceptional artworks from our global community
            </p>
        </div>

        <!-- Infinite Auto-Scrolling Gallery -->
        <div class="relative">
            <!-- First Row (Left to Right) -->
            <div class="infinite-scroll-container mb-12">
                <div class="infinite-scroll-track animate-scroll-left">
                    @foreach($artworks->take(10) as $artwork)
                    <div class="artwork-card group">
                        <div class="relative w-80 h-96 rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500 border-2 border-purple-500/20 hover:border-purple-500">
                            <img src="{{ Storage::url($artwork->image_path) }}" 
                                 alt="{{ $artwork->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/80 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h3 class="text-white font-bold text-xl mb-2">{{ $artwork->title }}</h3>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($artwork->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-white/80">{{ $artwork->user->display_name ?? $artwork->user->name }}</span>
                                </div>
                            </div>
                            <div class="absolute top-4 right-4 px-3 py-1 bg-purple-600/80 backdrop-blur-sm rounded-full text-xs font-bold text-white">
                                {{ $artwork->category->name ?? 'ART' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- Duplicate for seamless loop -->
                    @foreach($artworks->take(10) as $artwork)
                        <!-- card duplikat persis sama -->
                        <div class="artwork-card group">
                            <div class="relative w-80 h-96 rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500 border-2 border-purple-500/20 hover:border-purple-500">
                                <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-purple-900/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h3 class="text-white font-bold text-xl mb-2">{{ $artwork->title }}</h3>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($artwork->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-white/80">{{ $artwork->user->display_name ?? $artwork->user->name }}</span>
                                    </div>
                                </div>
                                <div class="absolute top-4 right-4 px-3 py-1 bg-purple-600/80 backdrop-blur-sm rounded-full text-xs font-bold text-white">
                                    {{ $artwork->category->name ?? 'ART' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Second Row (Right to Left) -->
            <div class="infinite-scroll-container">
                <div class="infinite-scroll-track animate-scroll-right">
                    @foreach($artworks->slice(5, 10) as $artwork)
                        <!-- card sama -->
                        <div class="artwork-card group">
                            <div class="relative w-80 h-96 rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500 border-2 border-purple-500/20 hover:border-purple-500">
                                <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-purple-900/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h3 class="text-white font-bold text-xl mb-2">{{ $artwork->title }}</h3>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($artwork->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-white/80">{{ $artwork->user->display_name ?? $artwork->user->name }}</span>
                                    </div>
                                </div>
                                <div class="absolute top-4 left-4 px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full text-xs font-bold text-white">
                                    TRENDING
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Duplicate -->
                    @foreach($artworks->slice(5, 10) as $artwork)
                        <!-- card duplikat persis -->
                        <div class="artwork-card group">
                            <div class="relative w-80 h-96 rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500 border-2 border-purple-500/20 hover:border-purple-500">
                                <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-purple-900/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h3 class="text-white font-bold text-xl mb-2">{{ $artwork->title }}</h3>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($artwork->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-white/80">{{ $artwork->user->display_name ?? $artwork->user->name }}</span>
                                    </div>
                                </div>
                                <div class="absolute top-4 left-4 px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full text-xs font-bold text-white">
                                    TRENDING
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-20">
            <a href="{{ route('artworks.index') }}"
               class="inline-flex items-center px-12 py-6 bg-gradient-to-r from-purple-500 via-pink-500 to-purple-700 hover:from-pink-600 hover:via-purple-600 hover:to-purple-800 text-white font-bold text-lg rounded-2xl shadow-[0_0_50px_rgba(168,85,247,0.3)] hover:shadow-[0_0_80px_rgba(168,85,247,0.5)] transition-all duration-500 transform hover:-translate-y-2 hover:scale-105">
                <span>EXPLORE ALL ARTWORKS</span>
                <svg class="w-6 h-6 ml-3 transform hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- LIVE CHALLENGES - INTERACTIVE CAROUSEL -->
@if($challenges->count() > 0)
<section class="py-32 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900 relative overflow-hidden">
    <!-- Animated Background (tetap dipertahankan) -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"100\" height=\"100\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\" fill=\"%23fbbf24\"%3E%3C/path%3E%3C/svg%3E');"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-20">
            <h2 class="font-display text-6xl md:text-7xl font-bold text-white mb-6">
                LIVE <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">CHALLENGES</span>
            </h2>
            <p class="text-xl text-purple-200 max-w-2xl mx-auto">
                Compete, create, and win amazing prizes in our exclusive challenges
            </p>
        </div>

        <!-- Interactive Challenge Cards (semua warna gold tetap!) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach($challenges->take(3) as $index => $challenge)
            <div class="challenge-card-wrapper"
                 x-data="{ hover: false, progress: {{ $challenge->submissions->count() }}, maxProgress: 50 }">
                <div class="relative bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl overflow-hidden border border-purple-500/30 hover:border-yellow-400 transition-all duration-500 transform hover:-translate-y-4 hover:scale-[1.02]"
                     @mouseenter="hover = true"
                     @mouseleave="hover = false">
                   
                    <!-- Countdown Timer -->
                    <div class="absolute top-6 right-6 z-20">
                        <div class="flex items-center space-x-2 px-4 py-2 bg-black/80 backdrop-blur-sm rounded-full">
                            <svg class="w-5 h-5 text-yellow-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white font-bold">{{ $challenge->end_date->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Banner Image -->
                    <div class="relative h-56 overflow-hidden">
                        @if($challenge->banner_image)
                        <img src="{{ Storage::url($challenge->banner_image) }}" alt="{{ $challenge->title }}"
                             class="w-full h-full object-cover transform transition-transform duration-700"
                             :class="hover ? 'scale-110' : ''">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806a3.42 3.42 0 014.438 0a3.42 3.42 0 001.946.806a3.42 3.42 0 013.138 3.138a3.42 3.42 0 00.806 1.946a3.42 3.42 0 010 4.438a3.42 3.42 0 00-.806 1.946a3.42 3.42 0 01-3.138 3.138a3.42 3.42 0 00-1.946.806a3.42 3.42 0 01-4.438 0a3.42 3.42 0 00-1.946-.806a3.42 3.42 0 01-3.138-3.138a3.42 3.42 0 00-.806-1.946a3.42 3.42 0 010-4.438a3.42 3.42 0 00.806-1.946a3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900 via-purple-900/50 to-transparent"></div>
                    </div>

                    <!-- Content -->
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-white mb-4 line-clamp-1">{{ $challenge->title }}</h3>
                        <p class="text-purple-200 mb-6 line-clamp-2">{{ $challenge->description }}</p>
                       
                        <!-- Progress Bar -->
                        <div class="mb-6">
                            <div class="flex justify-between text-sm text-purple-300 mb-2">
                                <span>Submissions Progress</span>
                                <span x-text="`${progress} / ${maxProgress}`"></span>
                            </div>
                            <div class="h-2 bg-purple-800/50 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-yellow-400 to-pink-500 rounded-full transition-all duration-1000"
                                     :style="`width: ${(progress / maxProgress) * 100}%`"></div>
                            </div>
                        </div>

                        <!-- Prize & CTA -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">$</span>
                                </div>
                                <div>
                                    <div class="text-sm text-purple-300">Prize Pool</div>
                                    <div class="text-white font-bold">{{ $challenge->prize ?? 'Amazing Rewards' }}</div>
                                </div>
                            </div>
                            <a href="{{ route('challenges.show', $challenge->id) }}"
                               class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-pink-500 hover:from-pink-500 hover:to-yellow-400 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105">
                                JOIN NOW
                            </a>
                        </div>
                    </div>

                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-3xl opacity-0 blur transition-opacity duration-500"
                         :class="hover ? 'opacity-20' : ''"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- TESTIMONIALS - PARALLAX CARDS (Gold Accent Version) -->
<section class="py-32 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 2px 2px, rgba(251, 191, 36, 0.2) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="container mx-auto px-6">
        <div class="text-center mb-20">
            <h2 class="font-display text-6xl md:text-7xl font-bold text-white mb-6">
                WHAT <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">CREATORS SAY</span>
            </h2>
            <p class="text-xl text-purple-200 max-w-2xl mx-auto">Join thousands of artists who found their audience</p>
        </div>

        <!-- Parallax Testimonial Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8"
             x-data="parallaxGallery()"
             @mousemove="handleParallax($event)">
            @foreach([1,2,3] as $index)
            <div class="testimonial-card"
                 :style="`transform: translate(${cards[{{ $index-1 }}].x}px, ${cards[{{ $index-1 }}].y}px) rotateY(${cards[{{ $index-1 }}].rotateY}deg) rotateX(${cards[{{ $index-1 }}].rotateX}deg)`">
                <div class="bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl p-8 border border-purple-500/30 h-full">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4 border-2 border-yellow-400">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=creator{{ $index }}" alt="Creator" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="text-white font-bold text-lg">Creator {{ $index }}</div>
                            <div class="text-yellow-400 text-sm">Digital Artist</div>
                        </div>
                    </div>
                    <p class="text-purple-200 mb-6 italic">
                        "ArtShowcase transformed my career. I went from creating in my bedroom to having my work featured in galleries worldwide. The community is incredibly supportive!"
                    </p>
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        @endfor
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- GANTI DENGAN SECTION FINAL CTA YANG BENAR -->
<section class="py-32 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-[0.03]">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(168, 85, 247, 0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(168, 85, 247, 0.2) 1px, transparent 1px); background-size: 100px 100px;"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-32 w-64 h-64 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-full blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-1/4 -right-32 w-64 h-64 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl animate-float-medium"></div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-6 text-center relative z-10">
        <!-- Title -->
        <h2 class="font-display text-6xl md:text-7xl font-bold text-white mb-8">
            Ready to <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">Showcase</span> Your Art?
        </h2>
        
        <!-- Description -->
        <p class="text-xl text-purple-200 max-w-2xl mx-auto mb-12">
            Join thousands of creators who've found their audience, won prizes, and transformed their passion into recognition.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-8 justify-center items-center mb-16">
            <!-- Primary Button -->
            <a href="{{ route('register') }}"
               class="magnetic-button group relative px-20 py-7 text-2xl font-black rounded-3xl overflow-hidden transform hover:-translate-y-3 transition-all duration-700 shadow-[0_20px_60px_rgba(245,158,11,0.3)]">
               
               <!-- Background Gradient -->
               <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 via-amber-500 to-orange-500"></div>
               
               <!-- Content -->
               <span class="relative z-10 flex items-center gap-4 text-gray-900 tracking-wide">
                   ✨ CREATE YOUR FREE ACCOUNT
                   <svg class="w-8 h-8 group-hover:translate-x-3 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                   </svg>
               </span>
               
               <!-- Shine Effect -->
               <span class="absolute inset-0 translate-x-[-150%] skew-x-12 bg-gradient-to-r from-transparent via-white/50 to-transparent opacity-30 group-hover:translate-x-[150%] transition-transform duration-1000"></span>
            </a>

            <!-- Secondary Button -->
            <a href="#featured-artworks"
               class="group relative px-16 py-6 text-xl font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 border-2 border-white/30 hover:border-white/60 backdrop-blur-xl">
               
               <!-- Glass Background -->
               <div class="absolute inset-0 bg-white/10 backdrop-blur-md"></div>
               
               <!-- Content -->
               <span class="relative z-10 flex items-center gap-3 text-white">
                   🔍 EXPLORE WITHOUT SIGN UP
                   <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                   </svg>
               </span>
            </a>
        </div>
        
        <!-- Trust Badges -->
        <div class="flex flex-wrap justify-center gap-8">
            @foreach([
                ['emoji' => '✅', 'text' => 'No credit card required', 'delay' => '0'],
                ['emoji' => '⚡', 'text' => 'Setup in under 2 minutes', 'delay' => '100'],
                ['emoji' => '🛡️', 'text' => '100% secure & private', 'delay' => '200'],
                ['emoji' => '🏆', 'text' => 'Win real prizes', 'delay' => '300']
            ] as $badge)
            <div class="trust-badge group relative px-8 py-5 rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-2"
                 x-data="{ visible: false }"
                 x-intersect="visible = true"
                 x-transition:enter="transition ease-out duration-500 delay-{{ $badge['delay'] }}"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <!-- Glass Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 to-indigo-900/30 backdrop-blur-xl border border-purple-500/30 group-hover:border-yellow-400/50 transition-all duration-500"></div>
                
                <!-- Gold Glow on Hover -->
                <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400/0 via-amber-500/0 to-orange-500/0 group-hover:from-yellow-400/10 group-hover:via-amber-500/10 group-hover:to-orange-500/10 blur-xl transition-all duration-700 rounded-3xl"></div>
                
                <!-- Content -->
                <div class="relative z-10 flex items-center gap-4">
                    <div class="text-3xl transform group-hover:scale-125 group-hover:rotate-12 transition-all duration-500">
                        {{ $badge['emoji'] }}
                    </div>
                    <span class="text-lg font-semibold text-purple-100 group-hover:text-yellow-200 transition-colors duration-500">
                        {{ $badge['text'] }}
                    </span>
                </div>
                
                <!-- Pulse Animation -->
                <div class="absolute inset-0 rounded-2xl border-2 border-yellow-400/0 group-hover:border-yellow-400/30 animate-pulse transition-all duration-700"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 🎵 BACKGROUND MUSIC PLAYER (Optional) -->
<div class="fixed bottom-6 right-6 z-50">
    <button @click="musicPlaying = !musicPlaying"
            x-data="{ musicPlaying: false }"
            class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-2xl hover:shadow-[0_0_30px_rgba(168,85,247,0.5)] transition-all duration-300 transform hover:scale-110">
        <span x-show="!musicPlaying" class="text-2xl">🎵</span>
        <span x-show="musicPlaying" class="text-2xl">🔇</span>
    </button>
</div>
@endsection

@push('styles')
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

@keyframes scroll-left {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

@keyframes scroll-right {
    0% { transform: translateX(-50%); }
    100% { transform: translateX(0); }
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}

/* Utility Classes */
.animate-gradient-shift { animation: gradient-shift 15s ease infinite; background-size: 200% 200%; }
.animate-gradient-x { animation: gradient-x 3s ease infinite; background-size: 200% auto; }
.animate-text-shimmer { animation: text-shimmer 3s linear infinite; }
.animate-float-slow { animation: float-slow 20s ease-in-out infinite; }
.animate-float-medium { animation: float-medium 15s ease-in-out infinite; }
.animate-float-fast { animation: float-fast 10s ease-in-out infinite; }
.animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
.animate-bounce { animation: bounce-slow 2s ease-in-out infinite; }
.animate-blob { animation: blob 7s ease-in-out infinite; }
.animate-scroll-left { animation: scroll-left 40s linear infinite; }
.animate-scroll-right { animation: scroll-right 40s linear infinite; }
.animate-blink { animation: blink 1s infinite; }
.animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
.animate-ping { animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite; }

.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }

/* Infinite Scroll Container */
.infinite-scroll-container {
    overflow: hidden;
    position: relative;
}

.infinite-scroll-track {
    display: flex;
    gap: 2rem;
    width: max-content;
}

.artwork-card {
    flex-shrink: 0;
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
::-webkit-scrollbar { 
    width: 12px; 
    height: 10px;
}
::-webkit-scrollbar-track { 
    background: #1e1b4b; 
}
::-webkit-scrollbar-thumb { 
    background: linear-gradient(to bottom, #a855f7, #ec4899); 
    border-radius: 6px; 
}
::-webkit-scrollbar-thumb:hover { 
    background: linear-gradient(to bottom, #9333ea, #db2777); 
}
</style>
@endpush

@push('scripts')
<script>
// Magnetic Buttons Container
function magneticContainer() {
    return {
        button1: { x: 0, y: 0 },
        button2: { x: 0, y: 0 },
        handleMove(event, button) {
            const rect = event.currentTarget.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            this[button].x = (event.clientX - centerX) / 10;
            this[button].y = (event.clientY - centerY) / 10;
        },
        reset(button) {
            this[button].x = 0;
            this[button].y = 0;
        }
    };
}

// Parallax Gallery Effect
function parallaxGallery() {
    return {
        cards: [
            { x: 0, y: 0, rotateY: 0, rotateX: 0 },
            { x: 0, y: 0, rotateY: 0, rotateX: 0 },
            { x: 0, y: 0, rotateY: 0, rotateX: 0 }
        ],
        handleParallax(event) {
            const rect = document.querySelector('.testimonial-card').getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            this.cards.forEach((card, index) => {
                const intensity = (index + 1) * 0.5;
                card.x = (event.clientX - centerX) / (20 / intensity);
                card.y = (event.clientY - centerY) / (20 / intensity);
                card.rotateY = (event.clientX - centerX) / 50;
                card.rotateX = -(event.clientY - centerY) / 50;
            });
        }
    };
}

// Intersection Observer for Animations
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.challenge-card-wrapper, .testimonial-card, .artwork-card').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endpush