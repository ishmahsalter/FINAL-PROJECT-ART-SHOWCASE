{{-- resources/views/member/submissions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Submissions - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-2">
                        My Submissions
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        Track your challenge submissions and their status
                    </p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('member.dashboard') }}" 
                       class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        ← Back to Dashboard
                    </a>
                    
                    @if($activeChallenges->count() > 0)
                    <button onclick="toggleModal()" 
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                        + New Submission
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Total Submissions</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $submissions->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Pending Review</p>
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ $submissions->where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Approved</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $submissions->where('status', 'approved')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions List -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            @if($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-slate-50 dark:bg-slate-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Challenge
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Artwork
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Submitted
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($submissions as $submission)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-lg overflow-hidden bg-slate-200 dark:bg-slate-700">
                                            @if($submission->challenge->banner_image)
                                                <img src="{{ $submission->challenge->banner_image }}" 
                                                     alt="{{ $submission->challenge->title }}" 
                                                     class="h-10 w-10 object-cover">
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                {{ Str::limit($submission->challenge->title, 30) }}
                                            </div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                                Ends: {{ $submission->challenge->end_date->format('M d') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-lg overflow-hidden bg-slate-200 dark:bg-slate-700">
                                            <img src="{{ $submission->artwork->image_url ?? '' }}" 
                                                 alt="{{ $submission->artwork->title }}" 
                                                 class="h-10 w-10 object-cover">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                {{ Str::limit($submission->artwork->title, 25) }}
                                            </div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $submission->artwork->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['color' => 'yellow', 'label' => 'Pending'],
                                            'approved' => ['color' => 'green', 'label' => 'Approved'],
                                            'rejected' => ['color' => 'red', 'label' => 'Rejected'],
                                            'winner' => ['color' => 'purple', 'label' => 'Winner'],
                                        ];
                                        $status = $statusConfig[$submission->status] ?? ['color' => 'gray', 'label' => $submission->status];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 
                                        dark:bg-{{ $status['color'] }}-900 dark:text-{{ $status['color'] }}-300">
                                        {{ $status['label'] }}
                                    </span>
                                    @if($submission->status === 'rejected' && $submission->feedback)
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                        Feedback: {{ Str::limit($submission->feedback, 30) }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                    {{ $submission->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('artworks.show', $submission->artwork_id) }}" 
                                           target="_blank"
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                            View Artwork
                                        </a>
                                        @if($submission->status === 'pending')
                                        <form action="{{ route('member.submissions.destroy', $submission) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this submission?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($submissions->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $submissions->links() }}
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-slate-100 dark:bg-slate-900 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-slate-900 dark:text-white mb-3">No submissions yet</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                        You haven't submitted to any challenges yet. Join a challenge and showcase your artwork!
                    </p>
                    
                    @if($activeChallenges->count() > 0)
                    <button onclick="toggleModal()" 
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg transition-all shadow-lg hover:shadow-xl">
                        + Create Your First Submission
                    </button>
                    @else
                    <div class="inline-flex flex-col items-center">
                        <p class="text-slate-500 dark:text-slate-400 mb-4">No active challenges available at the moment.</p>
                        <a href="{{ route('challenges.index') }}" 
                           class="text-purple-600 dark:text-purple-400 hover:underline">
                            Browse upcoming challenges →
                        </a>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal for New Submission -->
@if($activeChallenges->count() > 0)
<div id="submissionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-slate-900 bg-opacity-75"></div>

        <!-- Modal panel -->
        <div class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 rounded-2xl shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                    Submit to Challenge
                </h3>
                <button onclick="toggleModal()" 
                        class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('member.submissions.store') }}" method="POST" id="submissionForm">
                @csrf
                
                <div class="space-y-6">
                    <!-- Challenge Selection -->
                    <div>
                        <label for="challenge_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Select Challenge *
                        </label>
                        <select name="challenge_id" id="challenge_id" 
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                required
                                onchange="loadArtworks()">
                            <option value="">Choose a challenge...</option>
                            @foreach($activeChallenges as $challenge)
                            <option value="{{ $challenge->id }}" 
                                    data-deadline="{{ $challenge->end_date->format('M d, Y') }}">
                                {{ $challenge->title }} 
                                ({{ $challenge->submissions_count }} submissions)
                            </option>
                            @endforeach
                        </select>
                        <div id="challengeInfo" class="mt-2 hidden">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Deadline: <span id="deadlineText"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Artwork Selection -->
                    <div>
                        <label for="artwork_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Select Artwork *
                        </label>
                        <select name="artwork_id" id="artwork_id" 
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                required
                                disabled>
                            <option value="">Select challenge first...</option>
                        </select>
                        <div id="artworkPreview" class="mt-3 hidden">
                            <!-- Preview akan ditampilkan di sini -->
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Description (Optional)
                        </label>
                        <textarea name="description" id="description" rows="4" 
                                  class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                  placeholder="Tell us why this artwork fits the challenge theme... (Max 500 characters)"></textarea>
                        <div class="text-right mt-1">
                            <span id="charCount" class="text-xs text-slate-500 dark:text-slate-400">0/500</span>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" 
                            onclick="toggleModal()"
                            class="px-5 py-2.5 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            id="submitBtn"
                            class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg transition-all shadow hover:shadow-lg"
                            disabled>
                        Submit Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
// Modal functions
function toggleModal() {
    const modal = document.getElementById('submissionModal');
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    } else {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        resetForm();
    }
}

