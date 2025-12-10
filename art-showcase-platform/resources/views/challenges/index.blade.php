{{-- resources/views/challenges/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Discover Amazing Challenges')

@push('styles')
<style>
/* Import Playfair Display Font */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');

/* FORCE OVERRIDE TEXT SIZE dengan Playfair Display */
.text-override-h1 {
    font-family: 'Playfair Display', serif !important;
    font-size: 6rem !important;
    font-weight: 900 !important;
    letter-spacing: -0.03em !important;
    line-height: 1.2 !important; /* Ganti dari 1.05 jadi 1.2 */
    margin-bottom: 3rem !important; /* Ganti dari 1.5rem jadi 3rem */
    padding-bottom: 2rem !important; /* TAMBAH INI */
    overflow: visible !important;
    height: auto !important;
}


@media (min-width: 640px) {
    .text-override-h1 {
        font-size: 8rem !important;
    }
}

@media (min-width: 768px) {
    .text-override-h1 {
        font-size: 10rem !important;
    }
}

@media (min-width: 1024px) {
    .text-override-h1 {
        font-size: 12rem !important;
    }
}

@media (min-width: 1280px) {
    .text-override-h1 {
        font-size: 14rem !important;
    }
}

/* Gradient text styling */
.text-gradient-override {
    background: linear-gradient(to right, #fbbf24, #fb923c, #ec4899) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    background-clip: text !important;
    background-size: 200% auto !important;
    animation: gradient-x 3s ease infinite !important;
}

/* Challenge Card Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.challenge-card {
    animation: fadeInUp 0.6s ease-out;
    animation-fill-mode: both;
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

/* Cursor Pointer for Cards */
.challenge-card {
    cursor: pointer;
}

/* Smooth Scroll */
html { scroll-behavior: smooth; }

/* Floating Animations */
@keyframes float-slow { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-30px)} }
@keyframes float-medium { 0%,100%{transform:translateY(0)} 50%{transform:translateY(20px)} }
@keyframes float-fast { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-15px)} }

.animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
.animate-float-medium { animation: float-medium 6s ease-in-out infinite; }
.animate-float-fast { animation: float-fast 4s ease-in-out infinite; }

/* Gradient Animations */
@keyframes gradient-x { 
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient-x {
    background-size: 200% auto;
    animation: gradient-x 3s ease infinite;
}

/* Gradient Shift Animation */
@keyframes gradient-shift {
    0%, 100% { opacity: 0.4; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.1); }
}

.animate-gradient-shift {
    animation: gradient-shift 10s ease-in-out infinite;
}

/* Bounce Animation */
@keyframes bounce {
    0%, 100% { transform: translateY(0) translateX(-50%); }
    50% { transform: translateY(-10px) translateX(-50%); }
}

.animate-bounce {
    animation: bounce 2s ease-in-out infinite;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #f59e0b, #ec4899);
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #fbbf24, #db2777);
}

/* Selection Color */
::selection {
    background-color: rgba(245, 158, 11, 0.3);
    color: white;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .text-override-h1 {
        font-size: 4rem !important;
    }
}

