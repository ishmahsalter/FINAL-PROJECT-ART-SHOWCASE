{{-- resources/views/home/partials/search-filter.blade.php --}}
<section class="relative py-20 md:py-28 overflow-hidden">
    <!-- Background Effects SAMA PERSIS dengan featured artworks -->
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900"></div>
    
    <div class="absolute inset-0 opacity-40">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 via-orange-500/20 to-pink-500/20 animate-gradient-shift"></div>
    </div>

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-gradient-to-br from-yellow-400/10 to-orange-500/10 rounded-full filter blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-1/4 -right-32 w-96 h-96 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full filter blur-3xl animate-float-medium"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Container utama - SAMA dengan featured artworks -->
        <div class="bg-gradient-to-br from-purple-900/80 to-indigo-900/80 backdrop-blur-2xl rounded-3xl p-8 border border-purple-500/40 shadow-2xl">

            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                    <h3 class="text-white text-2xl md:text-3xl font-bold flex items-center gap-3">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        DISCOVER AMAZING CONTENT
                    </h3>

                    <div class="flex flex-wrap justify-center md:justify-end gap-3">
                        @foreach(['artworks' => 'Artworks', 'creators' => 'Creators', 'challenges' => 'Challenges'] as $key => $label)
                        <a href="{{ route('search') }}?type={{ $key }}"
                           class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300
                                  {{ request('type', 'artworks') == $key 
                                     ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 shadow-lg' 
                                     : 'bg-purple-800/50 text-purple-200 hover:bg-purple-700/60 hover:text-white' }}">
                            @switch($key)
                                @case('artworks') 🎨 @break
                                @case('creators') 👤 @break
                                @case('challenges') 🏆 @break
                            @endswitch
                            {{ $label }}
                            @php
                                $count = match($key) {
                                    'artworks' => \App\Models\Artwork::count(),
                                    'creators' => \App\Models\User::where('role', 'member')->count(),
                                    'challenges' => \App\Models\Challenge::count(),
                                    default => 0
                                };
                            @endphp
                            @if($count > 0)
                            <span class="ml-2 px-2 py-1 text-xs rounded-full bg-black/20">
                                {{ $count }}
                            </span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- SEARCH BAR -->
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <div class="relative flex items-center">
                        <div class="absolute left-6 pointer-events-none">
                            <svg class="w-7 h-7 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Search network, creators, challenges, tags..."
                               class="w-full pl-16 pr-48 py-5 bg-purple-800/40 border-2 border-purple-500/50 rounded-2xl text-white placeholder-purple-300 
                                      focus:outline-none focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/20 text-lg transition-all duration-300">

                        @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif

                        <button type="submit" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 px-8 py-3.5 bg-gradient-to-r from-yellow-400 to-orange-500 
                                       text-gray-900 font-bold rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-lg">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- QUICK STATS - SAMA dengan stat boxes di featured artworks -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 border-t border-purple-500/30">
                <!-- BOX 1 -->
                <div class="bg-purple-800/30 rounded-xl border border-purple-500/30 p-6 text-center hover:border-yellow-400/50 transition-all duration-300 hover:scale-105">
                    <div class="font-['Playfair_Display'] text-3xl md:text-4xl font-bold text-yellow-400 mb-2">
                        16+
                    </div>
                    <div class="text-yellow-300 text-sm font-semibold uppercase tracking-widest">
                        CHECKOUT US
                    </div>
                </div>
                
                <!-- BOX 2 -->
                <div class="bg-purple-800/30 rounded-xl border border-purple-500/30 p-6 text-center hover:border-orange-400/50 transition-all duration-300 hover:scale-105">
                    <div class="font-['Playfair_Display'] text-3xl md:text-4xl font-bold text-orange-400 mb-2">
                        @php
                            $activeCount = \App\Models\Challenge::active()->count();
                            echo $activeCount . '+';
                        @endphp
                    </div>
                    <div class="text-orange-300 text-sm font-semibold uppercase tracking-widest">
                        ACTIVE
                    </div>
                </div>
                
                <!-- BOX 3 -->
                <div class="bg-purple-800/30 rounded-xl border border-purple-500/30 p-6 text-center hover:border-pink-400/50 transition-all duration-300 hover:scale-105">
                    <div class="font-['Playfair_Display'] text-3xl md:text-4xl font-bold text-pink-400 mb-2">
                        150+
                    </div>
                    <div class="text-pink-300 text-sm font-semibold uppercase tracking-widest">
                        FIFTH
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>