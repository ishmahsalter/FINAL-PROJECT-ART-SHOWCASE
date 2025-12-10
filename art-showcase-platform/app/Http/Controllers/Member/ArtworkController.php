<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Favorite;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the member's artworks.
     */
    public function index()
    {
        $artworks = Artwork::where('user_id', Auth::id())
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('member.artworks.index', compact('artworks'));
    }

    /**
     * Show the form for creating a new artwork.
     */
    public function create()
    {
        $categories = Category::all();
        return view('member.artworks.create', compact('categories'));
    }

    /**
     * Store a newly created artwork in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'tags' => 'nullable|string|max:500',
            'media_used' => 'nullable|string|max:255',
            'visibility' => 'required|in:public,private,unlisted',
            'status' => 'required|in:draft,published',
        ]);

        // Handle image upload
        $imageData = $this->handleImageUpload($request->file('image'));
        
        // Prepare tags
        $tags = [];
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tags = array_slice($tags, 0, 10); // Max 10 tags
        }

        // Create artwork
        $artwork = Artwork::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(10),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'media_used' => $request->media_used,
            'image_path' => $imageData['path'],
            'image_url' => $imageData['url'],
            'thumbnail_url' => $imageData['thumbnail_url'],
            'tags' => $tags,
            'visibility' => $request->visibility,
            'status' => $request->status,
            'like_count' => 0,
            'favorite_count' => 0,
            'comment_count' => 0,
            'views' => 0,
            'views_count' => 0,
            'report_count' => 0,
            'is_featured' => false,
            'is_approved' => true,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('member.artworks.show', $artwork)
            ->with('success', 'Artwork created successfully!');
    }

    /**
     * Handle image upload and thumbnail creation
     */
    private function handleImageUpload($imageFile)
    {
        // Generate unique filename
        $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $imageFile->getClientOriginalExtension();
        $filename = Str::slug($originalName) . '_' . time() . '_' . Str::random(8) . '.' . $extension;
        $folder = 'artworks';
        
        // Full path for storage
        $fullPath = $folder . '/' . $filename;
        
        // Store original image
        $imageFile->storeAs('public/' . $folder, $filename);
        
        // Create thumbnail
        $thumbnailPath = $this->createThumbnail($fullPath);
        
        return [
            'path' => $fullPath, // artworks/filename.jpg
            'url' => Storage::url($fullPath),
            'thumbnail_url' => $thumbnailPath ? Storage::url($thumbnailPath) : Storage::url($fullPath),
        ];
    }

    /**
     * Create thumbnail for image
     */
    private function createThumbnail($imagePath)
    {
        try {
            $fullPath = storage_path('app/public/' . $imagePath);
            
            if (!file_exists($fullPath)) {
                return null;
            }
            
            // Create thumbnail filename
            $pathInfo = pathinfo($imagePath);
            $thumbnailFilename = $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
            $thumbnailPath = $pathInfo['dirname'] . '/thumbs/' . $thumbnailFilename;
            $thumbnailFullPath = storage_path('app/public/' . $thumbnailPath);
            
            // Create thumbs directory if not exists
            $thumbnailDir = dirname($thumbnailFullPath);
            if (!is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }
            
            // Create thumbnail (300x300 max, maintain aspect ratio)
            $image = Image::make($fullPath);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Save thumbnail
            $image->save($thumbnailFullPath);
            
            return $thumbnailPath;
            
        } catch (\Exception $e) {
            \Log::error('Thumbnail creation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Display the specified artwork.
     */
    public function show(Artwork $artwork)
    {
        // Cek authorization
        if (!$artwork->isVisibleTo(Auth::id())) {
            abort(403, 'This artwork is private.');
        }
        
        // Increment views (kecuali pemilik)
        if (Auth::id() !== $artwork->user_id) {
            $artwork->incrementViews(Auth::id());
        }
        
        $artwork->load(['user', 'category', 'comments.user']);
        
        // Cek likes & favorites
        $hasLiked = Auth::check() ? $artwork->likes()->where('user_id', Auth::id())->exists() : false;
        $hasFavorited = Auth::check() ? $artwork->favorites()->where('user_id', Auth::id())->exists() : false;
        
        return view('member.artworks.show', compact('artwork', 'hasLiked', 'hasFavorited'));
    }

    /**
     * Show the form for editing the specified artwork.
     */
    public function edit(Artwork $artwork)
    {
        // Cek ownership
        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $categories = Category::all();
        
        return view('member.artworks.edit', compact('artwork', 'categories'));
    }

    /**
     * Update the specified artwork in storage.
     */
    public function update(Request $request, Artwork $artwork)
    {
        // Cek ownership
        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'tags' => 'nullable|string|max:500',
            'media_used' => 'nullable|string|max:255',
            'visibility' => 'required|in:public,private,unlisted',
            'status' => 'required|in:draft,published',
        ]);
        
        // Prepare update data
        $updateData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(10),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'media_used' => $request->media_used,
            'visibility' => $request->visibility,
            'status' => $request->status,
        ];
        
        // Handle tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tags = array_slice($tags, 0, 10);
            $updateData['tags'] = $tags;
        } else {
            $updateData['tags'] = [];
        }
        
        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old images
            $this->deleteArtworkImages($artwork);
            
            // Upload new image
            $imageData = $this->handleImageUpload($request->file('image'));
            
            $updateData['image_path'] = $imageData['path'];
            $updateData['image_url'] = $imageData['url'];
            $updateData['thumbnail_url'] = $imageData['thumbnail_url'];
        }
        
        // Update published_at if status changed to published
        if ($request->status === 'published' && $artwork->status !== 'published') {
            $updateData['published_at'] = now();
        } elseif ($request->status === 'draft' && $artwork->status === 'published') {
            $updateData['published_at'] = null;
        }
        
        // Update artwork
        $artwork->update($updateData);
        
        return redirect()->route('member.artworks.show', $artwork)
            ->with('success', 'Artwork updated successfully!');
    }

    /**
     * Delete artwork images from storage
     */
    private function deleteArtworkImages(Artwork $artwork)
    {
        if ($artwork->image_path) {
            // Delete original image
            Storage::disk('public')->delete($artwork->image_path);
            
            // Delete thumbnail if exists
            $pathInfo = pathinfo($artwork->image_path);
            $thumbnailPath = $pathInfo['dirname'] . '/thumbs/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
            
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
        }
    }

    /**
     * Remove the specified artwork from storage.
     */
    public function destroy(Artwork $artwork)
    {
        // Cek ownership
        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Delete images
        $this->deleteArtworkImages($artwork);
        
        // Delete artwork (soft delete)
        $artwork->delete();
        
        return redirect()->route('member.artworks.index')
            ->with('success', 'Artwork deleted successfully!');
    }

    /**
     * Like an artwork.
     */
    public function like(Request $request, Artwork $artwork)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Please login to like artworks'], 401);
            }
            return redirect()->route('login');
        }
        
        $existingLike = Like::where('user_id', Auth::id())
            ->where('artwork_id', $artwork->id)
            ->first();
            
        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $artwork->decrement('like_count');
            $liked = false;
        } else {
            // Like
            Like::create([
                'user_id' => Auth::id(),
                'artwork_id' => $artwork->id,
            ]);
            $artwork->increment('like_count');
            $liked = true;
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $artwork->fresh()->like_count,
            ]);
        }
        
        return redirect()->back();
    }

    /**
     * Favorite an artwork.
     */
    public function favorite(Request $request, Artwork $artwork)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Please login to favorite artworks'], 401);
            }
            return redirect()->route('login');
        }
        
        $existingFavorite = Favorite::where('user_id', Auth::id())
            ->where('artwork_id', $artwork->id)
            ->first();
            
        if ($existingFavorite) {
            // Unfavorite
            $existingFavorite->delete();
            $artwork->decrement('favorite_count');
            $favorited = false;
        } else {
            // Favorite
            Favorite::create([
                'user_id' => Auth::id(),
                'artwork_id' => $artwork->id,
            ]);
            $artwork->increment('favorite_count');
            $favorited = true;
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'favorited' => $favorited,
                'favorites_count' => $artwork->fresh()->favorite_count,
            ]);
        }
        
        return redirect()->back();
    }

    /**
     * Comment on an artwork.
     */
    public function comment(Request $request, Artwork $artwork)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'artwork_id' => $artwork->id,
            'comment' => $request->content,
        ]);
        
        $artwork->increment('comment_count');
        
        if ($request->ajax()) {
            $comment->load('user');
            return response()->json([
                'success' => true,
                'comment' => $comment,
            ]);
        }
        
        return redirect()->back()
            ->with('success', 'Comment added successfully!');
    }
}