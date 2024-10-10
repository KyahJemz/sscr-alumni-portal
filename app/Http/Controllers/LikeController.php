<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
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
                'post_id' => 'required|exists:posts,id',
            ]);

            $existingLike = Like::withTrashed()->where('liked_by', Auth::user()->id)->where('post_id',  $request->post_id)->first();

            if ($existingLike) {
                if ($existingLike->trashed()) {
                    $existingLike->restore();
                } else {
                    return response()->json([
                        'message' => 'Successfully added like',
                    ], 201);
                }
            } else {
                Like::create([
                    'liked_by' => Auth::user()->id,
                    'post_id' => $request->post_id,
                ]);
            }
            return response()->json([
                'message' => 'Successfully added like',
            ], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to add like',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apiDestroy(Request $request)
    {
        try {
            $request->validate([
                'post_id' => 'required|exists:posts,id',
            ]);

            Like::where('liked_by', Auth::user()->id)->where('post_id', $request->post_id)->delete();

            return response()->json([
                'message' => 'Like successfully deleted',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Like not found',
            ], 404);
        }
    }
}
