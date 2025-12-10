{{-- resources/views/home/member.blade.php --}}
@extends('layouts.app')

@section('title', 'Your Creative Dashboard | ArtShowcase')

@section('content')
<!-- 🎨 MEMBER DASHBOARD HERO -->
<section class="relative py-16 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900 overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 via-purple-500/10 to-pink-500/10 animate-gradient-shift"></div>
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 30% 20%, rgba(251, 191, 36, 0.1) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(244, 114, 182, 0.1) 0%, transparent 50%);"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- Welcome Section with Stats -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-12">
            <div class="mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500">{{ Auth::user()->name }}! 👋</span>
                </h1>
                <p class="text-lg text-slate-300">Ready to create something amazing today?</p>
            </div>
            
            <!-- Quick Stats -->
            <div class="flex items-center space-x-6">
                <div class="text-center group cursor-pointer transform hover:scale-110 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-1">{{ Auth::user()->artworks->count() }}</div>
                    <div class="text-sm text-slate-300">Artworks</div>
                </div>
                <div class="h-8 w-px bg-slate-600"></div>
                <div class="text-center group cursor-pointer transform hover:scale-110 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-1">{{ Auth::user()->followers->count() }}</div>
                    <div class="text-sm text-slate-300">Followers</div>
                </div>
                <div class="h-8 w-px bg-slate-600"></div>
                <div class="text-center group cursor-pointer transform hover:scale-110 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-1">{{ Auth::user()->following->count() }}</div>
                    <div class="text-sm text-slate-300">Following</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <a href="{{ route('member.artworks.create') }}" 
               class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:bg-white/20 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div class="text-white font-semibold mb-2">Upload Artwork</div>
                <div class="text-sm text-slate-300">Share your creativity</div>
            </a>

            <a href="{{ route('member.favorites.index') }}" 
               class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:bg-white/20 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="text-white font-semibold mb-2">My Favorites</div>
                <div class="text-sm text-slate-300">View saved artworks</div>
            </a>

            <a href="{{ route('member.collections.index') }}" 
               class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:bg-white/20 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="text-white font-semibold mb-2">Collections</div>
                <div class="text-sm text-slate-300">Organize your moodboards</div>
            </a>

            <a href="{{ route('member.challenges.index') }}" 
               class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:bg-white/20 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-white font-semibold mb-2">Challenges</div>
                <div class="text-sm text-slate-300">Join competitions</div>
            </a>
        </div>
    </div>
</section>

