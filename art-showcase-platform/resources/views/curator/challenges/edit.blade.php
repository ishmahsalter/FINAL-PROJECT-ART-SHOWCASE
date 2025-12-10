@extends('layouts.app')

@section('title', 'Edit Challenge - ' . $challenge->title . ' - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                        Edit Challenge
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        Update challenge details
                    </p>
                </div>
                <a href="{{ route('curator.challenges.index') }}" 
                   class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Back to Challenges
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6 mb-8">
            <form action="{{ route('curator.challenges.update', $challenge->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-ui font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Challenge Title *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $challenge->title) }}"
                               required
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-ui font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Description *
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  required
                                  class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">{{ old('description', $challenge->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rules -->
                    <div>
                        <label for="rules" class="block text-sm font-ui font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Rules & Guidelines *
                        </label>
                        <textarea id="rules" 
                                  name="rules" 
                                  rows="4"
                                  required
                                  class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">{{ old('rules', $challenge->rules) }}</textarea>
                        @error('rules')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prize -->
                    <div>
                        <label for="prize" class="block text-sm font-ui font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Prize Information
                        </label>
                        <input type="text" 
                               id="prize" 
                               name="prize" 
                               value="{{ old('prize', $challenge->prize) }}"
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                        @error('prize')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-ui font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Start Date *
                            </label>
                            <input type="date" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="{{ old('start_date', $challenge->start_date->format('Y-m-d')) }}"
                                   required
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-ui font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                End Date *
                            </label>
                            <input type="date" 
                                   id="end_date" 
                                   name="end_date" 
                                   value="{{ old('end_date', $challenge->end_date->format('Y-m-d')) }}"
                                   required
                                   min="{{ $challenge->start_date->addDay()->format('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('curator.challenges.index') }}" 
                               class="px-6 py-3 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-br from-purple-500 to-pink-600 text-white font-ui font-semibold rounded-lg hover:shadow-lg transition-shadow focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                                Update Challenge
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection