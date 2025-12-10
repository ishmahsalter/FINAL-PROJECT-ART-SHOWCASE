@extends('layouts.app')

@section('title', 'Upload Artwork | ArtShowcase')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- HEADER -->
        <div class="mb-8">
            <a href="{{ route('member.artworks.index') }}" 
               class="inline-flex items-center gap-2 text-slate-300 hover:text-white mb-6 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Artworks
            </a>
            
            <h1 class="text-3xl font-bold text-white mb-2">
                Upload New Artwork
            </h1>
            <p class="text-slate-300">
                Share your creativity with the community
            </p>
        </div>
        
        <!-- FORM -->
        <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-sm rounded-2xl border border-slate-700/50 p-6 md:p-8">
            <form action="{{ route('member.artworks.store') }}" method="POST" enctype="multipart/form-data" id="artworkForm">
                @csrf
                
                <div class="space-y-8">
                    <!-- BASIC INFO -->
                    <div>
                        <h3 class="text-xl font-bold text-white mb-6 pb-3 border-b border-slate-700/50">
                            <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                                Basic Information
                            </span>
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- TITLE -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-slate-300 mb-2">
                                    Artwork Title *
                                </label>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}"
                                       required
                                       maxlength="255"
                                       class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-black placeholder-slate-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
                                       placeholder="Enter a descriptive title for your artwork">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- CATEGORY -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-slate-300 mb-2">
                                    Category *
                                </label>
                                <select id="category_id" 
                                        name="category_id" 
                                        required
                                        class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-black focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all appearance-none">
                                    <option value="" disabled selected class="text-slate-500">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="text-black">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- TAGS -->
                            <div>
                                <label for="tags" class="block text-sm font-medium text-slate-300 mb-2">
                                    Tags
                                </label>
                                <input type="text" 
                                       id="tags" 
                                       name="tags" 
                                       value="{{ old('tags') }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-black placeholder-slate-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
                                       placeholder="digital, painting, portrait (comma separated)">
                                <p class="mt-2 text-xs text-slate-400">
                                    Separate tags with commas
                                </p>
                                @error('tags')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- IMAGE UPLOAD -->
                    <div>
                        <h3 class="text-xl font-bold text-white mb-6 pb-3 border-b border-slate-700/50">
                            <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                                Artwork Image
                            </span>
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- UPLOAD AREA -->
                            <div class="border-2 border-dashed border-slate-600 rounded-2xl p-8 text-center hover:border-yellow-500/50 transition-colors"
                                 id="dropZone">
                                <div class="max-w-md mx-auto">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-slate-800 to-purple-800 rounded-2xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    
                                    <p class="text-white font-medium mb-2">
                                        Drop your artwork image here
                                    </p>
                                    <p class="text-slate-400 text-sm mb-4">
                                        PNG, JPG, GIF, WEBP up to 10MB
                                    </p>
                                    
                                    <label for="image" 
                                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-600 hover:to-slate-700 text-white font-medium rounded-xl cursor-pointer transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Choose File
                                    </label>
                                    <input type="file" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*" 
                                           required
                                           class="hidden"
                                           onchange="previewImage(event)">
                                </div>
                            </div>
                            
                            <!-- PREVIEW -->
                            <div id="previewContainer" class="hidden">
                                <div class="bg-slate-800/50 rounded-2xl p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-white font-medium">Preview</span>
                                        <button type="button" 
                                                onclick="clearPreview()"
                                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors">
                                            Remove Image
                                        </button>
                                    </div>
                                    <div class="aspect-video rounded-xl overflow-hidden bg-gradient-to-br from-slate-900 to-purple-900">
                                        <img id="imagePreview" 
                                             src="" 
                                             alt="Preview" 
                                             class="w-full h-full object-contain">
                                    </div>
                                </div>
                            </div>
                            
                            @error('image')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- DESCRIPTION -->
                    <div>
                        <h3 class="text-xl font-bold text-white mb-6 pb-3 border-b border-slate-700/50">
                            <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                                Description & Details
                            </span>
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- DESCRIPTION -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-slate-300 mb-2">
                                    Description
                                </label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="4"
                                          maxlength="2000"
                                          class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-black placeholder-slate-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
                                          placeholder="Tell the story behind your artwork, techniques used, inspiration, etc.">{{ old('description') }}</textarea>
                                <div class="flex justify-between mt-2">
                                    <p class="text-xs text-slate-400">
                                        Optional, max 2000 characters
                                    </p>
                                    <span id="charCount" class="text-xs text-slate-400">0/2000</span>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- MEDIA USED -->
                            <div>
                                <label for="media_used" class="block text-sm font-medium text-slate-300 mb-2">
                                    Media Used
                                </label>
                                <input type="text" 
                                       id="media_used" 
                                       name="media_used" 
                                       value="{{ old('media_used') }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-black placeholder-slate-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
                                       placeholder="e.g., Photoshop, Oil on Canvas, Digital Painting">
                                <p class="mt-2 text-xs text-slate-400">
                                    What tools or mediums did you use?
                                </p>
                                @error('media_used')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- SETTINGS -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- VISIBILITY -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-3">
                                        Visibility
                                    </label>
                                    <div class="space-y-3">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="radio" 
                                                   name="visibility" 
                                                   value="public" 
                                                   {{ old('visibility', 'public') == 'public' ? 'checked' : '' }}
                                                   class="text-yellow-500 focus:ring-yellow-500">
                                            <div class="flex-1">
                                                <span class="text-white">Public</span>
                                                <p class="text-xs text-slate-400">Visible to everyone</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="radio" 
                                                   name="visibility" 
                                                   value="private" 
                                                   {{ old('visibility') == 'private' ? 'checked' : '' }}
                                                   class="text-yellow-500 focus:ring-yellow-500">
                                            <div class="flex-1">
                                                <span class="text-white">Private</span>
                                                <p class="text-xs text-slate-400">Only visible to you</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="radio" 
                                                   name="visibility" 
                                                   value="unlisted" 
                                                   {{ old('visibility') == 'unlisted' ? 'checked' : '' }}
                                                   class="text-yellow-500 focus:ring-yellow-500">
                                            <div class="flex-1">
                                                <span class="text-white">Unlisted</span>
                                                <p class="text-xs text-slate-400">Accessible via link only</p>
                                            </div>
                                        </label>
                                    </div>
                                    @error('visibility')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- STATUS -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-3">
                                        Status
                                    </label>
                                    <div class="space-y-3">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="radio" 
                                                   name="status" 
                                                   value="published" 
                                                   {{ old('status', 'published') == 'published' ? 'checked' : '' }}
                                                   class="text-yellow-500 focus:ring-yellow-500">
                                            <div class="flex-1">
                                                <span class="text-white">Publish Now</span>
                                                <p class="text-xs text-slate-400">Make it public immediately</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="radio" 
                                                   name="status" 
                                                   value="draft" 
                                                   {{ old('status') == 'draft' ? 'checked' : '' }}
                                                   class="text-yellow-500 focus:ring-yellow-500">
                                            <div class="flex-1">
                                                <span class="text-white">Save as Draft</span>
                                                <p class="text-xs text-slate-400">Save for later editing</p>
                                            </div>
                                        </label>
                                    </div>
                                    @error('status')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FORM ACTIONS -->
                    <div class="pt-6 border-t border-slate-700/50">
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ route('member.artworks.index') }}"
                               class="px-8 py-3 border border-slate-600 text-slate-300 hover:text-white hover:border-slate-500 rounded-xl font-medium transition-colors text-center">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold rounded-xl transition-all transform hover:-translate-y-0.5">
                                Upload Artwork
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- UPLOAD TIPS -->
        <div class="mt-8 bg-gradient-to-br from-slate-800/30 to-purple-900/20 backdrop-blur-sm rounded-2xl border border-slate-700/50 p-6">
            <h4 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Upload Tips
            </h4>
            <ul class="space-y-3 text-slate-300">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>Use high-quality images (min 1200px width recommended)</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>Add descriptive titles and detailed descriptions for better discoverability</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>Use relevant tags to help others find your artwork</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>Consider watermarks if you're concerned about unauthorized use</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Image Upload Script - FIXED VERSION
