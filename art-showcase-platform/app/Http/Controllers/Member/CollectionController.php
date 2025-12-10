<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Auth::user()->collections()
            ->withCount('artworks')
            ->with(['artworks' => function($query) {
                $query->latest()->take(4);
            }])
            ->latest()
            ->paginate(12);
            
        return view('member.collections.index', compact('collections'));
    }
    
    public function create()
    {
        return view('member.collections.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
            'artwork_ids' => 'nullable|array',
            'artwork_ids.*' => 'exists:artworks,id'
        ]);
        
        $collection = Collection::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'is_public' => $request->is_public ?? false,
            'cover_image' => null, // Will be set from first artwork
        ]);
        
        // Attach artworks if provided
        if ($request->artwork_ids) {
            $collection->artworks()->attach($request->artwork_ids);
            
            // Set cover image from first artwork
            if ($firstArtwork = Artwork::find($request->artwork_ids[0])) {
                $collection->update(['cover_image' => $firstArtwork->image_url]);
            }
        }
        
        return redirect()->route('member.collections.show', $collection->id)
            ->with('success', 'Collection created successfully!');
    }
    
    public function show($id)
    {
        $collection = Auth::user()->collections()
            ->with(['artworks.user', 'artworks.category', 'artworks.likes'])
            ->findOrFail($id);
            
        return view('member.collections.show', compact('collection'));
    }
    
    public function edit($id)
    {
        $collection = Auth::user()->collections()->findOrFail($id);
        $userArtworks = Auth::user()->artworks()->latest()->get();
        
        return view('member.collections.edit', compact('collection', 'userArtworks'));
    }
    
    public function update(Request $request, $id)
    {
        $collection = Auth::user()->collections()->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
            'artwork_ids' => 'nullable|array',
            'artwork_ids.*' => 'exists:artworks,id'
        ]);
        
        $collection->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_public' => $request->is_public ?? false,
        ]);
        
        // Sync artworks if provided
        if ($request->has('artwork_ids')) {
            $collection->artworks()->sync($request->artwork_ids);
            
            // Update cover image
            if ($firstArtwork = $collection->artworks()->first()) {
                $collection->update(['cover_image' => $firstArtwork->image_url]);
            }
        }
        
        return redirect()->route('member.collections.show', $collection->id)
            ->with('success', 'Collection updated successfully!');
    }
    
    public function destroy($id)
    {
        $collection = Auth::user()->collections()->findOrFail($id);
        $collection->delete();
        
        return redirect()->route('member.collections.index')
            ->with('success', 'Collection deleted successfully!');
    }
    
    public function addArtwork(Request $request, $id)
    {
        $collection = Auth::user()->collections()->findOrFail($id);
        
        $request->validate([
            'artwork_id' => 'required|exists:artworks,id'
        ]);
        
        $collection->artworks()->syncWithoutDetaching([$request->artwork_id]);
        
        return response()->json([
            'success' => true,
            'message' => 'Artwork added to collection!'
        ]);
    }
    
    public function removeArtwork($id, $artworkId)
    {
        $collection = Auth::user()->collections()->findOrFail($id);
        $collection->artworks()->detach($artworkId);
        
        return response()->json([
            'success' => true,
            'message' => 'Artwork removed from collection!'
        ]);
    }
}