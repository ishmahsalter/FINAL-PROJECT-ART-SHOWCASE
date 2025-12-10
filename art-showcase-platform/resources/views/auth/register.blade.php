@extends('layouts.app')

@section('title', 'Join ArtShowcase - Where Creativity Meets Recognition')

@section('content')
<!-- Register Hero Section -->
<section class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-900">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-yellow-400/20 rounded-full filter blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-green-400/20 rounded-full filter blur-3xl animate-float-medium"></div>
        <div class="absolute top-1/2 right-1/3 w-64 h-64 bg-blue-400/20 rounded-full filter blur-3xl animate-float-fast"></div>
    </div>

    <!-- Floating Particles -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-2 h-2 bg-white/30 rounded-full animate-pulse"></div>
        <div class="absolute top-40 right-32 w-1 h-1 bg-yellow-400/40 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-32 left-40 w-1 h-1 bg-pink-400/40 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-1 h-1 bg-orange-400/40 rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <!-- Register Container -->
    <div class="relative z-10 w-full max-w-md mx-4">
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-8 text-center border-b border-white/10">
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 via-orange-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                </div>
                <h1 class="font-display text-3xl font-bold text-white mb-2">Join Our Community</h1>
                <p class="text-white/70 font-body">Create your ArtShowcase account and start sharing your creativity</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="p-8" id="registerForm">
                @csrf

                <!-- Name Input -->
                <div class="mb-6">
                    <label for="name" class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        Full Name
                    </label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-30 blur transition-opacity duration-300"></div>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autocomplete="name" 
                            autofocus
                            class="relative w-full px-4 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                            placeholder="Enter your full name"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-30 blur transition-opacity duration-300"></div>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email"
                            class="relative w-full px-4 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                            placeholder="Enter your email"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        Password
                    </label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-30 blur transition-opacity duration-300"></div>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            class="relative w-full px-4 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 password-field"
                            placeholder="Create a strong password"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <button type="button" class="text-white/60 hover:text-white/90 transition-colors duration-300 toggle-password" data-target="password">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-8">
                    <label for="password_confirmation" class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        Confirm Password
                    </label>
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-30 blur transition-opacity duration-300"></div>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            class="relative w-full px-4 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 password-field"
                            placeholder="Confirm your password"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <button type="button" class="text-white/60 hover:text-white/90 transition-colors duration-300 toggle-password" data-target="password_confirmation">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Role Selection - SIMPLIFIED VERSION -->
                <div class="mb-8">
                    <label class="block text-white/80 font-ui font-semibold mb-3 text-sm uppercase tracking-wide">
                        I Want To Join As
                    </label>
                    
                    <div class="space-y-3 role-selection">
                        <!-- Member Option -->
                        <div class="role-option">
                            <input 
                                id="role_member" 
                                type="radio" 
                                name="role" 
                                value="member" 
                                {{ old('role', 'member') == 'member' ? 'checked' : '' }}
                                class="role-radio"
                                required
                            >
                            <label 
                                for="role_member" 
                                class="role-label member-label"
                            >
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1 mr-3">
                                        <div class="w-5 h-5 border-2 border-white/40 rounded-full flex items-center justify-center">
                                            <div class="w-2 h-2 bg-white rounded-full radio-indicator"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-ui font-bold text-white">Member (Creator)</span>
                                            <span class="text-xs px-2 py-1 bg-green-500/20 text-green-300 rounded-full">Immediate Access</span>
                                        </div>
                                        <p class="text-white/60 text-sm">
                                            Upload your artworks, interact with the community, and join exciting challenges.
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Curator Option -->
                        <div class="role-option">
                            <input 
                                id="role_curator" 
                                type="radio" 
                                name="role" 
                                value="curator" 
                                {{ old('role') == 'curator' ? 'checked' : '' }}
                                class="role-radio"
                                required
                            >
                            <label 
                                for="role_curator" 
                                class="role-label curator-label"
                            >
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1 mr-3">
                                        <div class="w-5 h-5 border-2 border-white/40 rounded-full flex items-center justify-center">
                                            <div class="w-2 h-2 bg-white rounded-full radio-indicator"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-ui font-bold text-white">Curator (Event Organizer)</span>
                                            <span class="text-xs px-2 py-1 bg-yellow-500/20 text-yellow-300 rounded-full">Admin Approval Required</span>
                                        </div>
                                        <p class="text-white/60 text-sm">
                                            Create and manage challenges, review submissions, and select winners. 
                                            <span class="text-yellow-300 font-semibold">Requires admin approval before access.</span>
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    @error('role')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Register Button -->
                <button 
                    type="submit"
                    class="w-full py-4 px-6 bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 hover:from-pink-500 hover:via-orange-500 hover:to-yellow-400 text-white font-ui font-bold rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-1 relative overflow-hidden group"
                >
                    <span class="relative z-10 flex items-center justify-center">
                        Create Account
                        <svg class="w-5 h-5 ml-2 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-orange-500 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </button>

                <!-- Login Link -->
                <div class="mt-8 text-center">
                    <p class="text-white/60 font-body">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-ui font-semibold ml-1 transition-colors duration-300">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Back to Home -->
    <div class="absolute bottom-8 left-8">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 text-white/70 hover:text-white transition-colors duration-300 group">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-ui font-semibold">Back to Gallery</span>
        </a>
    </div>
