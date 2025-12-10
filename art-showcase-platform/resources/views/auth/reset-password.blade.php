@extends('layouts.app')

@section('title', 'Set New Password - ArtShowcase')

@section('content')
<!-- Reset Password Hero Section -->
<section class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-yellow-400/20 rounded-full filter blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-green-400/20 rounded-full filter blur-3xl animate-float-medium"></div>
    </div>

    <!-- Reset Password Container -->
    <div class="relative z-10 w-full max-w-md mx-4">
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-8 text-center border-b border-white/10">
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>
                <h1 class="font-display text-3xl font-bold text-white mb-2">Set New Password</h1>
                <p class="text-white/70 font-body">Create your new password below</p>
            </div>

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.update') }}" class="p-8">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-30 blur transition-opacity duration-300"></div>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $request->email) }}" 
                            required 
                            autocomplete="email"
                            class="relative w-full px-4 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        New Password
                    </label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-30 blur transition-opacity duration-300"></div>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            class="relative w-full px-4 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                            placeholder="Enter new password"
                        >
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-8">
                    <label for="password_confirmation" class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        Confirm Password
                    </label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-30 blur transition-opacity duration-300"></div>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            class="relative w-full px-4 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                            placeholder="Confirm new password"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full py-4 px-6 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 hover:from-pink-500 hover:via-orange-500 hover:to-yellow-400 text-white font-ui font-bold rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-1 relative overflow-hidden group"
                >
                    <span class="relative z-10 flex items-center justify-center">
                        Reset Password
                        <svg class="w-5 h-5 ml-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection