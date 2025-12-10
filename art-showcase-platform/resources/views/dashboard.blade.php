{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold">Welcome to ArtShowcase! 🎨</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Redirecting you to your dashboard...
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        @if(auth()->user()->role === 'member')
                            <a href="{{ route('member.dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold rounded-lg transition-all">
                                Go to Member Dashboard
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-lg transition-all">
                                Go to Admin Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'curator')
                            <a href="{{ route('curator.dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all">
                                Go to Curator Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold rounded-lg transition-all">
                            Login to Continue
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@auth
<script>
    // Auto redirect based on role
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            @if(auth()->user()->role === 'member')
                window.location.href = "{{ route('member.dashboard') }}";
            @elseif(auth()->user()->role === 'admin')
                window.location.href = "{{ route('admin.dashboard') }}";
            @elseif(auth()->user()->role === 'curator')
                window.location.href = "{{ route('curator.dashboard') }}";
            @endif
        }, 2000);
    });
</script>
@endauth
@endsection