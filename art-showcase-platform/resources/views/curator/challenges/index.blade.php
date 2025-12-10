@extends('layouts.app')

@section('title', 'My Challenges - Curator Dashboard - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                        My Challenges
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        Create and manage your creative challenges
                    </p>
                </div>
                <a href="{{ route('curator.challenges.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-lg hover:shadow-lg transition-shadow">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Challenge
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="mb-6">
            <div class="flex space-x-1 bg-slate-100 dark:bg-slate-800 rounded-lg p-1">
                <a href="{{ route('curator.challenges.index') }}" 
                   class="flex-1 px-3 py-2 text-center text-sm font-medium rounded-md transition-colors 
                          {{ !request('filter') ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    All Challenges
                </a>
                <a href="{{ route('curator.challenges.index', ['filter' => 'active']) }}" 
                   class="flex-1 px-3 py-2 text-center text-sm font-medium rounded-md transition-colors 
                          {{ request('filter') == 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 shadow' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    Active
                </a>
                <a href="{{ route('curator.challenges.index', ['filter' => 'upcoming']) }}" 
                   class="flex-1 px-3 py-2 text-center text-sm font-medium rounded-md transition-colors 
                          {{ request('filter') == 'upcoming' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 shadow' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    Upcoming
                </a>
                <a href="{{ route('curator.challenges.index', ['filter' => 'ended']) }}" 
                   class="flex-1 px-3 py-2 text-center text-sm font-medium rounded-md transition-colors 
                          {{ request('filter') == 'ended' ? 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-300 shadow' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    Ended
                </a>
                <a href="{{ route('curator.challenges.index', ['filter' => 'without-winners']) }}" 
                   class="flex-1 px-3 py-2 text-center text-sm font-medium rounded-md transition-colors 
                          {{ request('filter') == 'without-winners' ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 shadow' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    Needs Winners
                </a>
            </div>
        </div>

        <!-- Challenges Grid -->
        @if($challenges->count() > 0)
            <!-- Stats Bar -->
            <div class="mb-4 flex items-center justify-between text-sm text-slate-600 dark:text-slate-400">
                <span>Showing {{ $challenges->firstItem() }} - {{ $challenges->lastItem() }} of {{ $challenges->total() }} challenges</span>
                @if(request('filter') == 'without-winners')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300">
                        {{ $endedChallengesWithoutWinners ?? 0 }} challenges need winners
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($challenges as $challenge)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- Banner Image -->
                        @if($challenge->banner_image)
                            <div class="h-40 overflow-hidden">
                                <img src="{{ Storage::url($challenge->banner_image) }}" 
                                     alt="{{ $challenge->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-40 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-ui font-semibold text-slate-900 dark:text-white truncate">
                                    {{ $challenge->title }}
                                </h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $challenge->end_date > now() && $challenge->start_date <= now() ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                       ($challenge->end_date < now() ? 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300' : 
                                       'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300') }}">
                                    @if($challenge->end_date > now() && $challenge->start_date <= now())
                                        Active
                                    @elseif($challenge->end_date < now())
                                        @if($challenge->winners_count > 0)
                                            Ended ✓
                                        @else
                                            Ended
                                        @endif
                                    @else
                                        Upcoming
                                    @endif
                                </span>
                            </div>

                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 line-clamp-2">
                                {{ Str::limit($challenge->description, 100) }}
                            </p>

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $challenge->submissions_count }} submissions
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    {{ $challenge->winners_count }} winners
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                                <div class="flex justify-between mb-1">
                                    <span>Start: {{ \Carbon\Carbon::parse($challenge->start_date)->format('M d, Y') }}</span>
                                    <span>End: {{ \Carbon\Carbon::parse($challenge->end_date)->format('M d, Y') }}</span>
                                </div>
                                @if($challenge->end_date > now())
                                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5">
                                        @php
                                            $totalDays = $challenge->start_date->diffInDays($challenge->end_date);
                                            $daysPassed = $challenge->start_date->diffInDays(now());
                                            $percentage = min(100, max(0, ($daysPassed / $totalDays) * 100));
                                        @endphp
                                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class="mt-1 text-right">
                                        {{ round($percentage) }}% complete
                                    </div>
                                @else
                                    <div class="text-center italic">
                                        Challenge ended {{ $challenge->end_date->diffForHumans() }}
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('curator.challenges.show', $challenge->id) }}" 
                                   class="flex-1 text-center px-3 py-2 text-sm font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 rounded-lg transition-colors">
                                    View Details
                                </a>
                                <a href="{{ route('curator.challenges.submissions', $challenge->id) }}" 
                                   class="flex-1 text-center px-3 py-2 text-sm font-medium bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-800/30 text-blue-700 dark:text-blue-300 rounded-lg transition-colors">
                                    Submissions
                                </a>
                                @if($challenge->end_date < now() && $challenge->winners_count == 0)
                                    <a href="{{ route('curator.challenges.select-winners', $challenge->id) }}" 
                                       class="px-3 py-2 bg-orange-100 hover:bg-orange-200 dark:bg-orange-900/30 dark:hover:bg-orange-800/30 text-orange-700 dark:text-orange-300 rounded-lg transition-colors flex items-center"
                                       title="Select Winners">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-8">
                {{ $challenges->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="text-xl font-ui font-semibold text-slate-900 dark:text-white mb-3">
                        @if(request('filter') == 'without-winners')
                            No Challenges Need Winners
                        @elseif(request('filter'))
                            No {{ ucfirst(request('filter')) }} Challenges
                        @else
                            No Challenges Yet
                        @endif
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-6">
                        @if(request('filter') == 'without-winners')
                            Great news! All your ended challenges already have winners selected.
                        @elseif(request('filter'))
                            You don't have any {{ request('filter') }} challenges at the moment.
                        @else
                            Create your first challenge to engage with the creative community and discover amazing artworks.
                        @endif
                    </p>
                    @if(request('filter') == 'without-winners')
                        <a href="{{ route('curator.challenges.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-lg hover:shadow-lg transition-shadow">
                            View All Challenges
                        </a>
                    @else
                        <a href="{{ route('curator.challenges.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-lg hover:shadow-lg transition-shadow">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Your First Challenge
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection