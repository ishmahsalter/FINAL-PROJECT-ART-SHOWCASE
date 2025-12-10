<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-white/95 dark:bg-dark-card/95 backdrop-blur-sm border-b border-primary-200 dark:border-dark-border shadow-lg transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo - Enhanced & POSITION FIXED -->
                <div class="shrink-0 flex items-center mr-8"> <!-- Added mr-8 for more left spacing -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-accent-gold to-accent-sage rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <span class="font-display font-bold text-white text-lg">A</span>
                        </div>
                        <span class="font-display text-2xl font-bold text-primary-900 dark:text-white ml-2">RIOTÉ Showcase</span> <!-- Added ml-2 -->
                    </a>
                </div>

                <!-- Navigation Links - Enhanced -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-6 sm:flex"> <!-- Changed sm:ms-10 to sm:ms-6 -->
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="font-ui font-semibold">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.index')" class="font-ui font-semibold">
                        {{ __('Gallery') }}
                    </x-nav-link>
                    <x-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.index')" class="font-ui font-semibold">
                        {{ __('Challenges') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown - Enhanced -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- ... REST OF YOUR CODE REMAINS EXACTLY THE SAME ... -->
                @auth
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="p-2 mr-4 text-primary-600 dark:text-primary-400 hover:text-accent-gold transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-accent-gold/10 to-accent-sage/10 hover:from-accent-gold/20 hover:to-accent-sage/20 border border-accent-gold/20 text-sm leading-4 font-medium rounded-xl text-primary-700 dark:text-primary-300 hover:text-primary-900 dark:hover:text-white focus:outline-none transition-all duration-300 ease-in-out transform hover:-translate-y-0.5">
                                <div class="font-ui font-semibold">{{ Auth::user()->name }}</div>

                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="font-ui">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            
                            @if(Auth::user()->role === 'member')
                                <x-dropdown-link :href="route('member.dashboard')" class="font-ui">
                                    {{ __('My Dashboard') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="font-ui text-red-600 dark:text-red-400 hover:text-red-700">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                                class="p-2 text-primary-600 dark:text-primary-400 hover:text-accent-gold transition-colors">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="font-ui font-semibold">
                            {{ __('Login') }}
                        </x-nav-link>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-accent-gold to-accent-gold-dark hover:from-accent-gold-dark hover:to-accent-gold text-white font-ui font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            {{ __('Sign Up') }}
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger - Enhanced -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-xl text-primary-600 dark:text-primary-400 hover:text-accent-gold hover:bg-primary-100 dark:hover:bg-dark-bg focus:outline-none focus:bg-primary-100 dark:focus:bg-dark-bg transition-all duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu - Enhanced -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 dark:bg-dark-card/95 backdrop-blur-sm border-t border-primary-200 dark:border-dark-border">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="font-ui font-semibold">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.index')" class="font-ui font-semibold">
                {{ __('Gallery') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.index')" class="font-ui font-semibold">
                {{ __('Challenges') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-primary-200 dark:border-dark-border px-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <div class="font-ui font-semibold text-base text-primary-800 dark:text-primary-200">{{ Auth::user()->name }}</div>
                        <div class="font-ui text-sm text-primary-500">{{ Auth::user()->email }}</div>
                    </div>
                    <!-- Dark Mode Toggle Mobile -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="p-2 text-primary-600 dark:text-primary-400">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>
                </div>

                <div class="mt-3 space-y-2">
                    <x-responsive-nav-link :href="route('profile.edit')" class="font-ui">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    
                    @if(Auth::user()->role === 'member')
                        <x-responsive-nav-link :href="route('member.dashboard')" class="font-ui">
                            {{ __('My Dashboard') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="font-ui text-red-600 dark:text-red-400">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-primary-200 dark:border-dark-border px-4">
                <div class="space-y-3">
                    <x-responsive-nav-link :href="route('login')" class="font-ui font-semibold">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" class="font-ui font-semibold bg-gradient-to-r from-accent-gold to-accent-gold-dark text-white text-center">
                        {{ __('Sign Up') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>