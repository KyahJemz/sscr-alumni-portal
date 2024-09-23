<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'comment' => 'required',
                'post_id' => 'required|exists:posts,id',
            ]);

            Comment::create([
                'post_id' => $request->post_id,
                'commented_by' => Auth::user()->id,
                'deleted_by' => null,
                'content' => $request->comment,
            ]);

            return response()->json([
                'message' => 'Successfully added comment',
            ], 201);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to add comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apiDestroy(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $comment = Comment::find($request->comment_id);

        if ($comment) {
            $comment->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $comment->delete();

            return response()->json([
                'message' => 'Comment successfully deleted'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Comment not found',
            ], 404);
        }
    }
}
