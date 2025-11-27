@extends('layouts.app')

@section('title', 'Discover Amazing Artworks')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-accent-sage/10 via-primary-50 to-accent-gold/5 dark:from-dark-bg dark:via-dark-card dark:to-dark-bg py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-accent-gold rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-sage rounded-full filter blur-3xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-bold text-primary-900 dark:text-white mb-6 animate-fade-in">
            Discover <span class="text-accent-gold">Amazing</span> Artworks
        </h1>
        <p class="font-body text-xl text-primary-600 dark:text-primary-300 mb-8 max-w-2xl mx-auto animate-slide-up">
            A platform where creativity meets community. Explore, share, and celebrate art from talented creators worldwide.
        </p>
        
        @guest
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up">
                <a href="{{ route('register') }}" class="px-8 py-3 bg-accent-gold hover:bg-accent-gold-dark text-white font-ui font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Start Creating
                </a>
                <a href="#gallery" class="px-8 py-3 bg-white dark:bg-dark-card text-primary-800 dark:text-primary-100 font-ui font-semibold rounded-lg shadow-md hover:shadow-lg transition-all border border-primary-200 dark:border-dark-border">
                    Explore Gallery
                </a>
            </div>
        @endguest
    </div>
</section>

<!-- Active Challenges Section -->
@if($challenges->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-display text-3xl font-bold text-primary-900 dark:text-white mb-2">
                Active Challenges
            </h2>
            <p class="text-primary-600 dark:text-primary-400">
                Join exciting challenges and showcase your talent
            </p>
        </div>
        <a href="{{ route('challenges.index') }}" class="text-accent-gold hover:text-accent-gold-dark font-ui font-medium transition">
            View All →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($challenges->take(3) as $challenge)
            <a href="{{ route('challenges.show', $challenge->id) }}" class="group">
                <div class="bg-white dark:bg-dark-card rounded-lg overflow-hidden shadow-gallery hover:shadow-gallery-hover transition-all transform hover:-translate-y-1">
                    @if($challenge->banner_image)
                        <div class="aspect-[16/9] overflow-hidden bg-primary-100 dark:bg-dark-bg">
                            <img src="{{ Storage::url($challenge->banner_image) }}" 
                                 alt="{{ $challenge->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    @else
                        <div class="aspect-[16/9] bg-gradient-to-br from-accent-gold to-accent-sage flex items-center justify-center">
                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                    @endif

                    <div class="p-5">
                        <h3 class="font-display text-xl font-bold text-primary-900 dark:text-white group-hover:text-accent-gold transition mb-2 line-clamp-1">
                            {{ $challenge->title }}
                        </h3>
                        <p class="text-primary-600 dark:text-primary-400 text-sm mb-4 line-clamp-2">
                            {{ $challenge->description }}
                        </p>
                        
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-1 text-primary-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $challenge->end_date->diffForHumans() }}</span>
                            </div>
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-medium">
                                Active
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

<!-- Filter & Search Section -->
<section id="gallery" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="font-display text-3xl font-bold text-primary-900 dark:text-white mb-2">
                Gallery
            </h2>
            <p class="text-primary-600 dark:text-primary-400">
                {{ $artworks->total() }} amazing artworks
            </p>
        </div>

        <!-- Filter & Sort -->
        <div class="flex flex-wrap gap-3">
            <!-- Category Filter -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 px-4 py-2 bg-white dark:bg-dark-card border border-primary-200 dark:border-dark-border rounded-lg hover:border-accent-gold transition">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="font-ui text-sm">{{ request('category') ? $categories->find(request('category'))->name : 'All Categories' }}</span>
                    <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card rounded-lg shadow-gallery-hover border border-primary-200 dark:border-dark-border overflow-hidden z-10">
                    <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-primary-50 dark:hover:bg-dark-bg transition text-primary-700 dark:text-primary-300 text-sm">
                        All Categories
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('home', ['category' => $cat->id]) }}" class="block px-4 py-2 hover:bg-primary-50 dark:hover:bg-dark-bg transition text-primary-700 dark:text-primary-300 text-sm {{ request('category') == $cat->id ? 'bg-accent-gold/10 text-accent-gold' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Sort -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 px-4 py-2 bg-white dark:bg-dark-card border border-primary-200 dark:border-dark-border rounded-lg hover:border-accent-gold transition">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                    </svg>
                    <span class="font-ui text-sm">
                        @if(request('sort') == 'popular') Popular
                        @elseif(request('sort') == 'views') Most Viewed
                        @else Latest
                        @endif
                    </span>
                    <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-dark-card rounded-lg shadow-gallery-hover border border-primary-200 dark:border-dark-border overflow-hidden z-10">
                    <a href="{{ route('home', array_merge(request()->except('sort'), [])) }}" class="block px-4 py-2 hover:bg-primary-50 dark:hover:bg-dark-bg transition text-primary-700 dark:text-primary-300 text-sm {{ !request('sort') ? 'bg-accent-gold/10 text-accent-gold' : '' }}">
                        Latest
                    </a>
                    <a href="{{ route('home', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}" class="block px-4 py-2 hover:bg-primary-50 dark:hover:bg-dark-bg transition text-primary-700 dark:text-primary-300 text-sm {{ request('sort') == 'popular' ? 'bg-accent-gold/10 text-accent-gold' : '' }}">
                        Most Liked
                    </a>
                    <a href="{{ route('home', array_merge(request()->except('sort'), ['sort' => 'views'])) }}" class="block px-4 py-2 hover:bg-primary-50 dark:hover:bg-dark-bg transition text-primary-700 dark:text-primary-300 text-sm {{ request('sort') == 'views' ? 'bg-accent-gold/10 text-accent-gold' : '' }}">
                        Most Viewed
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Artworks Grid (Masonry Layout) -->
    @if($artworks->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($artworks as $artwork)
                <x-artwork-card :artwork="$artwork" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $artworks->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <svg class="w-24 h-24 mx-auto text-primary-300 dark:text-primary-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="font-display text-2xl font-bold text-primary-900 dark:text-white mb-2">
                No artworks found
            </h3>
            <p class="text-primary-600 dark:text-primary-400 mb-6">
                Be the first to share your amazing work!
            </p>
            @auth
                @if(auth()->user()->role === 'member')
                    <a href="{{ route('member.artworks.create') }}" class="inline-block px-6 py-3 bg-accent-gold hover:bg-accent-gold-dark text-white font-ui font-semibold rounded-lg shadow-lg transition">
                        Upload Your First Artwork
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-accent-gold hover:bg-accent-gold-dark text-white font-ui font-semibold rounded-lg shadow-lg transition">
                    Join Now
                </a>
            @endauth
        </div>
    @endif
</section>

@endsection