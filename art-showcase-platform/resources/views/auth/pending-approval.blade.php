@extends('layouts.app')

@section('title', 'Awaiting Approval - ArtShowcase')

@section('content')
<!-- Pending Approval Hero Section -->
<section class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-yellow-400/20 rounded-full filter blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-green-400/20 rounded-full filter blur-3xl animate-float-medium"></div>
        <div class="absolute top-1/2 right-1/3 w-64 h-64 bg-blue-400/20 rounded-full filter blur-3xl animate-float-fast"></div>
    </div>

    <!-- Floating Particles -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-2 h-2 bg-white/30 rounded-full animate-pulse"></div>
        <div class="absolute top-40 right-32 w-1 h-1 bg-yellow-400/40 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-32 left-40 w-1 h-1 bg-pink-400/40 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-1 h-1 bg-orange-400/40 rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <!-- Pending Approval Container -->
    <div class="relative z-10 w-full max-w-md mx-4">
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-8 text-center border-b border-white/10">
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h1 class="font-display text-3xl font-bold text-white mb-2">Awaiting Approval</h1>
                <p class="text-white/70 font-body">Your curator account is being reviewed</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Status Message -->
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-400/20 rounded-xl mb-4">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-white/80 font-body text-lg mb-4">
                        {{ $message ?? 'Your curator account is pending admin approval.' }}
                    </p>
                    <p class="text-white/60 font-body text-sm">
                        You will be notified via email once your account has been reviewed and activated.
                    </p>
                    
                    <!-- Session Messages -->
                    @if (session('info'))
                        <div class="mt-4 p-3 bg-blue-500/20 border border-blue-400/30 rounded-lg">
                            <p class="text-blue-300 text-sm">{{ session('info') }}</p>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="mt-4 p-3 bg-red-500/20 border border-red-400/30 rounded-lg">
                            <p class="text-red-300 text-sm">{{ session('error') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Info Box -->
                <div class="mb-8 p-6 bg-gradient-to-r from-yellow-500/10 via-orange-500/10 to-pink-500/10 border border-yellow-400/30 rounded-2xl backdrop-blur-sm">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-ui font-semibold text-white mb-1">What happens next?</h3>
                            <ul class="text-white/60 text-sm space-y-2">
                                <li class="flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                                    <span>Our admin team will review your application</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                                    <span>Approval process typically takes 1-2 business days</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                                    <span>You'll receive an email notification once approved</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mb-8 text-center">
                    <p class="text-white/50 font-body text-sm mb-2">
                        Need assistance?
                    </p>
                    <p class="text-white/70 font-body">
                        Please contact administrator if you have any questions.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    @if(auth()->check())
                        <!-- Back to Login Button (logout) untuk user yang sudah login -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button 
                                type="submit"
                                class="w-full py-4 px-6 bg-white/10 hover:bg-white/20 text-white font-ui font-bold rounded-xl border border-white/20 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-0.5 relative overflow-hidden group"
                            >
                                <span class="relative z-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Back to Login
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 via-orange-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </button>
                        </form>
                    @else
                        <!-- Login Button untuk user yang belum login -->
                        <a 
                            href="{{ route('login') }}"
                            class="w-full py-4 px-6 bg-gradient-to-r from-yellow-400/20 via-orange-500/20 to-pink-500/20 hover:from-yellow-400/30 hover:via-orange-500/30 hover:to-pink-500/30 text-white font-ui font-bold rounded-xl border border-white/10 hover:border-white/30 transition-all duration-300 transform hover:-translate-y-0.5 relative overflow-hidden group text-center block"
                        >
                            <span class="relative z-10 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Go to Login
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 via-orange-500/10 to-pink-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                    @endif

                    <!-- Home Button -->
                    <a 
                        href="{{ route('home') }}"
                        class="block w-full py-4 px-6 bg-gradient-to-r from-yellow-400/20 via-orange-500/20 to-pink-500/20 hover:from-yellow-400/30 hover:via-orange-500/30 hover:to-pink-500/30 text-white font-ui font-bold rounded-xl border border-white/10 hover:border-white/30 transition-all duration-300 transform hover:-translate-y-0.5 relative overflow-hidden group"
                    >
                        <span class="relative z-10 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Browse Gallery
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 via-orange-500/10 to-pink-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>

                <!-- Footer Note -->
                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <p class="text-white/40 font-body text-xs">
                        Thank you for your patience. We're excited to have you join our creative community!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Home -->
    <div class="absolute bottom-8 left-8">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 text-white/70 hover:text-white transition-colors duration-300 group">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-ui font-semibold">Back to Gallery</span>
        </a>
    </div>
</section>

<style>
/* Reuse animations from main layout */
@keyframes float-slow {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(120deg); }
    66% { transform: translate(-20px, 20px) rotate(240deg); }
}

@keyframes float-medium {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(-30px, 30px) rotate(120deg); }
    66% { transform: translate(20px, -20px) rotate(240deg); }
}

@keyframes float-fast {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(20px, -20px) scale(1.1); }
}

.animate-float-slow { animation: float-slow 20s ease-in-out infinite; }
.animate-float-medium { animation: float-medium 15s ease-in-out infinite; }
.animate-float-fast { animation: float-fast 10s ease-in-out infinite; }

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: rgba(251, 191, 36, 0.5);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(251, 191, 36, 0.8);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add subtle animation to status icon
    const statusIcon = document.querySelector('.bg-yellow-400\\/20 svg');
    if (statusIcon) {
        let rotation = 0;
        setInterval(() => {
            rotation += 0.5;
            statusIcon.style.transform = `rotate(${rotation}deg)`;
        }, 50);
    }

    // Add pulsing effect to info box
    const infoBox = document.querySelector('.bg-gradient-to-r');
    if (infoBox) {
        setInterval(() => {
            infoBox.style.boxShadow = '0 0 20px rgba(251, 191, 36, 0.1)';
            setTimeout(() => {
                infoBox.style.boxShadow = 'none';
            }, 500);
        }, 3000);
    }

    // Display session messages for 5 seconds then fade out
    const messages = document.querySelectorAll('.bg-blue-500\\/20, .bg-red-500\\/20');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transition = 'opacity 1s';
            setTimeout(() => {
                message.style.display = 'none';
            }, 1000);
        }, 5000);
    });
});
</script>
@endsection