<!-- 📊 DASHBOARD GRID -->
<div class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Uploads -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Your Recent Artworks</h2>
                    <a href="{{ route('member.artworks.index') }}" class="text-sm font-semibold text-yellow-500 hover:text-yellow-600 flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse(Auth::user()->artworks()->latest()->take(4)->get() as $artwork)
                    <div class="group relative bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-800 rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ Storage::url($artwork->image_path) }}" 
                                 alt="{{ $artwork->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-slate-900 dark:text-white mb-1 line-clamp-1">{{ $artwork->title }}</h3>
                            <div class="flex items-center justify-between text-sm text-slate-600 dark:text-slate-400">
                                <span>{{ $artwork->created_at->diffForHumans() }}</span>
                                <div class="flex items-center space-x-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        {{ $artwork->likes_count }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        {{ $artwork->comments_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('member.artworks.show', $artwork->id) }}" 
                           class="absolute inset-0"></a>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-12">
                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-yellow-100 to-pink-100 dark:from-slate-700 dark:to-slate-800 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">No artworks yet</h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-4">Start by uploading your first masterpiece!</p>
                        <a href="{{ route('member.artworks.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-pink-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            Upload Artwork
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Following Feed -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">From Artists You Follow</h2>
                    <a href="{{ route('member.following.feed') }}" class="text-sm font-semibold text-yellow-500 hover:text-yellow-600 flex items-center">
                        See More
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <div class="space-y-6">
                    @php
                        $followingIds = Auth::user()->following->pluck('id');
                        $followingArtworks = \App\Models\Artwork::whereIn('user_id', $followingIds)
                            ->with(['user', 'likes', 'comments'])
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp
                    
                    @forelse($followingArtworks as $artwork)
                    <div class="group bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-800 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-start space-x-4">
                            <a href="{{ route('profile.show', $artwork->user->id) }}" class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    {{ substr($artwork->user->name, 0, 1) }}
                                </div>
                            </a>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <a href="{{ route('profile.show', $artwork->user->id) }}" 
                                           class="font-semibold text-slate-900 dark:text-white hover:text-yellow-500 transition-colors">
                                            {{ $artwork->user->name }}
                                        </a>
                                        <span class="text-sm text-slate-600 dark:text-slate-400 ml-2">
                                            {{ $artwork->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <button class="text-slate-400 hover:text-yellow-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <a href="{{ route('artworks.show', $artwork->id) }}" class="block group">
                                    <div class="mb-4 rounded-xl overflow-hidden">
                                        <img src="{{ Storage::url($artwork->image_path) }}" 
                                             alt="{{ $artwork->title }}"
                                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-700">
                                    </div>
                                    <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2">{{ $artwork->title }}</h3>
                                    <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-2 mb-4">{{ $artwork->description }}</p>
                                </a>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <button class="flex items-center space-x-1 text-slate-600 dark:text-slate-400 hover:text-yellow-500 transition-colors"
                                                onclick="likeArtwork({{ $artwork->id }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span class="text-sm">{{ $artwork->likes_count }}</span>
                                        </button>
                                        <a href="{{ route('artworks.show', $artwork->id) }}#comments" 
                                           class="flex items-center space-x-1 text-slate-600 dark:text-slate-400 hover:text-yellow-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            <span class="text-sm">{{ $artwork->comments_count }}</span>
                                        </a>
                                        <button class="flex items-center space-x-1 text-slate-600 dark:text-slate-400 hover:text-yellow-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="flex items-center space-x-1 text-slate-600 dark:text-slate-400 hover:text-yellow-500 transition-colors"
                                            onclick="favoriteArtwork({{ $artwork->id }})">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-yellow-100 to-pink-100 dark:from-slate-700 dark:to-slate-800 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">No following activity</h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-4">Follow some artists to see their latest creations here!</p>
                        <a href="{{ route('explore.creators') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-pink-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            Explore Artists
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Profile Summary -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 shadow-xl">
                <div class="text-center mb-6">
                    <div class="relative inline-block mb-4">
                        <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-3xl shadow-2xl mx-auto">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="absolute -inset-2 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full blur-xl opacity-30"></div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">{{ Auth::user()->name }}</h3>
                    <p class="text-slate-300 text-sm mb-4">{{ Auth::user()->bio ?? 'Digital Artist' }}</p>
                    
                    <div class="flex items-center justify-center space-x-6 mb-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ Auth::user()->artworks->count() }}</div>
                            <div class="text-sm text-slate-400">Artworks</div>
                        </div>
                        <div class="h-8 w-px bg-slate-700"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ Auth::user()->followers->count() }}</div>
                            <div class="text-sm text-slate-400">Followers</div>
                        </div>
                        <div class="h-8 w-px bg-slate-700"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ Auth::user()->following->count() }}</div>
                            <div class="text-sm text-slate-400">Following</div>
                        </div>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" 
                       class="block w-full py-3 bg-gradient-to-r from-yellow-400 to-pink-500 hover:from-pink-500 hover:to-yellow-400 text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg text-center">
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Quick Collections -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Your Collections</h2>
                    <a href="{{ route('member.collections.index') }}" class="text-sm font-semibold text-yellow-500 hover:text-yellow-600">
                        View All
                    </a>
                </div>
                
                <div class="space-y-4">
                    @php
                        $collections = Auth::user()->collections()->withCount('artworks')->latest()->take(3)->get();
                    @endphp
                    
                    @forelse($collections as $collection)
                    <div class="group bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-800 rounded-2xl p-4 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold">
                                {{ substr($collection->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-slate-900 dark:text-white line-clamp-1">{{ $collection->name }}</h3>
                                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $collection->artworks_count }} artworks</p>
                            </div>
                            <a href="{{ route('member.collections.show', $collection->id) }}" 
                               class="text-slate-400 hover:text-yellow-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p class="text-sm text-slate-600 dark:text-slate-400">No collections yet</p>
                        <a href="{{ route('member.collections.create') }}" 
                           class="text-sm font-semibold text-yellow-500 hover:text-yellow-600 inline-flex items-center mt-2">
                            Create Collection
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Suggested Follows -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Suggested Artists</h2>
                
                <div class="space-y-4">
                    @php
                        $suggestedArtists = \App\Models\User::where('role', 'member')
                            ->where('id', '!=', Auth::id())
                            ->whereNotIn('id', Auth::user()->following->pluck('id'))
                            ->withCount('artworks')
                            ->inRandomOrder()
                            ->take(3)
                            ->get();
                    @endphp
                    
                    @foreach($suggestedArtists as $artist)
                    <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-300">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($artist->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900 dark:text-white">{{ $artist->name }}</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">{{ $artist->artworks_count }} artworks</div>
                            </div>
                        </div>
                        <button class="follow-btn px-4 py-1 text-sm font-semibold rounded-full transition-all duration-300"
                                data-user-id="{{ $artist->id }}"
                                onclick="toggleFollow({{ $artist->id }}, this)">
                            Follow
                        </button>
                    </div>
                    @endforeach
                    
                    <a href="{{ route('explore.creators') }}" 
                       class="block text-center py-3 text-sm font-semibold text-yellow-500 hover:text-yellow-600 transition-colors">
                        View More Suggestions →
                    </a>
                </div>
            </div>

            <!-- Active Challenges -->
            @if($activeChallenges = \App\Models\Challenge::active()->latest()->take(2)->get())
            <div class="bg-gradient-to-br from-yellow-50 to-pink-50 dark:from-slate-800 dark:to-slate-900 rounded-3xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Active Challenges</h2>
                    <a href="{{ route('challenges.index') }}" class="text-sm font-semibold text-yellow-500 hover:text-yellow-600">
                        View All
                    </a>
                </div>
                
                <div class="space-y-4">
                    @foreach($activeChallenges as $challenge)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-slate-900 dark:text-white line-clamp-1">{{ $challenge->title }}</h3>
                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-bold rounded-full">
                                Active
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-3 line-clamp-2">{{ $challenge->description }}</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">{{ $challenge->end_date->diffForHumans() }}</span>
                            <a href="{{ route('challenges.show', $challenge->id) }}" 
                               class="font-semibold text-yellow-500 hover:text-yellow-600">
                                Join →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- 📈 ANALYTICS SECTION (Jika ada data) -->
@if(Auth::user()->artworks->count() > 0)
<section class="py-16 bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-slate-900 dark:text-white mb-12">Your Performance Analytics</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-green-100 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/30 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ Auth::user()->artworks->sum('views_count') }}
                </div>
                <div class="text-slate-600 dark:text-slate-400">Total Views</div>
            </div>
            
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-800/30 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ Auth::user()->artworks->sum('likes_count') }}
                </div>
                <div class="text-slate-600 dark:text-slate-400">Total Likes</div>
            </div>
            
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-800/30 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ Auth::user()->followers_count }}
                </div>
                <div class="text-slate-600 dark:text-slate-400">Followers</div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