</section>

<style>
/* Reuse animations from main layout */
@keyframes float-slow {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(120deg); }
    66% { transform: translate(-20px, 20px) rotate(240deg); }
}

@keyframes float-medium {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(-30px, 30px) rotate(120deg); }
    66% { transform: translate(20px, -20px) rotate(240deg); }
}

@keyframes float-fast {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(20px, -20px) scale(1.1); }
}

.animate-float-slow { animation: float-slow 20s ease-in-out infinite; }
.animate-float-medium { animation: float-medium 15s ease-in-out infinite; }
.animate-float-fast { animation: float-fast 10s ease-in-out infinite; }

/* Role Selection Styles */
.role-radio {
    position: absolute;
    opacity: 0;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.role-label {
    display: block;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.role-label:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.role-radio:checked + .member-label {
    background: linear-gradient(to right, rgba(34, 197, 94, 0.2), rgba(16, 185, 129, 0.2));
    border-color: rgba(74, 222, 128, 0.5);
    box-shadow: 0 0 0 1px rgba(74, 222, 128, 0.3);
}

.role-radio:checked + .curator-label {
    background: linear-gradient(to right, rgba(59, 130, 246, 0.2), rgba(99, 102, 241, 0.2));
    border-color: rgba(96, 165, 250, 0.5);
    box-shadow: 0 0 0 1px rgba(96, 165, 250, 0.3);
}

.role-radio:checked + .role-label .radio-indicator {
    opacity: 1;
    transform: scale(1);
}

.role-radio:checked + .member-label .radio-indicator {
    background-color: #4ade80;
}

.role-radio:checked + .curator-label .radio-indicator {
    background-color: #60a5fa;
}

.radio-indicator {
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s ease;
}

.role-option {
    position: relative;
}

/* Password toggle styles */
.toggle-password {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
}

.toggle-password:focus {
    outline: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const eyeIcon = this.querySelector('.eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        });
    });

    // Role selection - manual click handling
    document.querySelectorAll('.role-label').forEach(label => {
        label.addEventListener('click', function(e) {
            // Find the associated radio input
            const radioId = this.getAttribute('for');
            const radioInput = document.getElementById(radioId);
            
            if (radioInput) {
                // Uncheck all radios first
                document.querySelectorAll('.role-radio').forEach(radio => {
                    radio.checked = false;
                });
                
                // Check the clicked one
                radioInput.checked = true;
                
                // Trigger change event
                radioInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });

    // Initialize radio button states on page load
    function initializeRadioStates() {
        document.querySelectorAll('.role-radio').forEach(radio => {
            if (radio.checked) {
                radio.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    }

    // Call initialization
    initializeRadioStates();

    // Form validation
    const form = document.getElementById('registerForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Check if a role is selected
            const roleSelected = document.querySelector('input[name="role"]:checked');
            if (!roleSelected) {
                e.preventDefault();
                alert('Please select a role (Member or Curator)');
                return false;
            }
            return true;
        });
    }
});
</script>
@endsection