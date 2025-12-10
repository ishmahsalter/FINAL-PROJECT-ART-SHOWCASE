@extends('layouts.app')

@section('title', 'Reset Password - ArtShowcase')

@section('content')
<!-- Forgot Password Hero Section -->
<section class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-yellow-400/20 rounded-full filter blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-green-400/20 rounded-full filter blur-3xl animate-float-medium"></div>
    </div>

    <!-- Forgot Password Container -->
    <div class="relative z-10 w-full max-w-md mx-4">
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-8 text-center border-b border-white/10">
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
                <h1 class="font-display text-3xl font-bold text-white mb-2">Reset Password</h1>
                <p class="text-white/70 font-body">Enter your email to receive a reset link</p>
            </div>

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="p-8">
                @csrf

                <!-- Email Input -->
                <div class="mb-8">
                    <label for="email" class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-30 blur transition-opacity duration-300"></div>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                            class="relative w-full px-4 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                            placeholder="Enter your email"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full py-4 px-6 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 hover:from-pink-500 hover:via-orange-500 hover:to-yellow-400 text-white font-ui font-bold rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-1 relative overflow-hidden group"
                >
                    <span class="relative z-10 flex items-center justify-center">
                        Send Reset Link
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                </button>

                <!-- Back to Login -->
                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-ui font-semibold transition-colors duration-300 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection