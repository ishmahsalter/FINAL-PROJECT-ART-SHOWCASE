@extends('layouts.app')

@section('title', 'Create Challenge - Curator Dashboard - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                        Create New Challenge
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        Design a creative challenge for the community
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
            <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-ui font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Challenge Title *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               required
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               placeholder="e.g., 'Abstract Art Challenge'">
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
                                  class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                                  placeholder="Describe the challenge theme, inspiration, and goals...">{{ old('description') }}</textarea>
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
                                  class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                                  placeholder="List the rules, submission guidelines, and requirements...">{{ old('rules') }}</textarea>
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
                               value="{{ old('prize') }}"
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               placeholder="e.g., '1st Place: $500, Featured on homepage'">
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
                                   value="{{ old('start_date', now()->format('Y-m-d')) }}"
                                   required
                                   min="{{ now()->format('Y-m-d') }}"
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
                                   value="{{ old('end_date', now()->addDays(30)->format('Y-m-d')) }}"
                                   required
                                   min="{{ now()->addDay()->format('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Banner Image -->
                    <div>
                        <label for="banner_image" class="block text-sm font-ui font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Banner Image
                        </label>
                        <input type="file" 
                               id="banner_image" 
                               name="banner_image" 
                               accept="image/jpeg,image/png,image/jpg"
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900 dark:file:text-purple-300">
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                            Recommended size: 1200×400 pixels. Max file size: 5MB.
                        </p>
                        @error('banner_image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-slate-200 dark:border-slate-700">
                        <button type="submit" 
                                class="w-full md:w-auto px-8 py-3 bg-gradient-to-br from-purple-500 to-pink-600 text-white font-ui font-semibold rounded-lg hover:shadow-lg transition-shadow focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                            Create Challenge
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    startDate.addEventListener('change', function() {
        const minEndDate = new Date(this.value);
        minEndDate.setDate(minEndDate.getDate() + 1);
        endDate.min = minEndDate.toISOString().split('T')[0];
        
        if (endDate.value && new Date(endDate.value) <= new Date(this.value)) {
            endDate.value = minEndDate.toISOString().split('T')[0];
        }
    });
});
</script>
@endpush
@endsection