/* Scroll Padding for Fixed Navbar */
html {
    scroll-padding-top: 80px;
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
                <h1 class="text-override-h1">
                    <span class="block text-white opacity-90 hover:scale-110 transition-transform duration-300 cursor-default">
                        CHALLENGE
                    </span>
                    <span class="block mt-2 md:mt-4 text-gradient-override hover:scale-110 transition-transform duration-300 cursor-default">
                        AVAILABLE
                    </span>
                </h1>
            </div>

            <p class="font-body text-xl sm:text-2xl md:text-3xl lg:text-4xl text-white/80 mb-10 md:mb-14 max-w-4xl mx-auto leading-relaxed font-light px-4">
                Compete in amazing creative challenges, showcase your talent, and win incredible prizes
            </p>

            <div class="grid grid-cols-3 gap-6 md:gap-10 max-w-3xl mx-auto mb-10 md:mb-16">
                <div class="text-center">
                    <div class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-yellow-400 mb-2">
                        {{ $challenges->total() }}
                    </div>
                    <div class="font-ui text-sm md:text-lg uppercase tracking-widest text-white/70">Challenges</div>
                </div>
                <div class="text-center">
                    @php $activeCount = $statusCounts['active'] ?? 0; @endphp
                    <div class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-yellow-400 mb-2">
                        {{ $activeCount }}
                    </div>
                    <div class="font-ui text-sm md:text-lg uppercase tracking-widest text-white/70">Active Now</div>
                </div>
                <div class="text-center">
                    @php $totalPrize = \App\Models\Challenge::public()->sum('prize_pool') ?? 0; @endphp
                    <div class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-yellow-400 mb-2">
                        ${{ number_format($totalPrize) }}+
                    </div>
                    <div class="font-ui text-sm md:text-lg uppercase tracking-widest text-white/70">Prize Pool</div>
                </div>
            </div>

            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg class="w-8 h-8 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- FILTER SECTION -->
    <section class="relative z-20 -mt-20 md:-mt-32 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-gradient-to-br from-purple-900/80 to-indigo-900/80 backdrop-blur-2xl rounded-3xl p-8 border border-purple-500/40 shadow-2xl">

                <div class="mb-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                        <h3 class="text-white text-2xl md:text-3xl font-bold flex items-center gap-3">
                            <svg class="w-7 h-7 md:w-8 md:h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            FIND CHALLENGES
                        </h3>

                        <div class="flex flex-wrap justify-center md:justify-end gap-3">
                            @foreach(['active' => 'Active', 'upcoming' => 'Upcoming', 'completed' => 'Past'] as $key => $label)
                            <a href="{{ route('challenges.index', array_merge(request()->except('status'), ['status' => $key])) }}"
                               class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300
                                      {{ request('status', 'active') == $key 
                                         ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 shadow-lg' 
                                         : 'bg-purple-800/50 text-purple-200 hover:bg-purple-700/60 hover:text-white' }}">
                                @switch($key)
                                    @case('active') 🔥 @break
                                    @case('upcoming') ⏰ @break
                                    @case('completed') 🏆 @break
                                @endswitch
                                {{ $label }}
                                @if(isset($statusCounts[$key]) && $statusCounts[$key] > 0)
                                <span class="ml-2 px-2 py-1 text-xs rounded-full bg-black/20">
                                    {{ $statusCounts[$key] }}
                                </span>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- SEARCH BAR -->
                    <form action="{{ route('challenges.index') }}" method="GET" class="relative">
                        <div class="relative flex items-center">
                            <div class="absolute left-6 pointer-events-none">
                                <svg class="w-7 h-7 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search challenges by title, description, theme, or curator..."
                                   class="w-full pl-16 pr-48 py-5 bg-purple-800/40 border-2 border-purple-500/50 rounded-2xl text-white placeholder-purple-300 
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
                </div>

                @auth
                @if(auth()->user()->role === 'curator' && auth()->user()->is_approved)
                <div class="text-center pt-6 border-t border-purple-500/30">
                    <a href="{{ route('curator.challenges.create') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl 
                              hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New Challenge
                    </a>
                </div>
                @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- CHALLENGES GRID -->
    <section class="py-16 md:py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 md:mb-16 text-center">
                <h2 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                    Discover <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">Creative</span> Challenges
                </h2>
                <p class="font-body text-lg md:text-xl text-purple-200 max-w-3xl mx-auto">
                    Join amazing competitions from talented curators around the world
                </p>
            </div>

            @if($challenges->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8" x-data="challengesGrid()">
                @foreach($challenges as $challenge)
                @php
                    $statusClass = [
                        'active' => 'bg-gradient-to-r from-green-500 to-emerald-600',
                        'upcoming' => 'bg-gradient-to-r from-blue-500 to-cyan-600',
                        'completed' => 'bg-gradient-to-r from-purple-500 to-pink-600',
                        'cancelled' => 'bg-gradient-to-r from-gray-500 to-gray-600'
                    ][$challenge->status] ?? 'bg-gradient-to-r from-gray-500 to-gray-600';
                    
                    $statusIcon = [
                        'active' => '🔥',
                        'upcoming' => '⏰',
                        'completed' => '🏆',
                        'cancelled' => '❌'
                    ][$challenge->status] ?? '📝';
                    
                    $timeText = match($challenge->status) {
                        'active' => 'Ends ' . $challenge->end_date->diffForHumans(),
                        'upcoming' => 'Starts ' . $challenge->start_date->diffForHumans(),
                        'completed' => 'Ended ' . $challenge->end_date->diffForHumans(),
                        'cancelled' => 'Cancelled',
                        default => ''
                    };
                    
                    $buttonText = match($challenge->status) {
                        'active' => 'JOIN CHALLENGE',
                        'upcoming' => 'VIEW DETAILS',
                        'completed' => 'SEE WINNERS',
                        'cancelled' => 'VIEW DETAILS',
                        default => 'VIEW DETAILS'
                    };
                @endphp

                <div class="challenge-card group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                     onclick="window.location.href='{{ route('challenges.show', $challenge) }}'"
                     style="animation-delay: {{ $loop->index * 0.1 }}s">

                    <div class="relative bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl overflow-hidden border border-purple-500/30 hover:border-yellow-400/50 transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02] h-full cursor-pointer">
                        <div class="absolute top-4 right-4 z-20">
                            <div class="{{ $statusClass }} text-white px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 backdrop-blur-sm">
                                <span>{{ $statusIcon }}</span>
                                <span>{{ ucfirst($challenge->status) }}</span>
                            </div>
                        </div>

                        @if(!$challenge->is_approved)
                        <div class="absolute top-4 left-4 z-20">
                            <div class="px-3 py-1.5 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 text-xs font-bold rounded-full">
                                PENDING
                            </div>
                        </div>
                        @endif

                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-purple-800 to-indigo-900">
                            @if($challenge->banner_image)
                            <img src="{{ Storage::url($challenge->banner_image) }}" alt="{{ $challenge->title }}"
                                 class="w-full h-full object-cover transform transition-transform duration-700"
                                 :class="hover ? 'scale-110' : ''">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="text-5xl opacity-30">{{ $statusIcon }}</div>
                            </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            
                            <!-- Banner Overlay Content -->
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="flex items-center justify-between">
                                    <!-- Submissions Count -->
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span>{{ $challenge->submissions_count ?? 0 }} submissions</span>
                                    </div>
                                    
                                    <!-- Time Badge -->
                                    @if($challenge->status !== 'cancelled')
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm">
                                        <svg class="w-4 h-4 {{ $challenge->status === 'active' ? 'text-green-400 animate-pulse' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $timeText }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-white font-bold text-xl mb-3 line-clamp-1 hover:text-yellow-300 transition-colors">
                                {{ $challenge->title }}
                            </h3>
                            <p class="text-purple-200 text-sm mb-4 line-clamp-2">
                                {{ Str::limit($challenge->description, 100) }}
                            </p>

                            @if($challenge->theme)
                            <div class="mb-4">
                                <span class="px-3 py-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-bold rounded-full">
                                    {{ $challenge->theme }}
                                </span>
                            </div>
                            @endif

                            <!-- Curator Info -->
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-pink-500 overflow-hidden border-2 border-purple-500/50">
                                    @if($challenge->curator && $challenge->curator->avatar)
                                    <img src="{{ Storage::url($challenge->curator->avatar) }}" 
                                         alt="{{ $challenge->curator->name }}"
                                         class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold">
                                        @if($challenge->curator)
                                            {{ substr($challenge->curator->name, 0, 1) }}
                                        @else
                                            ?
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-white text-sm font-medium">{{ $challenge->curator->name ?? 'Unknown Curator' }}</div>
                                    <div class="text-purple-300 text-xs">Curator</div>
                                </div>
                            </div>

                            <!-- Progress Bar (for active challenges) -->
                            @if($challenge->status === 'active')
                            <div class="mb-6">
                                <div class="flex justify-between text-xs text-purple-300 mb-2">
                                    <span>Time remaining</span>
                                    @php
                                        $totalDays = $challenge->start_date->diffInDays($challenge->end_date);
                                        $daysPassed = $challenge->start_date->diffInDays(now());
                                        $progress = min(100, ($daysPassed / max(1, $totalDays)) * 100);
                                        $daysLeft = $challenge->end_date->diffInDays(now());
                                    @endphp
                                    <span>{{ $daysLeft }} days left</span>
                                </div>
                                <div class="w-full h-2 bg-purple-800/50 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full transition-all duration-1000"
                                         style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            @endif

                            <!-- Prize & Dates -->
                            <div class="space-y-3">
                                <!-- Prize -->
                                @if($challenge->prize_pool)
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-400/10 to-orange-500/10 rounded-xl border border-yellow-400/20">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-white font-bold">Prize Pool</span>
                                    </div>
                                    <span class="text-yellow-300 font-bold">${{ number_format($challenge->prize_pool) }}</span>
                                </div>
                                @endif
                                
                                <!-- Dates -->
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div class="p-2 bg-purple-800/30 rounded-lg border border-purple-500/30">
                                        <div class="text-purple-300 text-xs">Start Date</div>
                                        <div class="text-white font-medium">
                                            @if($challenge->start_date)
                                                {{ $challenge->start_date->format('M d, Y') }}
                                            @else
                                                TBD
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-2 bg-purple-800/30 rounded-lg border border-purple-500/30">
                                        <div class="text-purple-300 text-xs">End Date</div>
                                        <div class="text-white font-medium">
                                            @if($challenge->end_date)
                                                {{ $challenge->end_date->format('M d, Y') }}
                                            @else
                                                TBD
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="mt-6">
                                <a href="{{ route('challenges.show', $challenge) }}"
                                   class="block w-full text-center py-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                    {{ $buttonText }}
                                </a>
                            </div>
                        </div>

                        <!-- Glow Effect -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400/0 via-orange-500/0 to-pink-500/0 group-hover:from-yellow-400/20 group-hover:via-orange-500/20 group-hover:to-pink-500/20 blur-xl rounded-3xl transition-all duration-700"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($challenges->hasPages())
            <div class="mt-16 flex justify-center">
                {{ $challenges->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl flex items-center justify-center border border-purple-500/30">
                    <svg class="w-20 h-20 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">
                    @if(request('status') === 'active')
                    No Active Challenges
                    @elseif(request('status') === 'upcoming')
                    No Upcoming Challenges
                    @elseif(request('status') === 'completed')
                    No Past Challenges
                    @else
                    No Challenges Found
                    @endif
                </h3>
                <p class="text-purple-300 mb-8 max-w-md mx-auto">
                    @if(request('search'))
                    Try a different search term
                    @else
                    Check back soon for new challenges!
                    @endif
                </p>
                
                <!-- Create Challenge CTA -->
                @auth
                @if(auth()->user()->role === 'curator' && auth()->user()->is_approved)
                <a href="{{ route('curator.challenges.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl hover:shadow-[0_0_30px_rgba(16,185,129,0.3)] transition-all transform hover:-translate-y-1">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    CREATE FIRST CHALLENGE
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
                Ready to <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">Challenge</span> Your Creativity?
            </h2>
            
            <p class="text-xl text-purple-200 max-w-2xl mx-auto mb-10">
                Join exciting competitions, push your creative boundaries, and get recognized by industry experts
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                @auth
                    @if(auth()->user()->role === 'member')
                        <!-- For Members: Join Challenge -->
                        <a href="{{ route('challenges.index') }}?status=active"
                           class="group relative px-10 py-5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 shadow-[0_0_40px_rgba(245,158,11,0.3)]">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                🎯 FIND ACTIVE CHALLENGES
                                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500 animate-gradient-x"></div>
                        </a>
                        
                        <!-- Submit Artwork -->
                        <a href="{{ route('member.artworks.create') }}"
                           class="group relative px-10 py-5 bg-gradient-to-br from-purple-600 to-indigo-700 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 border-2 border-purple-500/30 hover:border-yellow-400">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                🎨 CREATE ARTWORK
                                <svg class="w-6 h-6 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-md"></div>
                        </a>
                    @elseif(auth()->user()->role === 'curator' && auth()->user()->is_approved)
                        <!-- For Curators: Create Challenge -->
                        <a href="{{ route('curator.challenges.create') }}"
                           class="group relative px-10 py-5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 shadow-[0_0_40px_rgba(16,185,129,0.3)]">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                🚀 CREATE NEW CHALLENGE
                                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </span>
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
                    
                    <!-- Explore Challenges -->
                    <a href="{{ route('challenges.index') }}?status=active"
                       class="group relative px-10 py-5 bg-gradient-to-br from-purple-600 to-indigo-700 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 border-2 border-purple-500/30 hover:border-yellow-400">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            🔍 EXPLORE CHALLENGES
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
                    <div class="text-3xl font-bold text-yellow-400">500+</div>
                    <div class="text-sm text-purple-300 mt-2">Active Creators</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">$50K+</div>
                    <div class="text-sm text-purple-300 mt-2">Awarded</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">24/7</div>
                    <div class="text-sm text-purple-300 mt-2">Support</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">100%</div>
                    <div class="text-sm text-purple-300 mt-2">Transparent</div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
// Challenges Grid Effects
function challengesGrid() {
    return {
        init() {
            // Add staggered animation delays
            this.$nextTick(() => {
                const cards = this.$el.querySelectorAll('.challenge-card');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                });
            });
        }
    };
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    // Add click handler for all challenge cards
    document.querySelectorAll('.challenge-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking on a link or button
            if (!e.target.closest('a') && !e.target.closest('button')) {
                const link = this.querySelector('a[href]');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
    });
    
    // Smooth scroll to sections with offset for navbar
    const navbarHeight = document.querySelector('nav')?.offsetHeight || 80;
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - navbarHeight,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>
@endpush