/* Custom Animations */
@keyframes gradient-shift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-gradient-shift {
    background-size: 200% 200%;
    animation: gradient-shift 15s ease infinite;
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

/* Follow Button States */
.follow-btn {
    background: linear-gradient(135deg, #fbbf24 0%, #f97316 100%);
    color: white;
}

.follow-btn.following {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}
</style>
@endpush

@push('scripts')
<script>
// Like Artwork Function
async function likeArtwork(artworkId) {
    try {
        const response = await fetch(`/member/artworks/${artworkId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            // Update UI here
            console.log('Liked:', data);
        }
    } catch (error) {
        console.error('Error liking artwork:', error);
    }
}

// Favorite Artwork Function
async function favoriteArtwork(artworkId) {
    try {
        const response = await fetch(`/member/artworks/${artworkId}/favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            // Update UI here
            console.log('Favorited:', data);
        }
    } catch (error) {
        console.error('Error favoriting artwork:', error);
    }
}

// Follow/Unfollow User
async function toggleFollow(userId, button) {
    try {
        const response = await fetch(`/member/follow/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            if (data.following) {
                button.textContent = 'Following';
                button.classList.add('following');
            } else {
                button.textContent = 'Follow';
                button.classList.remove('following');
            }
        }
    } catch (error) {
        console.error('Error toggling follow:', error);
    }
}

// Initialize tooltips and other UI enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to cards
    const cards = document.querySelectorAll('.group');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });
    
    // Load more functionality
    let isLoading = false;
    window.addEventListener('scroll', async () => {
        if (isLoading) return;
        
        const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
        if (scrollTop + clientHeight >= scrollHeight - 100) {
            isLoading = true;
            // Implement infinite scroll here
            isLoading = false;
        }
    });
});
</script>
@endpush