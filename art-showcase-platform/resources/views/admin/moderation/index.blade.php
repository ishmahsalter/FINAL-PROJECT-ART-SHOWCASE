@extends('layouts.app')

@section('title', 'Moderation Queue - Admin')

@section('content')
<div class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Moderation Queue</h1>
            <p class="mt-2 text-gray-600">Review and take action on reported content</p>
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Reported Artworks</h2>
            </div>
            
            @if($reports->isEmpty())
                <div class="p-6 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-4">No reports to review. All clear!</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Artwork
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reported By
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reason
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reports as $report)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- Artwork Info -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($report->reportable)
                                                @if($report->reportable_type === 'App\Models\Artwork')
                                                    <div class="flex-shrink-0 h-12 w-12">
                                                        <img class="h-12 w-12 rounded-lg object-cover" 
                                                            src="{{ $report->reportable->thumbnail_url ?? asset('images/default-artwork.jpg') }}" 
                                                            alt="{{ $report->reportable->title }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a href="{{ route('artworks.show', $report->reportable->id) }}" 
                                                            target="_blank" class="hover:text-blue-600">
                                                                {{ Str::limit($report->reportable->title, 30) }}
                                                            </a>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Artwork</span>
                                                            by {{ $report->reportable->user->username ?? 'Unknown' }}
                                                        </div>
                                                    </div>
                                                @elseif($report->reportable_type === 'App\Models\Comment')
                                                    <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <span class="hover:text-blue-600">
                                                                Comment: {{ Str::limit($report->reportable->comment, 30) }} <!-- GUNAKAN ->comment -->
                                                            </span>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Comment</span>
                                                            by {{ $report->reportable->user->username ?? 'Unknown' }}
                                                        </div>
                                                        @if($report->reportable->artwork)
                                                        <div class="text-xs text-gray-400">
                                                            On: {{ Str::limit($report->reportable->artwork->title, 20) }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-sm text-gray-500">
                                                    Content deleted
                                                    <div class="text-xs text-gray-400">
                                                        {{ $report->reportable_type === 'App\Models\Artwork' ? 'Artwork' : 'Comment' }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                
                                <!-- Reporter -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $report->reporter->username }}</div>
                                    <div class="text-sm text-gray-500">{{ $report->reporter->email }}</div>
                                </td>
                                
                                <!-- Reason -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($report->reason, 50) }}</div>
                                    @if(strlen($report->reason) > 50)
                                        <button onclick="showFullReason({{ $report->id }}, '{{ addslashes($report->reason) }}')"
                                                class="text-xs text-blue-600 hover:text-blue-800 mt-1">
                                            Show more
                                        </button>
                                    @endif
                                </td>
                                
                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'under_review' => 'bg-blue-100 text-blue-800',
                                            'dismissed' => 'bg-green-100 text-green-800',
                                            'resolved' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                    </span>
                                </td>
                                
                                <!-- Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $report->created_at->format('M d, Y') }}
                                </td>
                                
                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($report->status === 'pending')
                                        <div class="flex space-x-2">
                                            <!-- View Details -->
                                            <a href="{{ route('admin.moderation.show', $report->id) }}"
                                               class="inline-flex items-center px-3 py-1 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Review
                                            </a>
                                            
                                            <!-- Quick Actions Dropdown -->
                                            <div class="relative">
                                                <button onclick="toggleActions({{ $report->id }})"
                                                        class="inline-flex items-center px-3 py-1 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">
                                                    Actions
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                                
                                                <!-- Dropdown Menu -->
                                                <div id="actions-{{ $report->id }}" 
                                                     class="absolute right-0 mt-1 w-48 bg-white rounded-md shadow-lg z-10 hidden">
                                                    <div class="py-1">
                                                        <!-- Dismiss Report -->
                                                        <form action="{{ route('reports.dismiss', $report->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition"
                                                                    onclick="return confirm('Dismiss this report?')">
                                                                Dismiss Report
                                                            </button>
                                                        </form>
                                                        
                                                        <!-- Remove Artwork -->
                                                        <form action="{{ route('reports.resolve', $report->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition"
                                                                    onclick="return confirm('Remove this artwork? This action cannot be undone.')">
                                                                Remove Artwork
                                                            </button>
                                                        </form>
                                                        
                                                        <!-- Suspend User -->
                                                        <form action="{{ route('admin.moderation.suspend', $report->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="block w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-gray-100 transition"
                                                                    onclick="return confirm('Suspend user for 7 days?')">
                                                                Suspend User (7 days)
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Resolved by {{ $report->resolver->username ?? 'Admin' }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($reports->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reports->links() }}
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Reason Modal -->
<div id="reasonModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Report Reason</h3>
            <div id="reasonContent" class="text-gray-700 whitespace-pre-wrap"></div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
            <button onclick="closeReasonModal()"
                    class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                Close
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleActions(reportId) {
    const menu = document.getElementById('actions-' + reportId);
    menu.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('[id^="actions-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});

// Show full reason modal
function showFullReason(reportId, reason) {
    document.getElementById('reasonContent').textContent = reason;
    document.getElementById('reasonModal').classList.remove('hidden');
    document.getElementById('reasonModal').classList.add('flex');
}

function closeReasonModal() {
    document.getElementById('reasonModal').classList.add('hidden');
    document.getElementById('reasonModal').classList.remove('flex');
}
</script>
@endpush
@endsection