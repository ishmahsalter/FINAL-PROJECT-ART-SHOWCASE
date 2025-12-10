{{-- resources/views/curator/challenges/select-winners.blade.php --}}
@extends('layouts.app')

@section('title', 'Select Winners - ' . $challenge->title . ' | ArtShowcase')

@push('styles')
<style>
.rank-badge {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border-radius: 10px;
    color: white;
}

.rank-1 { background: linear-gradient(135deg, #FFD700, #FFA500); }
.rank-2 { background: linear-gradient(135deg, #C0C0C0, #A9A9A9); }
.rank-3 { background: linear-gradient(135deg, #CD7F32, #8B4513); }

.submission-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.submission-card.selected {
    border-color: #10B981;
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
}

.winner-selection-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .winner-selection-grid {
        grid-template-columns: 1fr;
    }
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.like-count {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(255, 255, 255, 0.1);
    padding: 4px 8px;
    border-radius: 12px;
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
                        Select Winners
                    </h1>
                    <div class="flex items-center gap-4 text-slate-600 dark:text-slate-400">
                        <a href="{{ route('curator.challenges.index') }}" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Challenges
                        </a>
                        <span>•</span>
                        <span>Challenge: <strong class="text-slate-900 dark:text-white">{{ $challenge->title }}</strong></span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <div class="text-sm text-slate-600 dark:text-slate-400">Submissions</div>
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $submissions->count() }}
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Progress Steps -->
            <div class="mt-8">
                <div class="flex items-center justify-between max-w-3xl mx-auto">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold">
                            1
                        </div>
                        <span class="mt-2 text-sm font-medium text-purple-600">Review</span>
                    </div>
                    <div class="flex-1 h-1 bg-purple-200 mx-4"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold">
                            2
                        </div>
                        <span class="mt-2 text-sm font-medium text-purple-600">Select</span>
                    </div>
                    <div class="flex-1 h-1 bg-slate-200 mx-4"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center font-bold">
                            3
                        </div>
                        <span class="mt-2 text-sm font-medium text-slate-500">Confirm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Winner Selection Form -->
       <form id="select-winners-form" action="{{ route('curator.challenges.store-winners', $challenge) }}" method="POST">
            @csrf
            @method('POST')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Submissions Grid -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                                Select Winning Submissions
                            </h2>
                            <span class="text-sm text-slate-600 dark:text-slate-400">
                                Selected: <span id="selected-count">0</span>/3
                            </span>
                        </div>
                        
                        <!-- Filter/Search -->
                        <div class="mb-6">
                            <div class="flex gap-3">
                                <div class="flex-1">
                                    <input type="text" 
                                           id="search-submissions"
                                           placeholder="Search by artist name or title..."
                                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <select id="sort-submissions" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="likes">Most Likes</option>
                                    <option value="random">Random</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Submissions Grid -->
                        <div class="winner-selection-grid" id="submissions-container">
                            @forelse($submissions as $submission)
                            <div class="submission-card bg-slate-50 dark:bg-slate-700/50 rounded-xl p-4 hover:shadow-lg transition-all cursor-pointer"
                                 data-submission-id="{{ $submission->id }}"
                                 data-artist="{{ $submission->user->name }}"
                                 data-title="{{ $submission->artwork->title }}"
                                 data-likes="{{ $submission->artwork->likes_count }}">
                                <!-- Submission Header -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            @if($submission->user->avatar)
                                            <img src="{{ Storage::url($submission->user->avatar) }}" 
                                                 alt="{{ $submission->user->name }}"
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-purple-500">
                                            @else
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ substr($submission->user->name, 0, 1) }}
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-900 dark:text-white">
                                                {{ $submission->user->name }}
                                            </div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $submission->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Like Count -->
                                    <div class="like-count">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm font-medium">{{ $submission->artwork->likes_count }}</span>
                                    </div>
                                </div>
                                
                                <!-- Artwork Image -->
                                <div class="mb-3 rounded-lg overflow-hidden bg-gradient-to-br from-purple-50 to-pink-50 dark:from-slate-600 dark:to-slate-700">
                                    <img src="{{ Storage::url($submission->artwork->image_path) }}" 
                                         alt="{{ $submission->artwork->title }}"
                                         class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                                
                                <!-- Artwork Info -->
                                <div class="mb-4">
                                    <h3 class="font-bold text-slate-900 dark:text-white line-clamp-1 mb-1">
                                        {{ $submission->artwork->title }}
                                    </h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                        {{ Str::limit($submission->artwork->description, 100) }}
                                    </p>
                                </div>
                                
                                <!-- Selection Controls -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <!-- Rank Selection -->
                                        <select name="winners[{{ $submission->id }}][rank]" 
                                                class="rank-select hidden px-3 py-1 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                                            <option value="">Select Rank</option>
                                            <option value="1">1st Place</option>
                                            <option value="2">2nd Place</option>
                                            <option value="3">3rd Place</option>
                                        </select>
                                        
                                        <!-- Winner Badge (hidden by default) -->
                                        <div class="rank-badge hidden"></div>
                                    </div>
                                    
                                    <!-- Select Button -->
                                    <button type="button" 
                                            onclick="toggleSubmissionSelection({{ $submission->id }})"
                                            class="select-btn px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-sm font-medium rounded-lg transition-all">
                                        Select
                                    </button>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-full text-center py-12">
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
                            </div>
                            @endforelse
                        </div>
                        
                        <!-- Pagination -->
                        @if($submissions->hasPages())
                        <div class="mt-8">
                            {{ $submissions->links() }}
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Right: Selected Winners Panel -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <!-- Selected Winners Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6 mb-6">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">
                                Selected Winners
                            </h2>
                            
                            <div id="winners-list" class="space-y-4">
                                <!-- Will be populated by JavaScript -->
                                <div class="text-center py-8 text-slate-500 dark:text-slate-400" id="empty-winners-message">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                    <p>No winners selected yet</p>
                                    <p class="text-sm mt-2">Select up to 3 submissions as winners</p>
                                </div>
                            </div>
                            
                            <!-- Winner Ranking Controls -->
                            <div class="mt-6 space-y-4 hidden" id="ranking-controls">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">Drag to reorder:</span>
                                    <button type="button" onclick="resetWinners()" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        Reset All
                                    </button>
                                </div>
                                <div id="winners-ranking" class="space-y-3">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Challenge Info -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6 mb-6">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
                                Challenge Details
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">Title</div>
                                    <div class="font-medium text-slate-900 dark:text-white">{{ $challenge->title }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">Description</div>
                                    <div class="text-slate-700 dark:text-slate-300 text-sm line-clamp-3">{{ $challenge->description }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">Timeline</div>
                                    <div class="text-slate-700 dark:text-slate-300 text-sm">
                                        {{ $challenge->start_date->format('M d, Y') }} - {{ $challenge->end_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">Status</div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Ended {{ $challenge->end_date->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl border border-purple-200 dark:border-purple-700/30 p-6">
                            <div class="space-y-4">
                                <div class="text-center">
                                    <div class="text-sm text-purple-600 dark:text-purple-400 mb-1">Selected Winners</div>
                                    <div class="text-3xl font-bold text-purple-700 dark:text-purple-300" id="final-selected-count">0</div>
                                </div>
                                
                                <div class="space-y-3">
                                    <button type="submit"
                                            id="submit-winners-btn"
                                            disabled
                                            class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 disabled:from-slate-400 disabled:to-slate-500 disabled:cursor-not-allowed text-white font-bold rounded-xl transition-all transform hover:scale-105 disabled:hover:scale-100">
                                        <span id="submit-text">Confirm Winners Selection</span>
                                        <span id="loading-text" class="hidden">
                                            <svg class="animate-spin h-5 w-5 inline ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Processing...
                                        </span>
                                    </button>
                                    
                                    <button type="button"
                                            onclick="window.location.href='{{ route('curator.challenges.show', $challenge) }}'"
                                            class="w-full px-6 py-3 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-xl transition-colors">
                                        Cancel
                                    </button>
                                </div>
                                
                                <div class="text-xs text-center text-slate-500 dark:text-slate-400 pt-4 border-t border-slate-200 dark:border-slate-700">
                                    <p>⚠️ Winners cannot be changed after confirmation</p>
                                    <p class="mt-1">Winning submissions will be featured on the challenge page</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" class="loading-overlay hidden">
    <div class="text-center">
        <div class="w-16 h-16 mx-auto mb-4 border-4 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
        <div class="text-white text-lg font-medium">Processing winners selection...</div>
        <p class="text-purple-200 mt-2">Please don't close this window</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Store selected winners
let selectedWinners = [];
const maxWinners = 3;

// Toggle submission selection
function toggleSubmissionSelection(submissionId) {
    const card = document.querySelector(`[data-submission-id="${submissionId}"]`);
    const selectBtn = card.querySelector('.select-btn');
    const rankSelect = card.querySelector('.rank-select');
    const rankBadge = card.querySelector('.rank-badge');
    
    const index = selectedWinners.findIndex(w => w.id === submissionId);
    
    if (index === -1) {
        // Add to winners if not at max
        if (selectedWinners.length >= maxWinners) {
            showToast(`Maximum ${maxWinners} winners allowed`, 'error');
            return;
        }
        
        // Add to selected
        selectedWinners.push({
            id: submissionId,
            rank: selectedWinners.length + 1,
            artist: card.dataset.artist,
            title: card.dataset.title,
            image: card.querySelector('img').src
        });
        
        // Update UI
        card.classList.add('selected');
        selectBtn.textContent = 'Selected';
        selectBtn.className = 'select-btn px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-sm font-medium rounded-lg transition-all';
        rankSelect.classList.remove('hidden');
        rankBadge.classList.remove('hidden');
        
        // Set rank
        rankSelect.value = selectedWinners.length;
        updateRankBadge(rankBadge, selectedWinners.length);
        
        // Show rank controls after first selection
        if (selectedWinners.length === 1) {
            document.getElementById('ranking-controls').classList.remove('hidden');
            document.getElementById('empty-winners-message').classList.add('hidden');
        }
    } else {
        // Remove from winners
        selectedWinners.splice(index, 1);
        
        // Update UI
        card.classList.remove('selected');
        selectBtn.textContent = 'Select';
        selectBtn.className = 'select-btn px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-sm font-medium rounded-lg transition-all';
        rankSelect.classList.add('hidden');
        rankBadge.classList.add('hidden');
        
        // Hide rank controls if no winners
        if (selectedWinners.length === 0) {
            document.getElementById('ranking-controls').classList.add('hidden');
            document.getElementById('empty-winners-message').classList.remove('hidden');
        }
    }
    
    // Update counts and lists
    updateWinnerCounts();
    updateWinnersList();
    updateRankingList();
    updateRanksOnCards();
}

// Update rank badge appearance
function updateRankBadge(badge, rank) {
    badge.className = `rank-badge rank-${rank}`;
    badge.textContent = rank === 1 ? '🏆' : rank === 2 ? '🥈' : rank === 3 ? '🥉' : rank;
}

// Update all displayed counts
function updateWinnerCounts() {
    document.getElementById('selected-count').textContent = selectedWinners.length;
    document.getElementById('final-selected-count').textContent = selectedWinners.length;
    
    // Enable/disable submit button
    const submitBtn = document.getElementById('submit-winners-btn');
    submitBtn.disabled = selectedWinners.length === 0;
}

// Update winners list in right panel
function updateWinnersList() {
    const winnersList = document.getElementById('winners-list');
    
    if (selectedWinners.length === 0) {
        winnersList.innerHTML = `
            <div class="text-center py-8 text-slate-500 dark:text-slate-400" id="empty-winners-message">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                <p>No winners selected yet</p>
                <p class="text-sm mt-2">Select up to 3 submissions as winners</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    selectedWinners.forEach((winner, index) => {
        html += `
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-slate-700/50 dark:to-slate-800/50 rounded-xl p-4 border border-purple-200 dark:border-purple-700/30" data-winner-id="${winner.id}">
                <div class="flex items-center gap-3 mb-3">
                    <div class="rank-badge rank-${winner.rank}">
                        ${winner.rank === 1 ? '🏆' : winner.rank === 2 ? '🥈' : '🥉'}
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-slate-900 dark:text-white">${winner.artist}</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400 line-clamp-1">${winner.title}</div>
                    </div>
                    <button type="button" onclick="removeWinner(${winner.id})" class="text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="rounded-lg overflow-hidden">
                    <img src="${winner.image}" alt="${winner.title}" class="w-full h-32 object-cover">
                </div>
            </div>
        `;
    });
    
    winnersList.innerHTML = html;
}

// Update ranking list for drag and drop
function updateRankingList() {
    const rankingList = document.getElementById('winners-ranking');
    let html = '';
    
    selectedWinners.forEach((winner, index) => {
        html += `
            <div class="flex items-center gap-3 bg-white dark:bg-slate-700 p-3 rounded-lg border border-slate-200 dark:border-slate-600" data-winner-id="${winner.id}" draggable="true" ondragstart="dragStart(event)" ondragover="dragOver(event)" ondrop="drop(event)">
                <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="font-medium text-slate-900 dark:text-white">${winner.artist}</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">${winner.title}</div>
                </div>
                <div class="rank-badge rank-${winner.rank}">
                    ${winner.rank === 1 ? '🏆' : winner.rank === 2 ? '🥈' : '🥉'}
                </div>
            </div>
        `;
    });
    
    rankingList.innerHTML = html;
}

// Update ranks on all selected cards
function updateRanksOnCards() {
    selectedWinners.forEach((winner, index) => {
        const card = document.querySelector(`[data-submission-id="${winner.id}"]`);
        if (card) {
            const rankSelect = card.querySelector('.rank-select');
            const rankBadge = card.querySelector('.rank-badge');
            
            winner.rank = index + 1;
            rankSelect.value = winner.rank;
            updateRankBadge(rankBadge, winner.rank);
        }
    });
}

// Remove winner
function removeWinner(submissionId) {
    const card = document.querySelector(`[data-submission-id="${submissionId}"]`);
    if (card) {
        toggleSubmissionSelection(submissionId);
    }
}

// Reset all winners
function resetWinners() {
    if (confirm('Are you sure you want to reset all selected winners?')) {
        // Clear all selections
        document.querySelectorAll('.submission-card.selected').forEach(card => {
            const submissionId = parseInt(card.dataset.submissionId);
            const index = selectedWinners.findIndex(w => w.id === submissionId);
            if (index !== -1) {
                const selectBtn = card.querySelector('.select-btn');
                const rankSelect = card.querySelector('.rank-select');
                const rankBadge = card.querySelector('.rank-badge');
                
                card.classList.remove('selected');
                selectBtn.textContent = 'Select';
                selectBtn.className = 'select-btn px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-sm font-medium rounded-lg transition-all';
                rankSelect.classList.add('hidden');
                rankBadge.classList.add('hidden');
            }
        });
        
        selectedWinners = [];
        updateWinnerCounts();
        updateWinnersList();
        updateRankingList();
        
        document.getElementById('ranking-controls').classList.add('hidden');
        document.getElementById('empty-winners-message').classList.remove('hidden');
    }
}

// Drag and drop functionality
let draggedElement = null;

function dragStart(e) {
    draggedElement = e.target.closest('[data-winner-id]');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', draggedElement.dataset.winnerId);
    setTimeout(() => draggedElement.classList.add('opacity-50'), 0);
}

function dragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
}

function drop(e) {
    e.preventDefault();
    const target = e.target.closest('[data-winner-id]');
    
    if (draggedElement && target && draggedElement !== target) {
        const draggedId = parseInt(draggedElement.dataset.winnerId);
        const targetId = parseInt(target.dataset.winnerId);
        
        const draggedIndex = selectedWinners.findIndex(w => w.id === draggedId);
        const targetIndex = selectedWinners.findIndex(w => w.id === targetId);
        
        if (draggedIndex !== -1 && targetIndex !== -1) {
            // Swap in array
            [selectedWinners[draggedIndex], selectedWinners[targetIndex]] = 
            [selectedWinners[targetIndex], selectedWinners[draggedIndex]];
            
            // Update UI
            updateRanksOnCards();
            updateWinnersList();
            updateRankingList();
        }
    }
    
    if (draggedElement) {
        draggedElement.classList.remove('opacity-50');
        draggedElement = null;
    }
}

// Search and filter functionality
document.getElementById('search-submissions').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.submission-card');
    
    cards.forEach(card => {
        const artist = card.dataset.artist.toLowerCase();
        const title = card.dataset.title.toLowerCase();
        
        if (artist.includes(searchTerm) || title.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

document.getElementById('sort-submissions').addEventListener('change', function(e) {
    const sortBy = e.target.value;
    const container = document.getElementById('submissions-container');
    const cards = Array.from(container.querySelectorAll('.submission-card'));
    
    cards.sort((a, b) => {
        switch(sortBy) {
            case 'newest':
                return new Date(b.dataset.timestamp || 0) - new Date(a.dataset.timestamp || 0);
            case 'oldest':
                return new Date(a.dataset.timestamp || 0) - new Date(b.dataset.timestamp || 0);
            case 'likes':
                return parseInt(b.dataset.likes) - parseInt(a.dataset.likes);
            case 'random':
                return Math.random() - 0.5;
            default:
                return 0;
        }
    });
    
    cards.forEach(card => container.appendChild(card));
});

// Form submission
document.getElementById('select-winners-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (selectedWinners.length === 0) {
        showToast('Please select at least one winner', 'error');
        return;
    }
    
    // Add hidden inputs for winners
    selectedWinners.forEach(winner => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `winners[${winner.id}][rank]`;
        input.value = winner.rank;
        this.appendChild(input);
    });
    
    // Show loading
    const submitBtn = document.getElementById('submit-winners-btn');
    const submitText = document.getElementById('submit-text');
    const loadingText = document.getElementById('loading-text');
    
    submitText.classList.add('hidden');
    loadingText.classList.remove('hidden');
    submitBtn.disabled = true;
    
    // Show loading overlay
    document.getElementById('loading-overlay').classList.remove('hidden');
    
    // Submit form
    this.submit();
});

// Toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-6 right-6 px-6 py-3 rounded-xl ${type === 'error' ? 'bg-red-500' : 'bg-purple-600'} text-white z-50 animate-slide-up`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'error' ? 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'}"/>
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateWinnerCounts();
});
</script>
@endpush