console.log('🔄 Artwork upload script loading...');

// Character counter for description
const description = document.getElementById('description');
const charCount = document.getElementById('charCount');

if (description && charCount) {
    // Set initial character count
    charCount.textContent = `${description.value.length}/2000`;
    
    description.addEventListener('input', function() {
        charCount.textContent = `${this.value.length}/2000`;
    });
}

// Image preview function - WORKING VERSION
function previewImage(event) {
    console.log('🎬 previewImage() function called');
    
    const input = event.target;
    const previewContainer = document.getElementById('previewContainer');
    const preview = document.getElementById('imagePreview');
    const dropZone = document.getElementById('dropZone');
    
    console.log('📦 Elements found:', {
        input: input,
        previewContainer: previewContainer,
        preview: preview,
        dropZone: dropZone
    });
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        console.log('📁 File selected:', file.name, `(${Math.round(file.size/1024)}KB, ${file.type})`);
        
        // Validation
        if (!file.type.startsWith('image/')) {
            alert('❌ Please select an image file (PNG, JPG, GIF, WEBP)');
            input.value = '';
            return;
        }
        
        if (file.size > 10 * 1024 * 1024) { // 10MB
            alert('❌ File size should be less than 10MB');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            console.log('✅ File loaded successfully, setting preview...');
            
            // 1. Set the image source
            preview.src = e.target.result;
            
            // 2. Show preview container (REMOVE hidden class)
            previewContainer.classList.remove('hidden');
            
            // 3. Hide drop zone (ADD hidden class)
            dropZone.classList.add('hidden');
            
            console.log('🎉 Preview should be visible now!');
            console.log('👉 previewContainer classes:', previewContainer.className);
            console.log('👉 dropZone classes:', dropZone.className);
            
            // Force a reflow to ensure display updates
            void previewContainer.offsetWidth;
        };
        
        reader.onerror = function(e) {
            console.error('❌ Error loading image:', e);
            alert('Error loading the image. Please try another file.');
        };
        
        reader.readAsDataURL(file);
    } else {
        console.log('⚠️ No file selected');
    }
}

function clearPreview() {
    console.log('🗑️ clearPreview() called');
    
    const input = document.getElementById('image');
    const previewContainer = document.getElementById('previewContainer');
    const dropZone = document.getElementById('dropZone');
    const preview = document.getElementById('imagePreview');
    
    // Clear the file input
    input.value = '';
    
    // Clear the preview image
    preview.src = '';
    
    // Hide preview container
    previewContainer.classList.add('hidden');
    
    // Show drop zone
    dropZone.classList.remove('hidden');
    
    console.log('✅ Preview cleared');
}

// Drag and drop functionality
const dropZone = document.getElementById('dropZone');

if (dropZone) {
    console.log('✅ Drop zone element found, adding event listeners...');
    
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('border-yellow-500', 'bg-slate-800/30');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('border-yellow-500', 'bg-slate-800/30');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('border-yellow-500', 'bg-slate-800/30');
        
        const files = e.dataTransfer.files;
        console.log('📦 Files dropped:', files.length);
        
        if (files.length > 0) {
            const file = files[0];
            console.log('📄 Dropped file:', file.name);
            
            const input = document.getElementById('image');
            
            // Create a DataTransfer object to set files
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            
            // Manually trigger the change event
            console.log('🔄 Triggering change event manually...');
            const changeEvent = new Event('change', { bubbles: true });
            input.dispatchEvent(changeEvent);
        }
    });
    
    console.log('✅ Drag & drop event listeners added successfully');
} else {
    console.error('❌ Drop zone element not found!');
}

console.log('✅ All artwork upload scripts loaded successfully!');
</script>
@endpush