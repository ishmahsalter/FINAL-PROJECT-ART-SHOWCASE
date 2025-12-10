{{-- resources/views/home/partials/latest-artworks.blade.php --}}
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
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-emerald-500">Latest</span> Creations
            </h2>
            <p class="font-body text-xl md:text-2xl text-purple-200 max-w-3xl mx-auto">
                Fresh masterpieces from our talented community
            </p>
        </div>

        @if($latestArtworks && $latestArtworks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8" x-data="latestArtworks()">
            @foreach($latestArtworks as $artwork)
            <div class="group relative bg-gradient-to-br from-purple-900/50 to-indigo-900/50 rounded-3xl overflow-hidden border border-purple-500/30 hover:border-emerald-400/50 transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02] h-full cursor-pointer"
                 onclick="window.location.href='{{ route('artworks.show', $artwork) }}'"
                 style="animation-delay: {{ $loop->index * 0.1 }}s"
                 x-data="{ hover: false }" 
                 @mouseenter="hover = true" 
                 @mouseleave="hover = false">
                
                <!-- Image Container -->
                <div class="relative h-64 overflow-hidden bg-gradient-to-br from-emerald-900/30 to-purple-900/30">
                    @if($artwork->image_path)
                    <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}"
                         class="w-full h-full object-cover transform transition-transform duration-700"
                         :class="hover ? 'scale-110' : ''">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-5xl opacity-30">🎨</div>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    
                    <!-- NEW Badge -->
                    <div class="absolute top-4 left-4 z-20">
                        <div class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-xs font-bold rounded-full flex items-center gap-2 backdrop-blur-sm">
                            <span>🆕</span>
                            <span>NEW</span>
                        </div>
                    </div>

                    <!-- Time Indicator -->
                    <div class="absolute top-4 right-4 z-20">
                        <div class="px-3 py-1.5 bg-black/60 backdrop-blur-sm rounded-full text-emerald-300 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $artwork->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="font-['Playfair_Display'] text-xl font-bold text-white mb-3 line-clamp-1 hover:text-emerald-300 transition-colors">
                        {{ $artwork->title }}
                    </h3>
                    
                    <p class="text-purple-200 text-sm mb-4 line-clamp-2">
                        {{ Str::limit($artwork->description, 100) }}
                    </p>

                    <!-- Creator Info -->
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-green-500 overflow-hidden border-2 border-purple-500/50">
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
                            <div class="text-white text-sm font-medium">{{ $artwork->user->name ?? 'Unknown Creator' }}</div>
                            <div class="text-emerald-300 text-xs">Artist</div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
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

                    <!-- Like Button & Action -->
                    <div class="flex items-center gap-3">
                        @auth
                        <button onclick="likeArtwork({{ $artwork->id }})"
                                class="flex-1 px-4 py-2.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-300 hover:text-white border border-emerald-500/30 hover:border-emerald-400 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="font-semibold">Like</span>
                        </button>
                        @else
                        <a href="{{ route('login') }}"
                           class="flex-1 px-4 py-2.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-300 hover:text-white border border-emerald-500/30 hover:border-emerald-400 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="font-semibold">Like</span>
                        </a>
                        @endauth
                        
                        <a href="{{ route('artworks.show', $artwork) }}"
                           class="flex-1 text-center py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-green-600 hover:to-emerald-500 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            View
                        </a>
                    </div>
                </div>

                <!-- Glow Effect -->
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-400/0 via-green-500/0 to-emerald-400/0 group-hover:from-emerald-400/20 group-hover:via-green-500/20 group-hover:to-emerald-400/20 blur-xl rounded-3xl transition-all duration-700"></div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-emerald-900/30 to-purple-900/30 rounded-3xl flex items-center justify-center border border-emerald-500/30">
                <svg class="w-20 h-20 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-['Playfair_Display'] text-2xl font-bold text-white mb-4">
                Nothing New Yet
            </h3>
            <p class="text-purple-300 mb-8 max-w-md mx-auto">
                Be the first to upload your creation and inspire others!
            </p>
            
            <!-- Upload CTA -->
            @auth
            <a href="{{ route('member.artworks.create') }}" 
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-500 to-green-600 text-white font-bold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                UPLOAD FIRST ARTWORK
            </a>
            @else
            <a href="{{ route('register') }}" 
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-500 to-green-600 text-white font-bold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                JOIN TO CREATE
            </a>
            @endauth
        </div>
        @endif

        <!-- View All Link -->
        <div class="text-center mt-12">
            <a href="{{ route('artworks.index') }}?sort=latest"
               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-600 to-green-700 text-white font-bold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                <span>View All Latest Artworks</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
function latestArtworks() {
    return {
        init() {
            // Add staggered animation delays
            this.$nextTick(() => {
                const cards = this.$el.querySelectorAll('.group');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                });
            });
        }
    };
}

// Like artwork function
function likeArtwork(artworkId) {
    fetch(`/artworks/${artworkId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update like count
            const likeElement = document.querySelector(`[data-artwork="${artworkId}"] .like-count`);
            if (likeElement) {
                likeElement.textContent = data.likes;
            }
            
            // Show success message
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Something went wrong!', 'error');
    });
}

// Show notification function
function showNotification(message, type = 'info') {
    // Implement your notification system here
    console.log(`${type.toUpperCase()}: ${message}`);
}
</script>
@endpush