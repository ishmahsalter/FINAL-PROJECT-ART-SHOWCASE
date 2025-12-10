<!-- resources/views/member/artworks/partials/form.blade.php -->
<div class="space-y-8">
    <!-- Basic Information -->
    <div>
        <h3 class="text-xl font-bold text-white mb-6 pb-3 border-b border-slate-700/50">
            Basic Information
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title Field -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-slate-300 mb-2">
                    Artwork Title *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ isset($artwork) ? old('title', $artwork->title) : old('title') }}"
                       required
                       maxlength="255"
                       class="force-black-text w-full px-4 py-3 bg-slate-100 border border-slate-300 rounded-xl placeholder-slate-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
                       placeholder="Enter a descriptive title for your artwork">
                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Category Field -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-slate-300 mb-2">
                    Category *
                </label>
                <select id="category_id" 
                        name="category_id" 
                        required
                        class="force-black-text w-full px-4 py-3 bg-slate-100 border border-slate-300 rounded-xl focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all appearance-none">
                    <option value="" disabled {{ !isset($artwork) ? 'selected' : '' }} class="text-gray-500">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ (isset($artwork) && old('category_id', $artwork->category_id) == $category->id) || (!isset($artwork) && old('category_id') == $category->id) ? 'selected' : '' }}
                            class="force-black-text">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Tags Field -->
            <div>
                <label for="tags" class="block text-sm font-medium text-slate-300 mb-2">
                    Tags
                </label>
                <input type="text" 
                       id="tags" 
                       name="tags" 
                       value="{{ isset($artwork) ? (is_array($artwork->tags) ? implode(', ', $artwork->tags) : $artwork->tags) : old('tags') }}"
                       class="force-black-text w-full px-4 py-3 bg-slate-100 border border-slate-300 rounded-xl placeholder-slate-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
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
    
    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-slate-300 mb-2">
            Description
        </label>
        <textarea id="description" 
                  name="description" 
                  rows="4"
                  maxlength="2000"
                  class="force-black-text w-full px-4 py-3 bg-slate-100 border border-slate-300 rounded-xl placeholder-slate-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
                  placeholder="Tell the story behind your artwork, techniques used, inspiration, etc.">{{ isset($artwork) ? old('description', $artwork->description) : old('description') }}</textarea>
        <div class="flex justify-between mt-2">
            <p class="text-xs text-slate-400">
                Optional, max 2000 characters
            </p>
            <span id="charCount" class="text-xs text-slate-400">{{ isset($artwork) ? strlen($artwork->description ?? '') : '0' }}/2000</span>
        </div>
        @error('description')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <!-- Media Used -->
    <div>
        <label for="media_used" class="block text-sm font-medium text-slate-300 mb-2">
            Media Used
        </label>
        <input type="text" 
               id="media_used" 
               name="media_used" 
               value="{{ isset($artwork) ? old('media_used', $artwork->media_used) : old('media_used') }}"
               class="force-black-text w-full px-4 py-3 bg-slate-100 border border-slate-300 rounded-xl placeholder-slate-500 focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all"
               placeholder="e.g., Photoshop, Oil on Canvas, Digital Painting">
        <p class="mt-2 text-xs text-slate-400">
            What tools or mediums did you use?
        </p>
        @error('media_used')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>

@push('styles')
<style>
/* CSS yang sangat spesifik dan kuat */
.force-black-text,
.force-black-text:focus,
.force-black-text:hover,
.force-black-text:active {
    color: #000000 !important;
    -webkit-text-fill-color: #000000 !important;
}

/* Untuk menangani autofill browser */
input.force-black-text:-webkit-autofill,
input.force-black-text:-webkit-autofill:hover, 
input.force-black-text:-webkit-autofill:focus,
textarea.force-black-text:-webkit-autofill,
textarea.force-black-text:-webkit-autofill:hover,
textarea.force-black-text:-webkit-autofill:focus,
select.force-black-text:-webkit-autofill,
select.force-black-text:-webkit-autofill:hover,
select.force-black-text:-webkit-autofill:focus {
    -webkit-text-fill-color: #000000 !important;
    -webkit-box-shadow: 0 0 0px 1000px #f1f5f9 inset !important;
    box-shadow: 0 0 0px 1000px #f1f5f9 inset !important;
}
</style>
@endpush

@push('scripts')
<script>
// Character counter for description
const description = document.getElementById('description');
const charCount = document.getElementById('charCount');

if (description && charCount) {
    description.addEventListener('input', function() {
        charCount.textContent = `${this.value.length}/2000`;
    });
}

// Force black text on all form inputs dengan JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Target semua input, textarea, select
    const inputs = document.querySelectorAll('input, textarea, select');
    
    inputs.forEach(input => {
        // Set warna hitam dengan JavaScript
        input.style.color = '#000000';
        input.style.setProperty('color', '#000000', 'important');
        
        // Tambahkan event listener untuk perubahan dinamis
        input.addEventListener('input', function() {
            this.style.color = '#000000';
            this.style.setProperty('color', '#000000', 'important');
        });
        
        input.addEventListener('change', function() {
            this.style.color = '#000000';
            this.style.setProperty('color', '#000000', 'important');
        });
    });
    
    // Juga terapkan untuk option elements
    const options = document.querySelectorAll('option');
    options.forEach(option => {
        if (option.value !== "") { // Jangan ubah placeholder option
            option.style.color = '#000000';
            option.style.setProperty('color', '#000000', 'important');
        }
    });
});

// Interval untuk memastikan warna tetap hitam (jika ada yang mengubahnya)
setInterval(() => {
    document.querySelectorAll('input, textarea, select').forEach(el => {
        if (el.style.color !== 'rgb(0, 0, 0)' && el.style.color !== '#000000') {
            el.style.color = '#000000';
            el.style.setProperty('color', '#000000', 'important');
        }
    });
}, 100);
</script>
@endpush