<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'RIOTÉ Showcase') - An art showcase where rebellion steals the spotlight.</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom Font Classes */
        .font-display { font-family: 'Playfair Display', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
        .font-ui { font-family: 'Inter', sans-serif; }
        
        /* Smooth Scrolling */
        html { scroll-behavior: smooth; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 12px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { 
            background: linear-gradient(to bottom, #fbbf24, #f97316); 
            border-radius: 6px; 
        }
        ::-webkit-scrollbar-thumb:hover { 
            background: linear-gradient(to bottom, #f59e0b, #ea580c); 
        }
        
        /* Loading Animation */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .animate-shimmer {
            animation: shimmer 2s infinite;
            background: linear-gradient(to right, #f3f4f6 4%, #e5e7eb 25%, #f3f4f6 36%);
            background-size: 1000px 100%;
        }
        
        /* Gradient Animations */
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .animate-gradient-x {
            animation: gradient-x 3s ease infinite;
            background-size: 200% auto;
        }
        
        /* Alpine Cloak */
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased transition-colors duration-300">
    <!-- Global Loading Overlay - PROPERLY HIDDEN -->
    <div x-data="{ loading: false }" 
         x-show="loading"
         x-cloak
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-2xl">
            <div class="flex flex-col items-center space-y-4">
                <div class="w-16 h-16 border-4 border-yellow-400 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-slate-700 dark:text-slate-300 font-semibold">Loading...</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
         x-data="{ 
             scrolled: false, 
             mobileMenuOpen: false,
             userMenuOpen: false
         }"
         @scroll.window="scrolled = window.pageYOffset > 50"
         :class="scrolled ? 'bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-lg' : 'bg-transparent'">
        
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="absolute -inset-1 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-xl blur opacity-30 group-hover:opacity-60 transition-opacity -z-10"></div>
                    </div>
                    <span class="font-display text-2xl font-bold transition-colors duration-300"
                          :class="scrolled ? 'text-slate-900 dark:text-white' : 'text-white'">
                        RIOTÉ ArtShowcase
                    </span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="font-ui font-semibold transition-all duration-300 hover:scale-110"
                       :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400' : 'text-white hover:text-yellow-400'">
                        Gallery
                    </a>
                    <a href="{{ route('challenges.index') }}" 
                       class="font-ui font-semibold transition-all duration-300 hover:scale-110"
                       :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400' : 'text-white hover:text-yellow-400'">
                        Challenges
                    </a>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="font-ui font-semibold transition-all duration-300 hover:scale-110"
                               :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400' : 'text-white hover:text-yellow-400'">
                                Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'curator')
                            <a href="{{ route('curator.dashboard') }}" 
                               class="font-ui font-semibold transition-all duration-300 hover:scale-110"
                               :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400' : 'text-white hover:text-yellow-400'">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('member.dashboard') }}" 
                               class="font-ui font-semibold transition-all duration-300 hover:scale-110"
                               :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400' : 'text-white hover:text-yellow-400'">
                                My Works
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" 
                            class="p-3 rounded-xl transition-all duration-300 hover:scale-110"
                            :class="scrolled ? 'bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700' : 'bg-white/10 backdrop-blur-md hover:bg-white/20'">
                        <svg x-show="!darkMode" class="w-5 h-5" :class="scrolled ? 'text-slate-700' : 'text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    @guest
                        <a href="{{ route('login') }}" 
                           class="hidden md:block font-ui font-semibold px-6 py-3 rounded-xl transition-all duration-300 hover:scale-105"
                           :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' : 'text-white hover:bg-white/10 backdrop-blur-md'">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="hidden md:block font-ui font-bold px-6 py-3 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                            Get Started
                        </a>
                    @else
                        <!-- User Menu -->
                        <div class="relative" @click.away="userMenuOpen = false">
                            <button @click="userMenuOpen = !userMenuOpen"
                                    class="flex items-center space-x-3 px-4 py-2 rounded-xl transition-all duration-300 hover:scale-105"
                                    :class="scrolled ? 'bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700' : 'bg-white/10 backdrop-blur-md hover:bg-white/20'">
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:block font-ui font-semibold"
                                      :class="scrolled ? 'text-slate-900 dark:text-white' : 'text-white'">
                                    {{ auth()->user()->display_name ?? auth()->user()->name }}
                                </span>
                                <svg class="w-4 h-4 transition-transform duration-300" 
                                     :class="[userMenuOpen ? 'rotate-180' : '', scrolled ? 'text-slate-700 dark:text-slate-300' : 'text-white']" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userMenuOpen"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                                <div class="p-4 border-b border-slate-200 dark:border-slate-700 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-slate-700 dark:to-slate-600">
                                    <div class="font-ui font-bold text-slate-900 dark:text-white">
                                        {{ auth()->user()->display_name ?? auth()->user()->name }}
                                    </div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">
                                        {{ auth()->user()->email }}
                                    </div>
                                </div>
                                <div class="py-2">
                                    @auth
                                        <a href="{{ 
                                            auth()->user()->isMember() ? route('member.profile.edit') : 
                                            (auth()->user()->isAdmin() ? route('admin.dashboard') : 
                                            (auth()->user()->isCurator() ? route('curator.dashboard') : '#')) 
                                        }}" 
                                           class="flex items-center space-x-3 px-4 py-3 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class="font-ui font-semibold">
                                                @if(auth()->user()->isMember())
                                                    Profile
                                                @elseif(auth()->user()->isAdmin())
                                                    Admin Dashboard
                                                @elseif(auth()->user()->isCurator())
                                                    Curator Dashboard
                                                @else
                                                    Dashboard
                                                @endif
                                            </span>
                                        </a>
                                    @endauth
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full flex items-center space-x-3 px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span class="font-ui font-semibold">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="md:hidden p-3 rounded-xl transition-all duration-300"
                            :class="scrolled ? 'bg-slate-100 dark:bg-slate-800' : 'bg-white/10 backdrop-blur-md'">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" :class="scrolled ? 'text-slate-900 dark:text-white' : 'text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6" :class="scrolled ? 'text-slate-900 dark:text-white' : 'text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="md:hidden py-4 border-t border-slate-200 dark:border-slate-700">
                <div class="space-y-2">
                    <a href="{{ route('home') }}" 
                       class="block px-4 py-3 rounded-xl font-ui font-semibold transition-colors"
                       :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' : 'text-white hover:bg-white/10'">
                        Gallery
                    </a>
                    <a href="{{ route('challenges.index') }}" 
                       class="block px-4 py-3 rounded-xl font-ui font-semibold transition-colors"
                       :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' : 'text-white hover:bg-white/10'">
                        Challenges
                    </a>
                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'curator' ? route('curator.dashboard') : route('member.dashboard')) }}" 
                           class="block px-4 py-3 rounded-xl font-ui font-semibold transition-colors"
                           :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' : 'text-white hover:bg-white/10'">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block px-4 py-3 rounded-xl font-ui font-semibold transition-colors"
                           :class="scrolled ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' : 'text-white hover:bg-white/10'">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block px-4 py-3 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white text-center rounded-xl font-ui font-bold">
                            Get Started
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-400 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-500 rounded-full filter blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="font-display text-2xl font-bold">RIOTÉ ArtShowcase</span>
                    </div>
                    <p class="text-slate-400 leading-relaxed mb-6 max-w-md">
                        Where extraordinary talent meets global recognition. Join our community of creators and showcase your art to the world.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.654-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-display text-lg font-bold mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition-colors flex items-center space-x-2">
                                <span class="w-1 h-1 bg-yellow-400 rounded-full"></span>
                                <span>Gallery</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('challenges.index') }}" class="text-slate-400 hover:text-white transition-colors flex items-center space-x-2">
                                <span class="w-1 h-1 bg-yellow-400 rounded-full"></span>
                                <span>Challenges</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-slate-400 hover:text-white transition-colors flex items-center space-x-2">
                                <span class="w-1 h-1 bg-yellow-400 rounded-full"></span>
                                <span>About Us</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="text-slate-400 hover:text-white transition-colors flex items-center space-x-2">
                                <span class="w-1 h-1 bg-yellow-400 rounded-full"></span>
                                <span>Contact</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="font-display text-lg font-bold mb-6">Support</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-slate-400 hover:text-white transition-colors flex items-center space-x-2">
                                <span class="w-1 h-1 bg-orange-400 rounded-full"></span>
                                <span>Help Center</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-slate-400 hover:text-white transition-colors flex items-center space-x-2">
                                <span class="w-1 h-1 bg-orange-400 rounded-full"></span>
                                <span>Terms of Service</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-slate-400 hover:text-white transition-colors flex items-center space-x-2">
                                <span class="w-1 h-1 bg-orange-400 rounded-full"></span>
                                <span>Privacy Policy</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-slate-400 hover:text-white transition-colors flex items-center space-x-2">
                                <span class="w-1 h-1 bg-orange-400 rounded-full"></span>
                                <span>Community Guidelines</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-slate-400 text-sm">
                    © 2025 RIOTÉ ArtShowcase. All rights reserved. Made with <span class="text-red-500">❤</span> by creators, for creators.
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="#" class="text-slate-400 hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors">Terms</a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications -->
    <div x-data="{ 
            notifications: [],
            addNotification(message, type = 'info') {
                const id = Date.now();
                this.notifications.push({ id, message, type });
                setTimeout(() => {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }, 5000);
            }
         }"
         @notify.window="addNotification($event.detail.message, $event.detail.type || 'info')"
         class="fixed bottom-4 right-4 z-50 space-y-3">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-full"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="px-6 py-4 rounded-xl shadow-2xl backdrop-blur-xl flex items-center space-x-3 max-w-md"
                 :class="{
                     'bg-green-500/90 text-white': notification.type === 'success',
                     'bg-red-500/90 text-white': notification.type === 'error',
                     'bg-yellow-500/90 text-white': notification.type === 'warning',
                     'bg-blue-500/90 text-white': notification.type === 'info'
                 }">
                <svg x-show="notification.type === 'success'" class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <svg x-show="notification.type === 'error'" class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <svg x-show="notification.type === 'warning'" class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <svg x-show="notification.type === 'info'" class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-ui font-semibold flex-1" x-text="notification.message"></span>
            </div>
        </template>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <script>
            window.addEventListener('load', function() {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: "{{ session('success') }}", type: 'success' }
                }));
            });
        </script>
    @endif
    
    @if(session('error'))
        <script>
            window.addEventListener('load', function() {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: "{{ session('error') }}", type: 'error' }
                }));
            });
        </script>
    @endif
    
    @if(session('warning'))
        <script>
            window.addEventListener('load', function() {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: "{{ session('warning') }}", type: 'warning' }
                }));
            });
        </script>
    @endif
    
    @if(session('info'))
        <script>
            window.addEventListener('load', function() {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: "{{ session('info') }}", type: 'info' }
                }));
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>