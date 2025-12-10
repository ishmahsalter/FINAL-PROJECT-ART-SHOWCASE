@extends('layouts.app')

@section('title', 'Curator Dashboard - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                Curator Dashboard
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                Welcome back, {{ auth()->user()->display_name ?? auth()->user()->name }}! Manage your challenges and submissions from here.
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Challenges Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-ui font-semibold text-slate-600 dark:text-slate-400 mb-1">
                            Total Challenges
                        </p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400" data-stat="total-challenges">
                            {{ $totalChallenges }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Challenges Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-ui font-semibold text-slate-600 dark:text-slate-400 mb-1">
                            Active Challenges
                        </p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400" data-stat="active-challenges">
                            {{ $activeChallengesCount }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                    {{ $upcomingChallengesCount }} upcoming • {{ $endedChallengesCount }} ended
                </div>
            </div>

            <!-- Total Submissions Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-ui font-semibold text-slate-600 dark:text-slate-400 mb-1">
                            Total Submissions
                        </p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400" data-stat="total-submissions">
                            {{ $totalSubmissions }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Review Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-ui font-semibold text-slate-600 dark:text-slate-400 mb-1">
                            Pending Review
                        </p>
                        <p class="text-2xl font-bold text-orange-600 dark:text-orange-400" data-stat="pending-reviews">
                            {{ $pendingSubmissions }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Pending Submissions -->
        @if($pendingSubmissions > 0)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-ui font-semibold text-slate-900 dark:text-white">
                        Recent Submissions Needing Review
                    </h2>
                    <span class="text-sm text-slate-600 dark:text-slate-400">
                        {{ $pendingSubmissions }} total pending
                    </span>
                </div>
            </div>
            
            <div class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($recentPendingSubmissions as $submission)
                <div class="px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($submission->user->avatar)
                                <img src="{{ Storage::url($submission->user->avatar) }}" 
                                     alt="{{ $submission->user->name }}"
                                     class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr($submission->user->name, 0, 2) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">
                                    {{ $submission->user->name }}
                                </p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">
                                    Submitted to "{{ $submission->challenge->title }}"
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $submission->created_at->diffForHumans() }}
                            </span>
                            <a href="{{ route('curator.challenges.submissions', $submission->challenge_id) }}" 
                            class="px-3 py-1 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/50 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-lg transition-colors">
                                Review
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                    <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>No submissions pending review. Great job!</p>
                </div>
                @endforelse
            </div>
            
            @if($pendingSubmissions > count($recentPendingSubmissions))
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 text-center">
                <a href="{{ route('curator.challenges.index') }}?status=pending" 
                class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                    View all {{ $pendingSubmissions }} pending submissions →
                </a>
            </div>
            @endif
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Create Challenge Card -->
            <a href="{{ route('curator.challenges.create') }}" 
               class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-ui font-semibold text-white mb-2">Create New Challenge</h3>
                <p class="text-purple-100 text-sm">Launch a new creative challenge for the community</p>
            </a>

            <!-- View Submissions Card -->
            <a href="{{ route('curator.challenges.index') }}" 
               class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-ui font-semibold text-white mb-2">View All Challenges</h3>
                <p class="text-blue-100 text-sm">See all your challenges and manage submissions</p>
            </a>

            <!-- Select Winners Card -->
            @if($endedChallengesWithoutWinners > 0)
            <a href="{{ route('curator.challenges.index') }}?status=ended" 
               class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-ui font-semibold text-white mb-2">Select Winners</h3>
                <p class="text-yellow-100 text-sm">{{ $endedChallengesWithoutWinners }} challenges need winners</p>
            </a>
            @else
            <div class="bg-gradient-to-br from-slate-500 to-slate-600 rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-ui font-semibold text-white mb-2">Select Winners</h3>
                <p class="text-slate-200 text-sm">No challenges need winners at the moment</p>
            </div>
            @endif
        </div>

        <!-- Recent Challenges Table -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-ui font-semibold text-slate-900 dark:text-white">
                        Recent Challenges
                    </h2>
                    <a href="{{ route('curator.challenges.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        View all
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-ui font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Challenge
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-ui font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-ui font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Submissions
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-ui font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Timeline
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-ui font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($recentChallenges as $challenge)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($challenge->banner_image)
                                            <img src="{{ Storage::url($challenge->banner_image) }}" 
                                                 alt="{{ $challenge->title }}"
                                                 class="w-10 h-10 rounded-lg object-cover mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-lg mr-3">
                                                {{ substr($challenge->title, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-ui font-medium text-slate-900 dark:text-white truncate max-w-xs">
                                                {{ $challenge->title }}
                                            </div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ \Carbon\Carbon::parse($challenge->created_at)->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($challenge->end_date < now())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 01118 0z" />
                                            </svg>
                                            Ended
                                        </span>
                                    @elseif($challenge->start_date > now())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 01118 0z" />
                                            </svg>
                                            Upcoming
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                            Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900 dark:text-white font-medium">
                                        {{ $challenge->submissions_count ?? $challenge->submissions()->count() }} submissions
                                    </div>
                                    @if($challenge->pending_submissions_count > 0)
                                    <div class="text-xs text-orange-600 dark:text-orange-400">
                                        {{ $challenge->pending_submissions_count }} pending
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($challenge->start_date)->format('M d') }} - 
                                        {{ \Carbon\Carbon::parse($challenge->end_date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        @if($challenge->end_date < now())
                                            Ended {{ \Carbon\Carbon::parse($challenge->end_date)->diffForHumans() }}
                                        @else
                                            Ends in {{ \Carbon\Carbon::parse($challenge->end_date)->diffForHumans() }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <!-- Lihat Submissions -->
                                        <a href="{{ route('curator.challenges.submissions', $challenge->id) }}" 
                                           class="p-2 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors"
                                           title="View Submissions">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </a>
                                        <!-- Edit Challenge -->
                                        <a href="{{ route('curator.challenges.edit', $challenge->id) }}" 
                                           class="p-2 text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors"
                                           title="Edit Challenge">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <!-- Select Winners (jika challenge sudah ended) -->
                                        @if($challenge->end_date < now() && $challenge->winners_count == 0)
                                        <a href="{{ route('curator.challenges.select-winners', $challenge->id) }}" 
                                           class="p-2 text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors"
                                           title="Select Winners">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        <p class="mb-3">You haven't created any challenges yet.</p>
                                        <a href="{{ route('curator.challenges.create') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-lg hover:shadow-lg transition-shadow">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Create Your First Challenge
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-lg p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-ui font-semibold text-white mb-2">Curator Tips</h3>
                    <div class="text-slate-300 space-y-2">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Create clear and inspiring challenge descriptions
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Engage with participants through comments and feedback
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Announce winners promptly after challenge ends
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh stats setiap 30 detik
    function refreshStats() {
        fetch('{{ route("curator.dashboard.stats") }}')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                // Update stat cards
                document.querySelector('[data-stat="total-challenges"]').textContent = data.total_challenges || 0;
                document.querySelector('[data-stat="active-challenges"]').textContent = data.active_challenges || 0;
                document.querySelector('[data-stat="total-submissions"]').textContent = data.total_submissions || 0;
                document.querySelector('[data-stat="pending-reviews"]').textContent = data.pending_reviews || 0;
            })
            .catch(error => console.error('Error refreshing stats:', error));
    }
    
    // Refresh stats setiap 30 detik jika user masih di halaman
    let statsInterval;
    
    function startStatsRefresh() {
        statsInterval = setInterval(refreshStats, 30000);
    }
    
    function stopStatsRefresh() {
        if (statsInterval) {
            clearInterval(statsInterval);
        }
    }
    
    // Refresh saat tab menjadi aktif
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            refreshStats();
            startStatsRefresh();
        } else {
            stopStatsRefresh();
        }
    });
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        startStatsRefresh();
    });
</script>
@endpush