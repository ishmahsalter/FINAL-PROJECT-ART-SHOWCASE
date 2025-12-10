@extends('layouts.app')

@section('title', $challenge->title . ' - Challenge Details | ArtShowcase')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                        {{ $challenge->title }}
                    </h1>
                    <div class="flex items-center gap-4 text-slate-600 dark:text-slate-400">
                        <a href="{{ route('curator.challenges.index') }}" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Challenges
                        </a>
                        <span>•</span>
                        <span>Status: 
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $challenge->end_date < now() ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' }}">
                                {{ $challenge->end_date < now() ? 'Ended' : 'Active' }}
                            </span>
                        </span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('curator.challenges.edit', $challenge->id) }}" 
                       class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    
                    @if($challenge->end_date < now())
                    <a href="{{ route('curator.challenges.select-winners', $challenge->id) }}" 
                       class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-gray-900 font-bold rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        Select Winners
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Submissions Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Total Submissions</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $challenge->submissions->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('curator.challenges.submissions', $challenge->id) }}" 
                       class="text-sm text-purple-600 dark:text-purple-400 hover:underline">
                        View all submissions →
                    </a>
                </div>
            </div>

            <!-- Winners Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Winners Selected</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $challenge->winners->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    @if($challenge->winners->count() > 0)
                        <a href="{{ route('curator.challenges.select-winners', $challenge->id) }}" 
                           class="text-sm text-green-600 dark:text-green-400 hover:underline">
                            View winners →
                        </a>
                    @else
                        <span class="text-sm text-slate-500 dark:text-slate-400">No winners yet</span>
                    @endif
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Timeline</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ $challenge->start_date->format('M d') }} - {{ $challenge->end_date->format('M d') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        @if($challenge->end_date < now())
                            Ended {{ $challenge->end_date->diffForHumans() }}
                        @else
                            Ends in {{ $challenge->end_date->diffForHumans() }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Prize Card -->
            @if($challenge->prize)
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Prize</p>
                        <p class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $challenge->prize }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Description & Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Left Column: Challenge Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Description</h3>
                    <div class="prose prose-slate dark:prose-invert max-w-none">
                        <p class="text-slate-700 dark:text-slate-300">{{ $challenge->description }}</p>
                    </div>
                </div>

                <!-- Rules -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Rules & Guidelines</h3>
                    <div class="prose prose-slate dark:prose-invert max-w-none">
                        <p class="text-slate-700 dark:text-slate-300 whitespace-pre-line">{{ $challenge->rules }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Quick Actions -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('curator.challenges.submissions', $challenge->id) }}" 
                           class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-lg transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-slate-900 dark:text-white">View Submissions</div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400">{{ $challenge->submissions->count() }} total</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        @if($challenge->end_date < now())
                        <a href="{{ route('curator.challenges.select-winners', $challenge->id) }}" 
                           class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-lg transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-slate-900 dark:text-white">Select Winners</div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $challenge->winners->count() > 0 ? 'Edit winners' : 'Choose winners' }}
                                    </div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endif

                        <a href="{{ route('curator.challenges.edit', $challenge->id) }}" 
                           class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-lg transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-slate-900 dark:text-white">Edit Challenge</div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400">Update details</div>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Challenge Info -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Challenge Info</h3>
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Theme</div>
                            <div class="font-medium text-slate-900 dark:text-white">{{ $challenge->theme ?? 'Not specified' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Created</div>
                            <div class="font-medium text-slate-900 dark:text-white">{{ $challenge->created_at->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Status</div>
                            <div class="font-medium">
                                @if($challenge->end_date < now())
                                    <span class="text-red-600 dark:text-red-400">Ended</span>
                                @elseif($challenge->start_date > now())
                                    <span class="text-yellow-600 dark:text-yellow-400">Upcoming</span>
                                @else
                                    <span class="text-green-600 dark:text-green-400">Active</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        @if($challenge->submissions->count() > 0)
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Recent Submissions</h3>
                <a href="{{ route('curator.challenges.submissions', $challenge->id) }}" class="text-sm text-purple-600 dark:text-purple-400 hover:underline">
                    View all →
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($challenge->submissions->take(6) as $submission)
                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-3">
                        @if($submission->user->avatar)
                        <img src="{{ Storage::url($submission->user->avatar) }}" 
                             alt="{{ $submission->user->name }}"
                             class="w-10 h-10 rounded-full object-cover">
                        @else
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($submission->user->name, 0, 2) }}
                        </div>
                        @endif
                        <div>
                            <div class="font-medium text-slate-900 dark:text-white">{{ $submission->user->name }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $submission->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    @if($submission->artwork)
                    <div class="mb-2 rounded overflow-hidden">
                        <img src="{{ Storage::url($submission->artwork->image_path) }}" 
                             alt="{{ $submission->artwork->title }}"
                             class="w-full h-32 object-cover">
                    </div>
                    <div class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $submission->artwork->title }}</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">{{ $submission->status }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection