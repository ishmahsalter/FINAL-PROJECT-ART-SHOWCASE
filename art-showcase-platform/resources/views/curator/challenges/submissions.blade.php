{{-- resources/views/curator/challenges/submissions.blade.php --}}
@extends('layouts.app')

@section('title', 'Submissions - ' . $challenge->title . ' | ArtShowcase')

@push('styles')
<style>
.submission-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-pending { background: #FEF3C7; color: #92400E; }
.status-approved { background: #D1FAE5; color: #065F46; }
.status-rejected { background: #FEE2E2; color: #991B1B; }
.status-winner { background: linear-gradient(135deg, #FFD700, #FFA500); color: #000; }

.artwork-thumbnail {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.artwork-thumbnail:hover {
    transform: scale(1.05);
}

.bulk-actions-bar {
    position: sticky;
    bottom: 0;
    background: white;
    border-top: 1px solid #e5e7eb;
    padding: 1rem;
    margin: -1rem;
    margin-top: 1rem;
}

.dark .bulk-actions-bar {
    background: #1f2937;
    border-color: #374151;
}

.action-dropdown {
    position: relative;
    display: inline-block;
}

.action-dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    min-width: 180px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    border-radius: 8px;
    z-index: 1;
    border: 1px solid #e5e7eb;
}

.dark .action-dropdown-content {
    background: #1f2937;
    border-color: #374151;
}

.action-dropdown:hover .action-dropdown-content {
    display: block;
}

.checkbox-cell {
    width: 40px;
}

.sticky-header {
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
}

.dark .sticky-header {
    background: #1f2937;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.3s ease;
}
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                        Submissions
                    </h1>
                    <div class="flex items-center gap-4 text-slate-600 dark:text-slate-400">
                        <a href="{{ route('curator.challenges.index') }}" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Challenges
                        </a>
                        <span>•</span>
                        <a href="{{ route('curator.challenges.show', $challenge) }}" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                            {{ Str::limit($challenge->title, 30) }}
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center gap-6">
                    <!-- Stats -->
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $submissions->total() }}</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Total</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ $submissions->where('status', 'approved')->count() }}
                            </div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Approved</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                                {{ $submissions->where('status', 'pending')->count() }}
                            </div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Pending</div>
                        </div>
                    </div>
                    
                    <!-- Select Winners Button -->
                    @if($challenge->end_date < now() && $challenge->winners->isEmpty())
                <a href="{{ route('curator.challenges.select-winners', ['challenge' => $challenge->id]) }}">

                       class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-gray-900 font-bold rounded-xl transition-all transform hover:scale-105 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        Select Winners
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Challenge Info Bar -->
            <div class="mt-6 bg-white dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-1">{{ $challenge->title }}</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">{{ Str::limit($challenge->description, 150) }}</p>
                    </div>
                    <div class="flex items-center gap-6 text-sm">
                        <div>
                            <div class="text-slate-500 dark:text-slate-400">Start Date</div>
                            <div class="font-medium text-slate-900 dark:text-white">{{ $challenge->start_date->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-slate-500 dark:text-slate-400">End Date</div>
                            <div class="font-medium text-slate-900 dark:text-white">{{ $challenge->end_date->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-slate-500 dark:text-slate-400">Status</div>
                            @if($challenge->end_date < now())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                    Ended
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    Active
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Actions -->
        <div class="mb-6 bg-white dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <!-- Status Filters -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => 1]) }}"
                       class="px-4 py-2 rounded-lg {{ !request()->has('status') ? 'bg-purple-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                        All
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending', 'page' => 1]) }}"
                       class="px-4 py-2 rounded-lg {{ request('status') == 'pending' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                        Pending
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'approved', 'page' => 1]) }}"
                       class="px-4 py-2 rounded-lg {{ request('status') == 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                        Approved
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected', 'page' => 1]) }}"
                       class="px-4 py-2 rounded-lg {{ request('status') == 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                        Rejected
                    </a>
                    @if($challenge->winners->count() > 0)
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'winner', 'page' => 1]) }}"
                       class="px-4 py-2 rounded-lg {{ request('status') == 'winner' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                        Winners
                    </a>
                    @endif
                </div>
                
                <!-- Search and Bulk Actions -->
                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" 
                               id="search-submissions"
                               placeholder="Search by artist..."
                               class="pl-10 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white w-full md:w-64">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <!-- Bulk Actions Dropdown -->
                    <div class="action-dropdown">
                        <button class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                            Actions
                        </button>
                        <div class="action-dropdown-content p-2">
                            <button type="button" onclick="bulkAction('approve')" class="w-full text-left px-4 py-2 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded">
                                Approve Selected
                            </button>
                            <button type="button" onclick="bulkAction('reject')" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                                Reject Selected
                            </button>
                            <button type="button" onclick="bulkAction('pending')" class="w-full text-left px-4 py-2 text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded">
                                Mark as Pending
                            </button>
                            <hr class="my-2 border-slate-200 dark:border-slate-700">
                            <button type="button" onclick="selectAll()" class="w-full text-left px-4 py-2 text-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 rounded">
                                Select All
                            </button>
                            <button type="button" onclick="deselectAll()" class="w-full text-left px-4 py-2 text-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 rounded">
                                Deselect All
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <!-- Table Header -->
            <div class="sticky-header border-b border-slate-200 dark:border-slate-700">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50">
                            <th class="checkbox-cell py-4 pl-6">
                                <input type="checkbox" id="select-all-checkbox" onchange="toggleSelectAll(this)">
                            </th>
                            <th class="py-4 px-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Artwork
                            </th>
                            <th class="py-4 px-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Artist
                            </th>
                            <th class="py-4 px-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Submitted
                            </th>
                            <th class="py-4 px-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="py-4 px-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Likes
                            </th>
                            <th class="py-4 px-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            
            <!-- Table Body -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($submissions as $submission)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors fade-in" id="submission-{{ $submission->id }}">
                            <!-- Checkbox -->
                            <td class="checkbox-cell py-4 pl-6">
                                <input type="checkbox" 
                                       class="submission-checkbox" 
                                       value="{{ $submission->id }}"
                                       onchange="updateBulkActions()">
                            </td>
                            
                            <!-- Artwork -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('artworks.show', $submission->artwork_id) }}" target="_blank" class="block">
                                        <img src="{{ Storage::url($submission->artwork->image_path) }}" 
                                             alt="{{ $submission->artwork->title }}"
                                             class="artwork-thumbnail">
                                    </a>
                                    <div>
                                        <a href="{{ route('artworks.show', $submission->artwork_id) }}" target="_blank"
                                           class="font-medium text-slate-900 dark:text-white hover:text-purple-600 dark:hover:text-purple-400 transition-colors block">
                                            {{ Str::limit($submission->artwork->title, 30) }}
                                        </a>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $submission->artwork->category->name ?? 'Uncategorized' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Artist -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    @if($submission->user->avatar)
                                    <img src="{{ Storage::url($submission->user->avatar) }}" 
                                         alt="{{ $submission->user->name }}"
                                         class="w-8 h-8 rounded-full object-cover">
                                    @else
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                        {{ substr($submission->user->name, 0, 1) }}
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-medium text-slate-900 dark:text-white">{{ $submission->user->name }}</div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ '@' . ($submission->user->username ?? Str::slug($submission->user->name)) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Submitted -->
                            <td class="py-4 px-4">
                                <div class="text-sm text-slate-900 dark:text-white">
                                    {{ $submission->created_at->format('M d, Y') }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $submission->created_at->diffForHumans() }}
                                </div>
                            </td>
                            
                            <!-- Status -->
                            <td class="py-4 px-4">
                                @if($submission->winner_rank)
                                    <span class="submission-status status-winner">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Winner (#{{ $submission->winner_rank }})
                                    </span>
                                @else
                                    <span class="submission-status status-{{ $submission->status }}">
                                        @switch($submission->status)
                                            @case('pending')
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Pending
                                                @break
                                            @case('approved')
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Approved
                                                @break
                                            @case('rejected')
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Rejected
                                                @break
                                        @endswitch
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Likes -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $submission->artwork->likes_count }}</span>
                                </div>
                            </td>
                            
                            <!-- Actions -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <!-- View -->
                                    <a href="{{ route('artworks.show', $submission->artwork_id) }}" target="_blank"
                                       class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                       title="View Artwork">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Status Actions -->
                                    @if(!$submission->winner_rank)
                                    <div class="action-dropdown">
                                        <button class="p-2 text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                        </button>
                                        <div class="action-dropdown-content p-2 min-w-32">
                                            @if($submission->status != 'approved')
                                            <button onclick="updateStatus({{ $submission->id }}, 'approve')"
                                                    class="w-full text-left px-3 py-2 text-sm text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Approve
                                            </button>
                                            @endif
                                            
                                            @if($submission->status != 'rejected')
                                            <button onclick="updateStatus({{ $submission->id }}, 'reject')"
                                                    class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Reject
                                            </button>
                                            @endif
                                            
                                            @if($submission->status != 'pending')
                                            <button onclick="updateStatus({{ $submission->id }}, 'pending')"
                                                    class="w-full text-left px-3 py-2 text-sm text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Mark Pending
                                            </button>
                                            @endif
                                            
                                            @if($challenge->end_date < now() && $challenge->winners->isEmpty())
                                            <hr class="my-2 border-slate-200 dark:border-slate-700">
                                            <button onclick="markAsWinner({{ $submission->id }})"
                                                    class="w-full text-left px-3 py-2 text-sm text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                </svg>
                                                Mark as Winner
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Remove from challenge -->
                                    <button onclick="removeFromChallenge({{ $submission->id }})"
                                            class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                            title="Remove from challenge">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="w-24 h-24 mx-auto mb-4 text-slate-300 dark:text-slate-600">
                                    <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No Submissions Yet</h3>
                                <p class="text-slate-600 dark:text-slate-400 mb-6">This challenge doesn't have any submissions yet.</p>
                                <a href="{{ route('curator.challenges.show', $challenge) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:shadow-lg transition-shadow">
                                    View Challenge Details
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Bulk Actions Bar (hidden by default) -->
            <div id="bulk-actions-bar" class="bulk-actions-bar hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span id="selected-count" class="font-medium text-slate-900 dark:text-white">0 items selected</span>
                        <div class="flex gap-2">
                            <button onclick="bulkAction('approve')" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors">
                                Approve
                            </button>
                            <button onclick="bulkAction('reject')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors">
                                Reject
                            </button>
                            <button onclick="bulkAction('pending')" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-lg transition-colors">
                                Mark Pending
                            </button>
                        </div>
                    </div>
                    <button onclick="deselectAll()" class="text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-300">
                        Clear Selection
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($submissions->hasPages())
        <div class="mt-6">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Status Update Modal -->
