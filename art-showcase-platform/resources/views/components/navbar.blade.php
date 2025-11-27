<nav class="sticky top-0 z-40 bg-white/80 dark:bg-dark-bg/80 backdrop-blur-md border-b border-primary-200 dark:border-dark-border transition-colors" x-data="{ mobileMenu: false, searchOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-accent-gold to-accent-gold-dark rounded-lg flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-display text-xl font-bold text-primary-900 dark:text-white hidden sm:block">
                        ArtShowcase
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Gallery
                </a>
                <a href="{{ route('challenges.index') }}" class="nav-link {{ request()->routeIs('challenges.*') ? 'active' : '' }}">
                    Challenges
                </a>
                
                @auth
                    @if(auth()->user()->role === 'member')
                        <a href="{{ route('member.dashboard') }}" class="nav-link">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'curator')
                        <a href="{{ route('curator.dashboard') }}" class="nav-link">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            Admin
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                
                <!-- Search Toggle -->
                <button @click="searchOpen = !searchOpen" class="icon-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="icon-btn">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                @guest
                    <!-- Guest Actions -->
                    <a href="{{ route('login') }}" class="text-primary-700 dark:text-primary-300 hover:text-accent-gold transition font-ui font-medium hidden sm:block">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary">
                        Sign Up
                    </a>
                @else
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none group">
                            <img src="{{ auth()->user()->profile_image ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-9 h-9 rounded-full border-2 border-transparent group-hover:border-accent-gold transition">
                            <svg class="w-4 h-4 text-primary-600 dark:text-primary-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card rounded-lg shadow-gallery-hover border border-primary-200 dark:border-dark-border overflow-hidden">
                            
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-primary-200 dark:border-dark-border">
                                <p class="font-ui font-medium text-primary-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-primary-500">{{ auth()->user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-1">
                                @if(auth()->user()->role === 'member')
                                    <a href="{{ route('member.dashboard') }}" class="dropdown-item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('profile.show', auth()->user()->name) }}" class="dropdown-item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        My Profile
                                    </a>
                                @elseif(auth()->user()->role === 'curator')
                                    <a href="{{ route('curator.dashboard') }}" class="dropdown-item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                        Curator Dashboard
                                    </a>
                                @elseif(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        Admin Panel
                                    </a>
                                @endif
                            </div>

                            <!-- Logout -->
                            <div class="border-t border-primary-200 dark:border-dark-border">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-red-600 dark:text-red-400 w-full text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden icon-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Search Bar (Expandable) -->
        <div x-show="searchOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="pb-4">
            <div class="relative">
                <input type="text" 
                       placeholder="Search artworks, creators, challenges..." 
                       class="w-full pl-10 pr-4 py-2 rounded-lg border border-primary-300 dark:border-dark-border bg-white dark:bg-dark-card focus:ring-2 focus:ring-accent-gold focus:border-transparent">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="md:hidden border-t border-primary-200 dark:border-dark-border bg-white dark:bg-dark-card">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('home') }}" class="mobile-nav-link">Gallery</a>
            <a href="{{ route('challenges.index') }}" class="mobile-nav-link">Challenges</a>
            
            @guest
                <a href="{{ route('login') }}" class="mobile-nav-link">Log In</a>
                <a href="{{ route('register') }}" class="mobile-nav-link">Sign Up</a>
            @endguest
        </div>
    </div>
</nav>

<style>
.nav-link {
    @apply font-ui font-medium text-primary-700 dark:text-primary-300 hover:text-accent-gold transition-colors relative;
}

.nav-link.active::after {
    content: '';
    @apply absolute -bottom-1 left-0 right-0 h-0.5 bg-accent-gold;
}

.icon-btn {
    @apply p-2 text-primary-600 dark:text-primary-400 hover:text-accent-gold hover:bg-primary-100 dark:hover:bg-dark-card rounded-lg transition;
}

.btn-primary {
    @apply px-4 py-2 bg-accent-gold hover:bg-accent-gold-dark text-white font-ui font-medium rounded-lg shadow-md hover:shadow-lg transition-all;
}

.dropdown-item {
    @apply flex items-center space-x-2 px-4 py-2 text-sm text-primary-700 dark:text-primary-300 hover:bg-primary-50 dark:hover:bg-dark-bg transition;
}

.mobile-nav-link {
    @apply block px-4 py-2 text-primary-700 dark:text-primary-300 hover:bg-primary-50 dark:hover:bg-dark-bg rounded-lg transition;
}
</style>