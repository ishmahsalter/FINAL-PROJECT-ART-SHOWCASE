{{-- resources/views/home/partials/popular-artworks.blade.php --}}
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900"></div>
    
    <div class="absolute inset-0 opacity-40">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 via-orange-500/20 to-pink-500/20 animate-gradient-shift"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="font-['Playfair_Display'] text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                Most <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">Viral</span> This Week
            </h2>
            <p class="font-body text-xl md:text-2xl text-purple-200 max-w-3xl mx-auto">
                Trending artworks that captured everyone's attention
            </p>
        </div>

        @if($popularArtworks && $popularArtworks->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
            @foreach($popularArtworks as $artwork)
            <div class="group relative"
                 onclick="window.location.href='{{ route('artworks.show', $artwork) }}'"
                 style="animation-delay: {{ $loop->index * 0.1 }}s">
                
                <div class="relative rounded-2xl overflow-hidden border border-purple-500/30 hover:border-yellow-400/50 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    <!-- Image -->
                    <div class="aspect-square overflow-hidden bg-gradient-to-br from-purple-800 to-indigo-900">
                        @if($artwork->image_path)
                        <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}"
                             class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <!-- Rank Badge -->
                        <div class="absolute top-3 right-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center shadow-lg">
                                <span class="font-bold text-gray-900 text-sm">#{{ $loop->iteration }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content Overlay -->
                    <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/80 to-transparent transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <h4 class="font-['Playfair_Display'] text-white font-semibold text-sm mb-1 truncate">
                            {{ $artwork->title }}
                        </h4>
                        <p class="text-purple-300 text-xs truncate">{{ $artwork->user->name ?? 'Unknown' }}</p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="absolute top-3 left-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex items-center gap-2 bg-black/60 backdrop-blur-sm rounded-full px-3 py-1">
                            <svg class="w-3 h-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="text-white text-xs font-bold">{{ $artwork->likes_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl flex items-center justify-center border border-purple-500/30">
                <svg class="w-20 h-20 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <h3 class="font-['Playfair_Display'] text-2xl font-bold text-white mb-4">
                No Viral Artworks Yet
            </h3>
            <p class="text-purple-300 mb-8 max-w-md mx-auto">
                Be the first to create something amazing!
            </p>
        </div>
        @endif

        <!-- View All Link -->
        <div class="text-center mt-12">
            <a href="{{ route('artworks.index') }}?sort=popular"
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                <span>View All Trending</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>