<div id="status-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/70" onclick="closeStatusModal()"></div>
        <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white" id="modal-title">Update Status</h3>
                    <button onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <p class="text-slate-600 dark:text-slate-400 mb-6" id="modal-message"></p>
                <div class="flex gap-3">
                    <button type="button" onclick="closeStatusModal()"
                            class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Cancel
                    </button>
                    <button type="button" onclick="confirmStatusUpdate()"
                            id="confirm-status-btn"
                            class="flex-1 px-4 py-2 text-white font-medium rounded-lg transition-colors">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Bulk selection
let selectedSubmissions = new Set();
let currentSubmissionId = null;
let currentAction = null;

function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.submission-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
        if (checkbox.checked) {
            selectedSubmissions.add(parseInt(cb.value));
        } else {
            selectedSubmissions.delete(parseInt(cb.value));
        }
    });
    updateBulkActions();
}

function selectAll() {
    const checkboxes = document.querySelectorAll('.submission-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = true;
        selectedSubmissions.add(parseInt(cb.value));
    });
    document.getElementById('select-all-checkbox').checked = true;
    updateBulkActions();
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('.submission-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = false;
        selectedSubmissions.delete(parseInt(cb.value));
    });
    document.getElementById('select-all-checkbox').checked = false;
    updateBulkActions();
}

