{{-- resources/views/member/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Profile - ArtShowcase')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                Edit Profile
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                Update your personal information and profile settings.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Profile Info -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h2 class="text-xl font-ui font-semibold text-slate-900 dark:text-white mb-6">
                        Basic Information
                    </h2>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Upload -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                                Profile Picture
                            </label>
                            <div class="flex items-center space-x-6">
                                <div class="relative">
                                    @if(Auth::user()->avatar_url)
                                        <img src="{{ Auth::user()->avatar_url }}" 
                                             alt="{{ Auth::user()->name }}"
                                             class="w-24 h-24 rounded-full object-cover border-4 border-white dark:border-slate-800 shadow-lg">
                                    @else
                                        <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-2xl border-4 border-white dark:border-slate-800 shadow-lg">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-2 -right-2">
                                        <label for="avatar" class="cursor-pointer bg-purple-600 hover:bg-purple-700 text-white p-2 rounded-full shadow-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </label>
                                        <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-slate-600 dark:text-slate-400">
                                        Upload a new profile picture. JPG, PNG, GIF up to 2MB.
                                    </p>
                                    @if($errors->has('avatar'))
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                            {{ $errors->first('avatar') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Full Name *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', Auth::user()->name) }}"
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white"
                                   required>
                            @if($errors->has('name'))
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Email Address *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', Auth::user()->email) }}"
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white"
                                   required>
                            @if($errors->has('email'))
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <!-- Username -->
                        <div class="mb-6">
                            <label for="username" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Username
                            </label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username', Auth::user()->username) }}"
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white"
                                   placeholder="Your unique username">
                            @if($errors->has('username'))
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $errors->first('username') }}
                                </p>
                            @endif
                        </div>

                        <!-- Bio -->
                        <div class="mb-6">
                            <label for="bio" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Bio
                            </label>
                            <textarea id="bio" 
                                      name="bio" 
                                      rows="4"
                                      class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white"
                                      placeholder="Tell us about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
                            @if($errors->has('bio'))
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $errors->first('bio') }}
                                </p>
                            @endif
                        </div>

                        <!-- Website -->
                        <div class="mb-6">
                            <label for="website" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Website
                            </label>
                            <input type="url" 
                                   id="website" 
                                   name="website" 
                                   value="{{ old('website', Auth::user()->website) }}"
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white"
                                   placeholder="https://example.com">
                            @if($errors->has('website'))
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $errors->first('website') }}
                                </p>
                            @endif
                        </div>

                        <!-- Social Links -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                                Social Links
                            </label>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </div>
                                    <input type="url" 
                                           name="social_links[facebook]" 
                                           value="{{ old('social_links.facebook', Auth::user()->social_links['facebook'] ?? '') }}"
                                           class="flex-1 px-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white"
                                           placeholder="https://facebook.com/yourprofile">
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-pink-600 dark:text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                        </svg>
                                    </div>
                                    <input type="url" 
                                           name="social_links[instagram]" 
                                           value="{{ old('social_links.instagram', Auth::user()->social_links['instagram'] ?? '') }}"
                                           class="flex-1 px-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:text-white"
                                           placeholder="https://instagram.com/yourprofile">
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.213c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                    </div>
                                    <input type="url" 
                                           name="social_links[twitter]" 
                                           value="{{ old('social_links.twitter', Auth::user()->social_links['twitter'] ?? '') }}"
                                           class="flex-1 px-4 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white"
                                           placeholder="https://twitter.com/yourprofile">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('member.dashboard') }}" 
                               class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Account Security -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">
                        Account Security
                    </h3>
                    <a href="{{ route('member.profile.password.update') }}" 
                       class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300">Change Password</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Profile Preview -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-ui font-semibold text-slate-900 dark:text-white mb-4">
                        Profile Preview
                    </h3>
                    <div class="flex items-center space-x-4 mb-4">
                        @if(Auth::user()->avatar_url)
                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-16 h-16 rounded-full">
                        @else
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-medium text-slate-900 dark:text-white">{{ Auth::user()->name }}</h4>
                            @if(Auth::user()->username)
                                <p class="text-sm text-slate-500 dark:text-slate-400">@{{ Auth::user()->username }}</p>
                            @endif
                        </div>
                    </div>
                    @if(Auth::user()->bio)
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">{{ Auth::user()->bio }}</p>
                    @endif
                    <a href="{{ route('profile.show', Auth::user()->username ?? Auth::user()->id) }}" 
                       target="_blank"
                       class="inline-flex items-center text-sm text-purple-600 dark:text-purple-400 hover:underline">
                        View Public Profile
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection