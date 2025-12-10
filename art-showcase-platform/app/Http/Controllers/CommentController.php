<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Artwork $artwork)
    {
        $request->validate([
            'content' => 'required|string|min:3|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        try {
            DB::beginTransaction();

            $comment = $artwork->comments()->create([
                'user_id' => Auth::id(),
                'content' => $request->content,
                'parent_id' => $request->parent_id,
            ]);

            // Increment comment count
            $artwork->incrementComments();

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'comment' => $comment->load('user'),
                    'message' => 'Comment added successfully.'
                ]);
            }

            return back()->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add comment.'
                ], 500);
            }

            return back()->with('error', 'Failed to add comment.');
        }
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, Comment $comment)
    {
        // Authorization check
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
            'edited_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment,
                'message' => 'Comment updated successfully.'
            ]);
        }

        return back()->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Request $request, Comment $comment)
    {
        // Authorization check
        $this->authorize('delete', $comment);

        $artwork = $comment->artwork;
        
        try {
            DB::beginTransaction();

            // Decrement comment count from artwork
            if ($artwork && !$comment->parent_id) { // Only decrement for top-level comments
                $artwork->decrementComments();
            }

            $comment->delete();

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Comment deleted successfully.'
                ]);
            }

            return back()->with('success', 'Comment deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete comment.'
                ], 500);
            }

            return back()->with('error', 'Failed to delete comment.');
        }
    }

    /**
     * Reply to a comment.
     */
    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $reply = $comment->replies()->create([
                'user_id' => Auth::id(),
                'artwork_id' => $comment->artwork_id,
                'content' => $request->content,
                'parent_id' => $comment->id,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'reply' => $reply->load('user'),
                    'message' => 'Reply added successfully.'
                ]);
            }

            return back()->with('success', 'Reply added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add reply.'
                ], 500);
            }

            return back()->with('error', 'Failed to add reply.');
        }
    }

    /**
     * Like/unlike a comment.
     */
    public function like(Request $request, Comment $comment)
    {
        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Check if user already liked the comment
            $existingLike = $comment->likes()->where('user_id', $user->id)->first();

            if ($existingLike) {
                // Unlike
                $existingLike->delete();
                $liked = false;
                $message = 'Comment unliked.';
            } else {
                // Like
                $comment->likes()->create(['user_id' => $user->id]);
                $liked = true;
                $message = 'Comment liked.';
            }

            // Update like count
            $comment->like_count = $comment->likes()->count();
            $comment->save();

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'liked' => $liked,
                    'likes_count' => $comment->like_count,
                    'message' => $message
                ]);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process like.'
                ], 500);
            }

            return back()->with('error', 'Failed to process like.');
        }
    }
}