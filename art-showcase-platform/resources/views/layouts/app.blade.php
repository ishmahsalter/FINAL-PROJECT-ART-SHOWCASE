<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ArtShowcase') }} - @yield('title', 'Discover Amazing Artworks')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased bg-primary-50 dark:bg-dark-bg text-primary-800 dark:text-primary-100 transition-colors duration-300">
    
    <!-- Navbar -->
    <x-navbar />

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-dark-card border-t border-primary-200 dark:border-dark-border mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="font-display text-2xl font-bold text-accent-gold mb-3">
                        ArtShowcase
                    </h3>
                    <p class="text-primary-600 dark:text-primary-400 text-sm leading-relaxed">
                        A platform where creativity meets community. Discover, share, and celebrate amazing artworks from talented creators around the world.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-ui font-semibold text-primary-900 dark:text-white mb-4">Explore</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-primary-600 dark:text-primary-400 hover:text-accent-gold transition">Gallery</a></li>
                        <li><a href="{{ route('challenges.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-accent-gold transition">Challenges</a></li>
                        <li><a href="#" class="text-primary-600 dark:text-primary-400 hover:text-accent-gold transition">Categories</a></li>
                    </ul>
                </div>

                <!-- Community -->
                <div>
                    <h4 class="font-ui font-semibold text-primary-900 dark:text-white mb-4">Community</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-primary-600 dark:text-primary-400 hover:text-accent-gold transition">About Us</a></li>
                        <li><a href="#" class="text-primary-600 dark:text-primary-400 hover:text-accent-gold transition">Guidelines</a></li>
                        <li><a href="#" class="text-primary-600 dark:text-primary-400 hover:text-accent-gold transition">Support</a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-primary-200 dark:border-dark-border mt-8 pt-8 text-center">
                <p class="text-primary-500 dark:text-primary-500 text-sm">
                    &copy; {{ date('Y') }} ArtShowcase. Crafted with ♥ for creators.
                </p>
            </div>
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2"></div>

    @stack('scripts')
</body>
</html>