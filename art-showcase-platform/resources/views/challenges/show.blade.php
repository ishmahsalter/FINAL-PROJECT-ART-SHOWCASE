{{-- resources/views/challenges/show.blade.php --}}
@extends('layouts.app')

@section('title', $challenge->title . ' | ArtShowcase')

@push('styles')
<style>
/* Import Playfair Display Font */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');

/* Hero Title */
.challenge-hero-title {
    font-family: 'Playfair Display', serif !important;
    font-size: 4rem !important;
    font-weight: 900 !important;
    letter-spacing: -0.02em !important;
    line-height: 1.1 !important;
}

@media (min-width: 768px) {
    .challenge-hero-title {
        font-size: 5rem !important;
    }
}

@media (min-width: 1024px) {
    .challenge-hero-title {
        font-size: 6rem !important;
    }
}

/* Status Badges */
.status-badge-active {
    background: linear-gradient(135deg, #10b981, #059669);
    animation: pulse-green 2s infinite;
}

.status-badge-upcoming {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.status-badge-completed {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

@keyframes pulse-green {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Progress Bar */
.progress-bar {
    height: 10px;
    border-radius: 5px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #34d399);
    border-radius: 5px;
    transition: width 1s ease-out;
}

/* Timeline */
.timeline-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid #8b5cf6;
    background: white;
}

.timeline-dot.active {
    background: #8b5cf6;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.3);
}

.timeline-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(90deg, #8b5cf6, transparent);
}

/* Countdown Timer */
.countdown-box {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.countdown-number {
    font-size: 2.5rem;
    font-weight: bold;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Submission Card */
.submission-card {
    transition: all 0.3s ease;
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(10px);
}

.submission-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    background: rgba(30, 41, 59, 0.9);
}

/* Floating Animations */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

/* Glass Effect */
.glass-panel {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Gradient Text */
.text-gradient-challenge {
    background: linear-gradient(135deg, #fbbf24, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Rules List */
.rules-list li {
    position: relative;
    padding-left: 2rem;
}

.rules-list li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #10b981;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .challenge-hero-title {
        font-size: 3rem !important;
    }
    
    .countdown-number {
        font-size: 2rem;
    }
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900">
    
    <!-- HERO SECTION -->
    <section class="relative pt-24 pb-16 md:pt-32 md:pb-24 overflow-hidden">
        <div class="absolute inset-0">
            <!-- Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900"></div>
            
            <!-- Animated Gradient Overlay -->
            <div class="absolute inset-0 opacity-40">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 via-orange-500/20 to-pink-500/20 animate-gradient-shift"></div>
            </div>
            
            <!-- Floating Shapes -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-br from-yellow-400/10 to-orange-500/10 rounded-full filter blur-3xl animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full filter blur-3xl animate-float" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('challenges.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-lg text-white hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Challenges
                </a>
            </div>
            
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Info -->
                <div class="lg:col-span-2">
                    <!-- Status & Featured Badge -->
                    <div class="flex flex-wrap gap-3 mb-6">
                        @php
                            $statusClasses = [
                                'active' => 'status-badge-active',
                                'upcoming' => 'status-badge-upcoming',
                                'completed' => 'status-badge-completed'
                            ];
                        @endphp
                        <span class="{{ $statusClasses[$challenge->status] ?? 'bg-gray-600' }} text-white px-4 py-2 rounded-full text-sm font-bold">
                            {{ strtoupper($challenge->status) }}
                        </span>
                        
                        @if($challenge->is_featured)
                        <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 px-4 py-2 rounded-full text-sm font-bold">
                            ⭐ FEATURED
                        </span>
                        @endif
                        
                        @if($challenge->prize_pool > 0)
                        <span class="bg-gradient-to-r from-green-400 to-emerald-500 text-white px-4 py-2 rounded-full text-sm font-bold">
                            🏆 ${{ number_format($challenge->prize_pool) }} PRIZE
                        </span>
                        @endif
                    </div>
                    
                    <!-- Title -->
                    <h1 class="challenge-hero-title text-white mb-6">
                        {{ $challenge->title }}
                    </h1>
                    
                    <!-- Description -->
                    <div class="glass-panel rounded-2xl p-6 mb-8">
                        <h3 class="text-white text-xl font-bold mb-4">📝 Challenge Description</h3>
                        <p class="text-purple-200 leading-relaxed">
                            {{ $challenge->description }}
                        </p>
                    </div>
                    
                    <!-- Theme & Rules -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <!-- Theme -->
                        @if($challenge->theme)
                        <div class="glass-panel rounded-2xl p-6">
                            <h3 class="text-white text-lg font-bold mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                Theme
                            </h3>
                            <p class="text-yellow-300 text-2xl font-bold">{{ $challenge->theme }}</p>
                        </div>
                        @endif
                        
                        <!-- Submissions Count -->
                        <div class="glass-panel rounded-2xl p-6">
                            <h3 class="text-white text-lg font-bold mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Submissions
                            </h3>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-bold text-white">{{ $challenge->submissions_count ?? 0 }}</span>
                                <span class="text-purple-300">artworks submitted</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rules -->
                    @if($challenge->rules)
                    <div class="glass-panel rounded-2xl p-6 mb-8">
                        <h3 class="text-white text-xl font-bold mb-4">📋 Challenge Rules</h3>
                        <div class="prose prose-invert max-w-none">
                            {!! nl2br(e($challenge->rules)) !!}
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Right Column: Sidebar -->
                <div class="space-y-6">
                    <!-- Countdown Timer (for active challenges) -->
                    @if($challenge->status === 'active')
                    <div class="glass-panel rounded-2xl p-6">
                        <h3 class="text-white text-lg font-bold mb-4">⏰ Time Remaining</h3>
                        <div class="countdown-box rounded-xl p-4 text-center mb-4">
                            @php
                                $now = \Carbon\Carbon::now();
                                $endDate = \Carbon\Carbon::parse($challenge->end_date);
                                $diff = $now->diff($endDate);
                                
                                // Pastikan tidak ada nilai negatif
                                $daysLeft = max(0, $diff->days);
                                $hoursLeft = max(0, $diff->h);
                                $minutesLeft = max(0, $diff->i);
                            @endphp
                            
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <div class="countdown-number" id="countdown-days">{{ $daysLeft }}</div>
                                    <div class="text-sm text-purple-300 mt-1">Days</div>
                                </div>
                                <div>
                                    <div class="countdown-number" id="countdown-hours">{{ $hoursLeft }}</div>
                                    <div class="text-sm text-purple-300 mt-1">Hours</div>
                                </div>
                                <div>
                                    <div class="countdown-number" id="countdown-minutes">{{ $minutesLeft }}</div>
                                    <div class="text-sm text-purple-300 mt-1">Minutes</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-purple-300 mb-2">
                                <span>Time Progress</span>
                                <span id="time-left-text">
                                    @if($daysLeft > 0)
                                        {{ $daysLeft }} days left
                                    @elseif($hoursLeft > 0)
                                        {{ $hoursLeft }} hours left
                                    @else
                                        Ending soon!
                                    @endif
                                </span>
                            </div>
                            @php
                                $totalDays = $challenge->start_date->diffInDays($challenge->end_date);
                                $daysPassed = min($totalDays, $challenge->start_date->diffInDays($now));
                                $progress = min(100, max(0, ($daysPassed / max(1, $totalDays)) * 100));
                            @endphp
                            <div class="progress-bar bg-purple-800/50">
                                <div class="progress-fill" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Timeline -->
                    <div class="glass-panel rounded-2xl p-6">
                        <h3 class="text-white text-lg font-bold mb-4">📅 Timeline</h3>
                        <div class="space-y-6">
                            <!-- Start Date -->
                            <div class="flex items-start gap-4">
                                <div class="timeline-dot {{ now() >= $challenge->start_date ? 'active' : '' }} mt-1"></div>
                                <div class="flex-1">
                                    <div class="text-white font-medium">Challenge Starts</div>
                                    <div class="text-purple-300 text-sm">{{ $challenge->start_date->format('F d, Y') }}</div>
                                    @if(now() >= $challenge->start_date)
                                    <div class="text-green-400 text-xs mt-1">✓ Started</div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="timeline-line ml-2"></div>
                            
                            <!-- End Date -->
                            <div class="flex items-start gap-4">
                                <div class="timeline-dot {{ now() >= $challenge->end_date ? 'active' : '' }} mt-1"></div>
                                <div class="flex-1">
                                    <div class="text-white font-medium">Challenge Ends</div>
                                    <div class="text-purple-300 text-sm">{{ $challenge->end_date->format('F d, Y') }}</div>
                                    @if(now() >= $challenge->end_date)
                                    <div class="text-green-400 text-xs mt-1">✓ Ended</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Curator Info -->
                    <div class="glass-panel rounded-2xl p-6">
                        <h3 class="text-white text-lg font-bold mb-4">👑 Curator</h3>
                        <div class="flex items-center gap-4">
                            @if($challenge->curator->profile_image)
                            <img src="{{ $challenge->curator->profile_image }}" 
                                 alt="{{ $challenge->curator->name }}"
                                 class="w-16 h-16 rounded-full object-cover border-2 border-purple-500">
                            @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-yellow-400 to-pink-500 flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($challenge->curator->name, 0, 1) }}
                            </div>
                            @endif
                            <div>
                                <div class="text-white font-bold">{{ $challenge->curator->name }}</div>
                                <div class="text-purple-300 text-sm">{{ $challenge->curator->display_name }}</div>
                                @if($challenge->curator->bio)
                                <p class="text-purple-200 text-sm mt-2 line-clamp-2">{{ $challenge->curator->bio }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        @if($challenge->status === 'active')
                            @auth
                                @if(auth()->user()->role === 'member')
                                    <a href="{{ route('member.submissions.create', $challenge) }}"
                                       class="block w-full text-center py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-emerald-600 hover:to-green-500 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        🎨 Submit Your Artwork
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}"
                                   class="block w-full text-center py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-emerald-600 hover:to-green-500 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                    👤 Sign Up to Participate
                                </a>
                            @endauth
                        @endif
                        
                        <a href="#submissions"
                           class="block w-full text-center py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-pink-600 hover:to-purple-600 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            👁️ View Submissions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- SUBMISSIONS SECTION -->
    <section id="submissions" class="py-16 bg-gradient-to-b from-purple-900/50 to-indigo-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    🎨 <span class="text-gradient-challenge">Submitted Artworks</span>
                </h2>
                <p class="text-purple-200 text-lg max-w-2xl mx-auto">
                    Check out amazing artworks submitted by talented creators
                </p>
            </div>
            
            @if($challenge->submissions && $challenge->submissions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($challenge->submissions as $submission)
                @php($artwork = $submission->artwork)
                <div class="submission-card rounded-2xl overflow-hidden">
                    <a href="{{ route('artworks.show', $artwork) }}">
                        <div class="relative h-64 overflow-hidden bg-gradient-to-br from-purple-800 to-indigo-900">
                            @if($artwork->image_path)
                            <img src="{{ Storage::url($artwork->image_path) }}" 
                                 alt="{{ $artwork->title }}"
                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <div class="px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-xs">
                                    #{{ $loop->iteration }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <h3 class="text-white font-bold text-lg mb-2 line-clamp-1">{{ $artwork->title }}</h3>
                            <p class="text-purple-300 text-sm mb-4 line-clamp-2">{{ $artwork->description }}</p>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if($artwork->user->profile_image)
                                    <img src="{{ $artwork->user->profile_image }}" 
                                         alt="{{ $artwork->user->name }}"
                                         class="w-8 h-8 rounded-full object-cover">
                                    @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-yellow-400 to-pink-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($artwork->user->name, 0, 1) }}
                                    </div>
                                    @endif
                                    <span class="text-white text-sm">{{ $artwork->user->name }}</span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-white text-sm">{{ $artwork->likes_count ?? 0 }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <span class="text-white text-sm">{{ $artwork->comments_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            
            @if($challenge->submissions->count() > 6)
            <div class="text-center mt-12">
                <a href="{{ route('challenges.submissions', $challenge) }}"
                   class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-xl hover:shadow-xl transition-all transform hover:-translate-y-1">
                    View All Submissions
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
            @endif
            
            @else
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-2xl flex items-center justify-center border border-purple-500/30">
                    <svg class="w-16 h-16 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">No Submissions Yet</h3>
                <p class="text-purple-300 mb-8 max-w-md mx-auto">
                    Be the first to submit your artwork to this challenge!
                </p>
                @if($challenge->status === 'active')
                    @auth
                        @if(auth()->user()->role === 'member')
                            <a href="{{ route('member.submissions.create', $challenge) }}"
                               class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl hover:shadow-xl transition-all transform hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Be the First to Submit!
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl hover:shadow-xl transition-all transform hover:-translate-y-1">
                            👤 Sign Up to Participate
                        </a>
                    @endauth
                @endif
            </div>
            @endif
        </div>
    </section>
    
    <!-- RELATED CHALLENGES -->
    @if($relatedChallenges && $relatedChallenges->count() > 0)
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    🔥 More <span class="text-gradient-challenge">Challenges</span> You Might Like
                </h2>
                <p class="text-purple-200 text-lg max-w-2xl mx-auto">
                    Explore other exciting challenges
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedChallenges as $related)
                <a href="{{ route('challenges.show', $related) }}"
                   class="group block bg-gradient-to-br from-purple-900/30 to-indigo-900/30 rounded-2xl p-6 border border-purple-500/30 hover:border-yellow-400/50 transition-all hover:-translate-y-2">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="px-3 py-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xs font-bold rounded-full">
                                {{ ucfirst($related->status) }}
                            </span>
                        </div>
                        @if($related->is_featured)
                        <span class="px-2 py-1 bg-yellow-400/20 text-yellow-300 text-xs rounded-full">⭐</span>
                        @endif
                    </div>
                    
                    <h3 class="text-white font-bold text-lg mb-3 group-hover:text-yellow-300 transition-colors line-clamp-1">
                        {{ $related->title }}
                    </h3>
                    
                    <p class="text-purple-300 text-sm mb-4 line-clamp-2">{{ Str::limit($related->description, 100) }}</p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-yellow-400 to-pink-500"></div>
                            <span class="text-white text-sm">{{ $related->curator->name }}</span>
                        </div>
                        
                        @if($related->prize_pool > 0)
                        <span class="text-yellow-300 text-sm font-bold">${{ number_format($related->prize_pool) }}</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- CTA SECTION -->
    <section class="py-20 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(251, 191, 36, 0.2) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6">
                Ready to <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">Showcase</span> Your Talent?
            </h2>
            
            <p class="text-xl text-purple-200 max-w-2xl mx-auto mb-10">
                Join this challenge and get a chance to win amazing prizes and recognition
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                @if($challenge->status === 'active')
                    @auth
                        @if(auth()->user()->role === 'member')
                            <a href="{{ route('member.submissions.create', $challenge) }}"
                               class="group relative px-10 py-5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 shadow-[0_0_40px_rgba(245,158,11,0.3)]">
                                <span class="relative z-10 flex items-center justify-center gap-3">
                                    🎨 SUBMIT YOUR ARTWORK
                                    <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}"
                           class="group relative px-10 py-5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 shadow-[0_0_40px_rgba(245,158,11,0.3)]">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                ✨ JOIN FOR FREE
                                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                    @endauth
                @endif
                
                <a href="{{ route('challenges.index') }}"
                   class="group relative px-10 py-5 bg-gradient-to-br from-purple-600 to-indigo-700 text-white font-bold rounded-2xl overflow-hidden transform hover:-translate-y-2 transition-all duration-500 border-2 border-purple-500/30 hover:border-yellow-400">
                    <span class="relative z-10 flex items-center justify-center gap-3">
                        🔍 EXPLORE MORE CHALLENGES
                        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
// Countdown Timer
@if($challenge->status === 'active')
function updateCountdown() {
    const endDate = new Date('{{ $challenge->end_date->toIso8601String() }}');
    const now = new Date();
    const timeLeft = endDate - now;
    
    if (timeLeft > 0) {
        // Calculate days, hours, minutes
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        
        // Update display elements
        const daysEl = document.getElementById('countdown-days');
        const hoursEl = document.getElementById('countdown-hours');
        const minutesEl = document.getElementById('countdown-minutes');
        const timeLeftText = document.getElementById('time-left-text');
        
        if (daysEl) daysEl.textContent = days;
        if (hoursEl) hoursEl.textContent = hours;
        if (minutesEl) minutesEl.textContent = minutes;
        
        // Update time left text
        if (timeLeftText) {
            if (days > 0) {
                timeLeftText.textContent = days + ' days left';
            } else if (hours > 0) {
                timeLeftText.textContent = hours + ' hours left';
            } else if (minutes > 0) {
                timeLeftText.textContent = minutes + ' minutes left';
            } else {
                timeLeftText.textContent = 'Ending soon!';
            }
        }
    } else {
        // Challenge has ended
        const daysEl = document.getElementById('countdown-days');
        const hoursEl = document.getElementById('countdown-hours');
        const minutesEl = document.getElementById('countdown-minutes');
        const timeLeftText = document.getElementById('time-left-text');
        
        if (daysEl) daysEl.textContent = 0;
        if (hoursEl) hoursEl.textContent = 0;
        if (minutesEl) minutesEl.textContent = 0;
        if (timeLeftText) timeLeftText.textContent = 'Challenge ended';
    }
}

// Update countdown every minute
setInterval(updateCountdown, 60000);
updateCountdown(); // Initial call
@endif

// Smooth scroll to submissions
document.addEventListener('DOMContentLoaded', function() {
    const submissionsLink = document.querySelector('a[href="#submissions"]');
    if (submissionsLink) {
        submissionsLink.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector('#submissions');
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    }
    
    // Animate progress bar on scroll
    const progressBar = document.querySelector('.progress-fill');
    if (progressBar) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    progressBar.style.transition = 'width 2s ease-out';
                    setTimeout(() => {
                        progressBar.style.width = progressBar.style.width;
                    }, 100);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(progressBar);
    }
});
</script>
@endpush