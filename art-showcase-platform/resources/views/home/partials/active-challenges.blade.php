{{-- resources/views/home/partials/active-challenges.blade.php --}}
@if($challenges && $challenges->count() > 0)
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900"></div>
    
    <div class="absolute inset-0 opacity-40">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 via-orange-500/20 to-pink-500/20 animate-gradient-shift"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="font-['Playfair_Display'] text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">Active</span> Challenges
            </h2>
            <p class="font-body text-xl md:text-2xl text-purple-200 max-w-3xl mx-auto">
                Join exciting competitions and win amazing prizes
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($challenges->take(3) as $challenge)
            <div class="group relative bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl overflow-hidden border border-purple-500/30 hover:border-yellow-400/50 transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02] h-full cursor-pointer"
                 onclick="window.location.href='{{ route('challenges.show', $challenge) }}'">
                
                <!-- Challenge Banner -->
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-purple-800 to-indigo-900">
                    @if($challenge->banner_image)
                    <img src="{{ Storage::url($challenge->banner_image) }}" alt="{{ $challenge->title }}"
                         class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-5xl opacity-30">🏆</div>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    
                    <!-- Active Badge -->
                    <div class="absolute top-4 right-4 z-20">
                        <div class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-bold rounded-full flex items-center gap-2 backdrop-blur-sm">
                            <span>🔥</span>
                            <span>ACTIVE</span>
                        </div>
                    </div>

                    <!-- Countdown -->
                    <div class="absolute bottom-4 left-4 right-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm">
                                <svg class="w-4 h-4 text-green-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Ends {{ $challenge->end_date->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="font-['Playfair_Display'] text-xl font-bold text-white mb-3 line-clamp-1 hover:text-yellow-300 transition-colors">
                        {{ $challenge->title }}
                    </h3>
                    
                    <p class="text-purple-200 text-sm mb-4 line-clamp-2">
                        {{ Str::limit($challenge->description, 100) }}
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-3 mb-6 text-sm">
                        <div class="text-center p-2 bg-purple-800/30 rounded-lg border border-purple-500/30">
                            <div class="text-purple-300 text-xs">Entries</div>
                            <div class="text-white font-bold">{{ $challenge->submissions_count ?? 0 }}</div>
                        </div>
                        <div class="text-center p-2 bg-purple-800/30 rounded-lg border border-purple-500/30">
                            <div class="text-purple-300 text-xs">Prize</div>
                            <div class="text-yellow-300 font-bold">${{ number_format($challenge->prize_pool) }}</div>
                        </div>
                        <div class="text-center p-2 bg-purple-800/30 rounded-lg border border-purple-500/30">
                            <div class="text-purple-300 text-xs">Days Left</div>
                            <div class="text-white font-bold">{{ $challenge->end_date->diffInDays(now()) }}</div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-4">
                        <a href="{{ route('challenges.show', $challenge) }}"
                           class="block w-full text-center py-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            JOIN CHALLENGE
                        </a>
                    </div>
                </div>

                <!-- Glow Effect -->
                <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400/0 via-orange-500/0 to-pink-500/0 group-hover:from-yellow-400/20 group-hover:via-orange-500/20 group-hover:to-pink-500/20 blur-xl rounded-3xl transition-all duration-700"></div>
            </div>
            @endforeach
        </div>

        <!-- View All Link -->
        <div class="text-center mt-12">
            <a href="{{ route('challenges.active') }}"
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-bold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                <span>View All Challenges</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif