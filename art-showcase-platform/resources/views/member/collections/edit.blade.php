{{-- resources/views/member/collections/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Collection - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                Edit Collection
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                Update your collection information and settings
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Edit Form -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('member.collections.update', $collection->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Collection Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Collection Name *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $collection->name) }}"
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white"
                                   required>
                            @if($errors->has('name'))
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                        <!-- Collection Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white">{{ old('description', $collection->description) }}</textarea>
                            @if($errors->has('description'))
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $errors->first('description') }}
                                </p>
                            @endif
                        </div>

                        <!-- Visibility -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                                Visibility
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border border-slate-300 dark:border-slate-700 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <input type="radio" 
                                           name="is_public" 
                                           value="1" 
                                           {{ old('is_public', $collection->is_public) ? 'checked' : '' }}
                                           class="text-purple-600 focus:ring-purple-500">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-slate-900 dark:text-white">Public</span>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">Anyone can view this collection</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border border-slate-300 dark:border-slate-700 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <input type="radio" 
                                           name="is_public" 
                                           value="0" 
                                           {{ !old('is_public', $collection->is_public) ? 'checked' : '' }}
                                           class="text-purple-600 focus:ring-purple-500">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-slate-900 dark:text-white">Private</span>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">Only you can view this collection</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('member.collections.show', $collection->id) }}" 
                               class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                Cancel
                            </a>
                            <div class="space-x-3">
                                <button type="submit" 
                                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Collection Info -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">
                        Collection Info
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Artworks</p>
                            <p class="text-lg font-medium text-slate-900 dark:text-white">{{ $collection->artworks->count() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Created</p>
                            <p class="text-sm text-slate-900 dark:text-white">{{ $collection->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Last Updated</p>
                            <p class="text-sm text-slate-900 dark:text-white">{{ $collection->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('member.collections.show', $collection->id) }}" 
                           class="flex items-center p-3 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300">View Collection</span>
                        </a>
                        
                        <form action="{{ route('member.collections.destroy', $collection->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this collection? This action cannot be undone.')"
                                    class="flex items-center w-full p-3 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="text-red-700 dark:text-red-400">Delete Collection</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection