{{-- resources/views/home/partials/featured-artworks.blade.php --}}
<section class="relative py-20 md:py-28 overflow-hidden">
    <!-- Background Effects SAMA PERSIS -->
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900"></div>
    
    <div class="absolute inset-0 opacity-40">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 via-orange-500/20 to-pink-500/20 animate-gradient-shift"></div>
    </div>

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-gradient-to-br from-yellow-400/10 to-orange-500/10 rounded-full filter blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-1/4 -right-32 w-96 h-96 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full filter blur-3xl animate-float-medium"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header dengan Playfair Display -->
        <div class="text-center mb-16">
            <h2 class="font-['Playfair_Display'] text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">Featured</span> Masterpieces
            </h2>
            <p class="font-body text-xl md:text-2xl text-purple-200 max-w-3xl mx-auto">
                Curated collection of exceptional artworks from talented creators
            </p>
        </div>

        @if($featuredArtworks && $featuredArtworks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach($featuredArtworks as $artwork)
            <div class="group relative bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl overflow-hidden border border-purple-500/30 hover:border-yellow-400/50 transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02] h-full cursor-pointer"
                 onclick="window.location.href='{{ route('artworks.show', $artwork) }}'">
                
                <!-- Image dengan efek sama -->
                <div class="relative h-64 overflow-hidden bg-gradient-to-br from-purple-800 to-indigo-900">
                    @if($artwork->image_path)
                    <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}"
                         class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-5xl opacity-30">🎨</div>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    
                    <!-- Featured Badge -->
                    <div class="absolute top-4 left-4 z-20">
                        <div class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 text-xs font-bold rounded-full flex items-center gap-2 backdrop-blur-sm">
                            <span>⭐</span>
                            <span>FEATURED</span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="font-['Playfair_Display'] text-xl font-bold text-white mb-3 line-clamp-1 hover:text-yellow-300 transition-colors">
                        {{ $artwork->title }}
                    </h3>
                    
                    <p class="text-purple-200 text-sm mb-4 line-clamp-2">
                        {{ Str::limit($artwork->description, 100) }}
                    </p>

                    <!-- Creator Info -->
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-pink-500 overflow-hidden border-2 border-purple-500/50">
                            @if($artwork->user && $artwork->user->avatar)
                            <img src="{{ Storage::url($artwork->user->avatar) }}" 
                                 alt="{{ $artwork->user->name }}"
                                 class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-white font-bold">
                                {{ substr($artwork->user->name ?? '?', 0, 1) }}
                            </div>
                            @endif
                        </div>
                        <div>
                            <div class="text-white text-sm font-medium">{{ $artwork->user->name ?? 'Unknown' }}</div>
                            <div class="text-purple-300 text-xs">Creator</div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-3 mb-6 text-sm">
                        <div class="text-center p-2 bg-purple-800/30 rounded-lg border border-purple-500/30">
                            <div class="text-purple-300 text-xs">Likes</div>
                            <div class="text-white font-bold">{{ $artwork->likes_count ?? 0 }}</div>
                        </div>
                        <div class="text-center p-2 bg-purple-800/30 rounded-lg border border-purple-500/30">
                            <div class="text-purple-300 text-xs">Comments</div>
                            <div class="text-white font-bold">{{ $artwork->comments_count ?? 0 }}</div>
                        </div>
                        <div class="text-center p-2 bg-purple-800/30 rounded-lg border border-purple-500/30">
                            <div class="text-purple-300 text-xs">Views</div>
                            <div class="text-white font-bold">{{ $artwork->views ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-4">
                        <a href="{{ route('artworks.show', $artwork) }}"
                           class="block w-full text-center py-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            VIEW ARTWORK
                        </a>
                    </div>
                </div>

                <!-- Glow Effect -->
                <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400/0 via-orange-500/0 to-pink-500/0 group-hover:from-yellow-400/20 group-hover:via-orange-500/20 group-hover:to-pink-500/20 blur-xl rounded-3xl transition-all duration-700"></div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl flex items-center justify-center border border-purple-500/30">
                <svg class="w-20 h-20 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-['Playfair_Display'] text-2xl font-bold text-white mb-4">
                No Featured Artworks
            </h3>
            <p class="text-purple-300 mb-8 max-w-md mx-auto">
                Check back later for curated masterpieces
            </p>
        </div>
        @endif

        <!-- View All Link -->
        <div class="text-center mt-12">
            <a href="{{ route('explore.trending') }}"
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                <span>View All Featured</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>