// Reset form
function resetForm() {
    document.getElementById('submissionForm').reset();
    document.getElementById('artwork_id').innerHTML = '<option value="">Select challenge first...</option>';
    document.getElementById('artwork_id').disabled = true;
    document.getElementById('artworkPreview').classList.add('hidden');
    document.getElementById('challengeInfo').classList.add('hidden');
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('charCount').textContent = '0/500';
}

// Character counter
document.getElementById('description').addEventListener('input', function() {
    const length = this.value.length;
    document.getElementById('charCount').textContent = `${length}/500`;
    
    if (length > 500) {
        this.value = this.value.substring(0, 500);
        document.getElementById('charCount').textContent = '500/500';
    }
});

// Load artworks when challenge is selected
async function loadArtworks() {
    const challengeSelect = document.getElementById('challenge_id');
    const artworkSelect = document.getElementById('artwork_id');
    const challengeInfo = document.getElementById('challengeInfo');
    const selectedOption = challengeSelect.options[challengeSelect.selectedIndex];
    
    if (!challengeSelect.value) {
        resetForm();
        return;
    }
    
    // Show challenge info
    if (selectedOption.dataset.deadline) {
        document.getElementById('deadlineText').textContent = selectedOption.dataset.deadline;
        challengeInfo.classList.remove('hidden');
    }
    
    // Reset and disable artwork select
    artworkSelect.innerHTML = '<option value="">Loading your artworks...</option>';
    artworkSelect.disabled = true;
    document.getElementById('artworkPreview').classList.add('hidden');
    document.getElementById('submitBtn').disabled = true;
    
    try {
        // Fetch user's artworks
        const response = await fetch('/member/artworks/json');
        if (!response.ok) throw new Error('Failed to fetch artworks');
        
        const artworks = await response.json();
        
        if (artworks.length > 0) {
            let options = '<option value="">Choose an artwork...</option>';
            artworks.forEach(artwork => {
                options += `<option value="${artwork.id}" data-image="${artwork.image_url}">${artwork.title}</option>`;
            });
            artworkSelect.innerHTML = options;
            artworkSelect.disabled = false;
            
            // Add event listener for artwork selection
            artworkSelect.addEventListener('change', showArtworkPreview);
        } else {
            artworkSelect.innerHTML = '<option value="">No artworks found. Upload one first!</option>';
        }
    } catch (error) {
        console.error('Error loading artworks:', error);
        artworkSelect.innerHTML = '<option value="">Error loading artworks</option>';
    }
}

// Show artwork preview
function showArtworkPreview() {
    const artworkSelect = document.getElementById('artwork_id');
    const previewDiv = document.getElementById('artworkPreview');
    const submitBtn = document.getElementById('submitBtn');
    const selectedOption = artworkSelect.options[artworkSelect.selectedIndex];
    
    if (artworkSelect.value && selectedOption.dataset.image) {
        previewDiv.innerHTML = `
            <div class="flex items-center space-x-4 p-3 bg-slate-50 dark:bg-slate-900 rounded-lg">
                <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-slate-200 dark:bg-slate-700">
                    <img src="${selectedOption.dataset.image}" alt="Preview" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-900 dark:text-white">${selectedOption.text}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Selected for submission</p>
                </div>
            </div>
        `;
        previewDiv.classList.remove('hidden');
        submitBtn.disabled = false;
    } else {
        previewDiv.classList.add('hidden');
        submitBtn.disabled = true;
    }
}

// Close modal when clicking on background
document.getElementById('submissionModal').addEventListener('click', function(e) {
    if (e.target.id === 'submissionModal') {
        toggleModal();
    }
});

// Prevent form submission if invalid
document.getElementById('submissionForm').addEventListener('submit', function(e) {
    const challengeId = document.getElementById('challenge_id').value;
    const artworkId = document.getElementById('artwork_id').value;
    
    if (!challengeId || !artworkId) {
        e.preventDefault();
        alert('Please select both a challenge and an artwork.');
    }
});
</script>
@endpush

@push('styles')
<style>
#submissionModal {
    backdrop-filter: blur(4px);
}
</style>
@endpush
@endsection