function updateBulkActions() {
    selectedSubmissions.clear();
    document.querySelectorAll('.submission-checkbox:checked').forEach(cb => {
        selectedSubmissions.add(parseInt(cb.value));
    });
    
    const selectedCount = selectedSubmissions.size;
    const bulkBar = document.getElementById('bulk-actions-bar');
    const countElement = document.getElementById('selected-count');
    
    countElement.textContent = `${selectedCount} item${selectedCount !== 1 ? 's' : ''} selected`;
    
    if (selectedCount > 0) {
        bulkBar.classList.remove('hidden');
    } else {
        bulkBar.classList.add('hidden');
    }
}

// Update submission status
function updateStatus(submissionId, action) {
    currentSubmissionId = submissionId;
    currentAction = action;
    
    const modal = document.getElementById('status-modal');
    const title = document.getElementById('modal-title');
    const message = document.getElementById('modal-message');
    const confirmBtn = document.getElementById('confirm-status-btn');
    
    const actions = {
        'approve': { 
            title: 'Approve Submission', 
            message: 'Are you sure you want to approve this submission? The artwork will be publicly visible in the challenge.',
            color: 'bg-green-500 hover:bg-green-600'
        },
        'reject': { 
            title: 'Reject Submission', 
            message: 'Are you sure you want to reject this submission? The artist will be notified.',
            color: 'bg-red-500 hover:bg-red-600'
        },
        'pending': { 
            title: 'Mark as Pending', 
            message: 'Are you sure you want to mark this submission as pending?',
            color: 'bg-orange-500 hover:bg-orange-600'
        }
    };
    
    const config = actions[action];
    title.textContent = config.title;
    message.textContent = config.message;
    confirmBtn.className = `flex-1 px-4 py-2 text-white font-medium rounded-lg transition-colors ${config.color}`;
    confirmBtn.textContent = config.title.split(' ')[0]; // "Approve", "Reject", etc.
    
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeStatusModal() {
    document.getElementById('status-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    currentSubmissionId = null;
    currentAction = null;
}

async function confirmStatusUpdate() {
    if (!currentSubmissionId || !currentAction) return;
    
    try {
        const response = await fetch(`/curator/submissions/${currentSubmissionId}/status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: currentAction })
        });
        
        const data = await response.json();
        if (data.success) {
            // Update the row
            const row = document.getElementById(`submission-${currentSubmissionId}`);
            const statusCell = row.querySelector('.submission-status');
            
            // Update status badge
            statusCell.className = `submission-status status-${currentAction}`;
            statusCell.innerHTML = `
                ${getStatusIcon(currentAction)}
                ${currentAction.charAt(0).toUpperCase() + currentAction.slice(1)}
            `;
            
            showToast(`Submission ${currentAction}d successfully`, 'success');
        } else {
            showToast(data.message || 'Failed to update status', 'error');
        }
    } catch (error) {
        console.error('Error updating status:', error);
        showToast('An error occurred', 'error');
    }
    
    closeStatusModal();
}

// Bulk actions
async function bulkAction(action) {
    if (selectedSubmissions.size === 0) {
        showToast('Please select at least one submission', 'error');
        return;
    }
    
    if (!confirm(`Are you sure you want to ${action} ${selectedSubmissions.size} submission(s)?`)) {
        return;
    }
    
    try {
        const response = await fetch('/curator/submissions/bulk-status', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                submission_ids: Array.from(selectedSubmissions),
                status: action
            })
        });
        
        const data = await response.json();
        if (data.success) {
            // Update all selected rows
            selectedSubmissions.forEach(submissionId => {
                const row = document.getElementById(`submission-${submissionId}`);
                if (row) {
                    const statusCell = row.querySelector('.submission-status');
                    statusCell.className = `submission-status status-${action}`;
                    statusCell.innerHTML = `
                        ${getStatusIcon(action)}
                        ${action.charAt(0).toUpperCase() + action.slice(1)}
                    `;
                }
            });
            
            showToast(`Updated ${selectedSubmissions.size} submission(s)`, 'success');
            deselectAll();
        } else {
            showToast(data.message || 'Failed to update submissions', 'error');
        }
    } catch (error) {
        console.error('Error in bulk action:', error);
        showToast('An error occurred', 'error');
    }
}

// Mark as winner
async function markAsWinner(submissionId) {
    if (!confirm('Mark this submission as a winner? You can select the rank on the winners page.')) {
        return;
    }
    
    try {
        const response = await fetch(`/curator/submissions/${submissionId}/mark-winner`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            showToast('Submission marked as winner. Please assign a rank on the winners page.', 'success');
            // Refresh page after delay
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Failed to mark as winner', 'error');
        }
    } catch (error) {
        console.error('Error marking as winner:', error);
        showToast('An error occurred', 'error');
    }
}

// Remove from challenge
async function removeFromChallenge(submissionId) {
    if (!confirm('Are you sure you want to remove this submission from the challenge? This action cannot be undone.')) {
        return;
    }
    
    try {
        const response = await fetch(`/curator/submissions/${submissionId}/remove`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            const row = document.getElementById(`submission-${submissionId}`);
            row.classList.add('opacity-50');
            setTimeout(() => row.remove(), 300);
            showToast('Submission removed from challenge', 'success');
        } else {
            showToast(data.message || 'Failed to remove submission', 'error');
        }
    } catch (error) {
        console.error('Error removing submission:', error);
        showToast('An error occurred', 'error');
    }
}

// Helper functions
function getStatusIcon(status) {
    switch(status) {
        case 'pending':
            return '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
        case 'approved':
            return '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
        case 'rejected':
            return '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        default:
            return '';
    }
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-6 right-6 px-6 py-3 rounded-xl ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-purple-600'} text-white z-50 animate-slide-up`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : type === 'error' ? 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'}"/>
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Search functionality
document.getElementById('search-submissions').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr[id^="submission-"]');
    
    rows.forEach(row => {
        const artist = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const title = row.querySelector('td:nth-child(2) a').textContent.toLowerCase();
        
        if (artist.includes(searchTerm) || title.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endpush