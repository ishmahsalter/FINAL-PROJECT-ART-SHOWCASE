@props(['artwork'])

<div class="group relative bg-white dark:bg-dark-card rounded-lg overflow-hidden shadow-gallery hover:shadow-gallery-hover transition-all duration-300 transform hover:-translate-y-1">
    
    <!-- Artwork Image -->
    <div class="relative aspect-[3/4] overflow-hidden bg-primary-100 dark:bg-dark-bg">
        <img src="{{ Storage::url($artwork->image_path) }}" 
             alt="{{ $artwork->title }}" 
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
             loading="lazy">
        
        <!-- Frame Effect on Hover -->
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
             style="box-shadow: inset 0 0 0 8px rgba(212, 175, 55, 0.3), inset 0 0 0 12px rgba(212, 175, 55, 0.1);">
        </div>

        <!-- Quick Actions (Only for authenticated members) -->
        @auth
            @if(auth()->user()->role === 'member')
                <div class="absolute top-3 right-3 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    
                    <!-- Like Button -->
                    <button onclick="toggleLike({{ $artwork->id }})" 
                            data-artwork-id="{{ $artwork->id }}"
                            class="like-btn p-2 bg-white/90 dark:bg-dark-card/90 backdrop-blur-sm rounded-full shadow-md hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 {{ $artwork->isLikedBy(auth()->user()) ? 'text-red-500 fill-current' : 'text-primary-600' }}" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>

                    <!-- Favorite Button -->
                    <button onclick="toggleFavorite({{ $artwork->id }})" 
                            data-artwork-id="{{ $artwork->id }}"
                            class="favorite-btn p-2 bg-white/90 dark:bg-dark-card/90 backdrop-blur-sm rounded-full shadow-md hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 {{ $artwork->isFavoritedBy(auth()->user()) ? 'text-accent-gold fill-current' : 'text-primary-600' }}" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </button>
                </div>
            @endif
        @endauth

        <!-- View Count Badge -->
        <div class="absolute bottom-3 left-3 flex items-center space-x-1 px-2 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-xs">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <span>{{ $artwork->view_count }}</span>
        </div>
    </div>

    <!-- Artwork Info -->
    <a href="{{ route('artworks.show', $artwork->id) }}" class="block p-4 space-y-2">
        
        <!-- Title -->
        <h3 class="font-display text-lg font-semibold text-primary-900 dark:text-white line-clamp-1 group-hover:text-accent-gold transition-colors">
            {{ $artwork->title }}
        </h3>

        <!-- Creator Info -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <img src="{{ $artwork->user->profile_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($artwork->user->name) }}" 
                     alt="{{ $artwork->user->display_name ?? $artwork->user->name }}" 
                     class="w-6 h-6 rounded-full border border-primary-200 dark:border-dark-border">
                <span class="text-sm text-primary-600 dark:text-primary-400 font-medium">
                    {{ $artwork->user->display_name ?? $artwork->user->name }}
                </span>
            </div>

            <!-- Like Count -->
            <div class="flex items-center space-x-1 text-primary-500 dark:text-primary-500 text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                </svg>
                <span class="like-count">{{ $artwork->likes_count ?? 0 }}</span>
            </div>
        </div>

        <!-- Category Badge -->
        @if($artwork->category)
            <div class="inline-flex items-center px-2 py-1 bg-accent-sage/10 text-accent-sage-dark dark:text-accent-sage-light rounded text-xs font-medium">
                {{ $artwork->category->name }}
            </div>
        @endif
    </a>
</div>

<script>
// Like functionality
function toggleLike(artworkId) {
    fetch(`/member/artworks/${artworkId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        const btn = document.querySelector(`[data-artwork-id="${artworkId}"].like-btn svg`);
        const countEl = document.querySelector(`[data-artwork-id="${artworkId}"]`).closest('.group').querySelector('.like-count');
        
        if (data.liked) {
            btn.classList.add('text-red-500', 'fill-current');
            btn.classList.remove('text-primary-600');
        } else {
            btn.classList.remove('text-red-500', 'fill-current');
            btn.classList.add('text-primary-600');
        }
        
        if (countEl) {
            countEl.textContent = data.likes_count;
        }
        
        showToast(data.message, 'success');
    })
    .catch(err => {
        console.error(err);
        showToast('Failed to update like', 'error');
    });
}

// Favorite functionality
function toggleFavorite(artworkId) {
    fetch(`/member/favorites/${artworkId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        const btn = document.querySelector(`[data-artwork-id="${artworkId}"].favorite-btn svg`);
        
        if (data.favorited) {
            btn.classList.add('text-accent-gold', 'fill-current');
            btn.classList.remove('text-primary-600');
        } else {
            btn.classList.remove('text-accent-gold', 'fill-current');
            btn.classList.add('text-primary-600');
        }
        
        showToast(data.message, 'success');
    })
    .catch(err => {
        console.error(err);
        showToast('Failed to update favorite', 'error');
    });
}

// Toast notification helper
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `px-4 py-3 rounded-lg shadow-lg animate-slide-up ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-primary-700'
    } text-white`;
    toast.textContent = message;
    
    document.getElementById('toast-container').appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>