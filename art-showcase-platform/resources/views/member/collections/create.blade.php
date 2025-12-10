{{-- resources/views/member/collections/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Collection - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                Create New Collection
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                Organize your favorite artworks into a themed collection
            </p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <form action="{{ route('member.collections.store') }}" method="POST">
                @csrf

                <!-- Collection Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Collection Name *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white"
                           placeholder="e.g., Digital Art Masterpieces"
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
                              class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white"
                              placeholder="Describe what this collection is about...">{{ old('description') }}</textarea>
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
                                   {{ old('is_public', true) ? 'checked' : '' }}
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
                                   {{ !old('is_public', true) ? 'checked' : '' }}
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
                    <a href="{{ route('member.collections.index') }}" 
                       class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                        Create Collection
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Tips -->
        <div class="mt-8 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <h3 class="text-lg font-medium text-blue-900 dark:text-blue-300 mb-3">
                💡 Collection Tips
            </h3>
            <ul class="space-y-2 text-blue-800 dark:text-blue-400">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Collections help organize artworks by theme, style, or inspiration</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>You can add or remove artworks from collections anytime</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Public collections can be shared with other users</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection