@extends('layouts.app')

@section('title', 'Edit Artwork | ArtShowcase')

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
                Edit Artwork
            </h1>
            <p class="text-slate-300">
                Update your artwork details
            </p>
        </div>
        
        <!-- FORM -->
        <div class="bg-gradient-to-br from-slate-800/50 to-purple-900/30 backdrop-blur-sm rounded-2xl border border-slate-700/50 p-6 md:p-8">
            <form action="{{ route('member.artworks.update', $artwork) }}" method="POST" enctype="multipart/form-data" id="artworkForm">
                @csrf
                @method('PUT')
                
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
                                       value="{{ old('title', $artwork->title) }}"
                                       required
                                       maxlength="255"
                                       class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
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
                                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all appearance-none">
                                    <option value="" disabled>Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $artwork->category_id) == $category->id ? 'selected' : '' }}>
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
                                       value="{{ old('tags', is_array($artwork->tags) ? implode(', ', $artwork->tags) : $artwork->tags) }}"
                                       class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
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
                            <!-- CURRENT IMAGE -->
                            @if($artwork->image_url || $artwork->image_path)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-300 mb-4">
                                    Current Image
                                </label>
                                <div class="aspect-video rounded-xl overflow-hidden bg-gradient-to-br from-slate-900 to-purple-900">
                                    <img src="{{ $artwork->image_url ?? Storage::url($artwork->image_path) }}" 
                                         alt="{{ $artwork->title }}"
                                         class="w-full h-full object-contain">
                                </div>
                            </div>
                            @endif
                            
                            <!-- NEW IMAGE UPLOAD -->
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-4">
                                    {{ $artwork->image_url ? 'Change Image' : 'Upload Image' }} (Optional)
                                </label>
                                
                                <div class="border-2 border-dashed border-slate-600 rounded-2xl p-8 text-center hover:border-yellow-500/50 transition-colors"
                                     id="dropZone">
                                    <div class="max-w-md mx-auto">
                                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-slate-800 to-purple-800 rounded-2xl flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        
                                        <p class="text-white font-medium mb-2">
                                            Drop new image here
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
                                               class="hidden"
                                               onchange="previewImage(event)">
                                    </div>
                                </div>
                                
                                <!-- PREVIEW -->
                                <div id="previewContainer" class="hidden">
                                    <div class="bg-slate-800/50 rounded-2xl p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-white font-medium">New Image Preview</span>
                                            <button type="button" 
                                                    onclick="clearPreview()"
                                                    class="text-slate-400 hover:text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
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
                                          class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
                                          placeholder="Tell the story behind your artwork, techniques used, inspiration, etc.">{{ old('description', $artwork->description) }}</textarea>
                                <div class="flex justify-between mt-2">
                                    <p class="text-xs text-slate-400">
                                        Optional, max 2000 characters
                                    </p>
                                    <span id="charCount" class="text-xs text-slate-400">{{ strlen($artwork->description ?? '') }}/2000</span>
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
                                       value="{{ old('media_used', $artwork->media_used) }}"
                                       class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
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
                                                   {{ old('visibility', $artwork->visibility ?? 'public') == 'public' ? 'checked' : '' }}
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
                                                   {{ old('visibility', $artwork->visibility ?? 'public') == 'private' ? 'checked' : '' }}
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
                                                   {{ old('visibility', $artwork->visibility ?? 'public') == 'unlisted' ? 'checked' : '' }}
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
                                                   {{ old('status', $artwork->status) == 'published' ? 'checked' : '' }}
                                                   class="text-yellow-500 focus:ring-yellow-500">
                                            <div class="flex-1">
                                                <span class="text-white">Published</span>
                                                <p class="text-xs text-slate-400">Make it public</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="radio" 
                                                   name="status" 
                                                   value="draft" 
                                                   {{ old('status', $artwork->status) == 'draft' ? 'checked' : '' }}
                                                   class="text-yellow-500 focus:ring-yellow-500">
                                            <div class="flex-1">
                                                <span class="text-white">Draft</span>
                                                <p class="text-xs text-slate-400">Save for later</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="radio" 
                                                   name="status" 
                                                   value="pending_review" 
                                                   {{ old('status', $artwork->status) == 'pending_review' ? 'checked' : '' }}
                                                   class="text-yellow-500 focus:ring-yellow-500">
                                            <div class="flex-1">
                                                <span class="text-white">Pending Review</span>
                                                <p class="text-xs text-slate-400">Submit for approval</p>
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
                        <div class="flex flex-col sm:flex-row gap-4 justify-between">
                            <div>
                                <button type="button" 
                                        onclick="if(confirm('Are you sure? This action cannot be undone.')) { document.getElementById('deleteForm').submit(); }"
                                        class="px-6 py-3 bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-400 hover:text-red-300 rounded-xl font-medium transition-colors">
                                    Delete Artwork
                                </button>
                            </div>
                            
                            <div class="flex gap-4">
                                <a href="{{ route('member.artworks.index') }}"
                                   class="px-8 py-3 border border-slate-600 text-slate-300 hover:text-white hover:border-slate-500 rounded-xl font-medium transition-colors text-center">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold rounded-xl transition-all transform hover:-translate-y-0.5">
                                    Update Artwork
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- DELETE FORM -->
            <form id="deleteForm" action="{{ route('member.artworks.destroy', $artwork) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Character counter for description
const description = document.getElementById('description');
const charCount = document.getElementById('charCount');

description.addEventListener('input', function() {
    charCount.textContent = `${this.value.length}/2000`;
});

// Image preview
function previewImage(event) {
    const input = event.target;
    const previewContainer = document.getElementById('previewContainer');
    const preview = document.getElementById('imagePreview');
    const dropZone = document.getElementById('dropZone');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
            dropZone.classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function clearPreview() {
    const input = document.getElementById('image');
    const previewContainer = document.getElementById('previewContainer');
    const dropZone = document.getElementById('dropZone');
    
    input.value = '';
    previewContainer.classList.add('hidden');
    dropZone.classList.remove('hidden');
}

// Drag and drop
const dropZone = document.getElementById('dropZone');

if (dropZone) {
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-yellow-500', 'bg-slate-800/30');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-yellow-500', 'bg-slate-800/30');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-yellow-500', 'bg-slate-800/30');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('image').files = files;
            previewImage({ target: document.getElementById('image') });
        }
    });
}
</script>
@endpush