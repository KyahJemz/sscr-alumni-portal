<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Notification;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Group $group)
    {
        if ($group->id) {
            return view('posts.approvals.group.index', ['group' => $group]);
        } else {
            return view('posts.approvals.index', []);
        }
    }

    public function apiIndex(Group $group)
    {
        if ($group->id) {
            $posts = Post::with(['postedBy.alumniInformation', 'postedBy.adminInformation', 'event', 'announcement', 'news'])
                ->where('group_id', $group->id)
                ->whereNull('deleted_at')
                ->whereNull('approved_at')
                ->whereNull('rejected_at')
                ->orderBy('created_at', 'desc')
                ->get();
            $data = [
                'posts' => $posts,
            ];
            return response()->json([
                'data' => $data,
            ], 200);
        } else {
            $posts = Post::with(['postedBy.alumniInformation', 'postedBy.adminInformation', 'event', 'announcement', 'news'])
                ->where('group_id', null)
                ->whereNull('deleted_at')
                ->whereNull('approved_at')
                ->whereNull('rejected_at')
                ->orderBy('created_at', 'desc')
                ->get();
            $data = [
                'posts' => $posts,
            ];
            return response()->json([
                'data' => $data,
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function apiUpdate(Request $request, Post $post, Group $group)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);
        if ($group->id) {
            if ($request->status === 'approved') {
                $post->update([
                    'approved_at' => Carbon::now('Asia/Manila'),
                    'approved_by' => Auth::user()->id,
                ]);
                Notification::create([
                    'user_id' => $post->created_by,
                    'type' => 'group',
                    'content' => "Your post has been approved in the group " . $group->name,
                    'url' => "/group/{$group->id}/posts/{$post->id}",
                ]);
            } else {
                $post->update([
                    'rejected_at' => Carbon::now('Asia/Manila'),
                    'rejected_by' => Auth::user()->id,
                ]);
                Notification::create([
                    'user_id' => $post->created_by,
                    'type' => 'group',
                    'content' => "Your post has been rejected in the group " . $group->name,
                    'url' => null,
                ]);
            }
            $post->save();
            return response()->json([
                'message' => 'Post status updated successfully',
            ], 200);
        } else {
            if ($request->status === 'approved') {
                $post->update([
                    'approved_at' => Carbon::now('Asia/Manila'),
                    'approved_by' => Auth::user()->id,
                ]);
                Notification::create([
                    'user_id' => $post->created_by,
                    'type' => 'post',
                    'content' => "Your post has been approved",
                    'url' => "/posts/{$post->id}",
                ]);
            } else {
                $post->update([
                    'rejected_at' => Carbon::now('Asia/Manila'),
                    'rejected_by' => Auth::user()->id,
                ]);
                Notification::create([
                    'user_id' => $post->created_by,
                    'type' => 'post',
                    'content' => "Your post has been rejected",
                    'url' => null,
                ]);
            }
            $post->save();
            return response()->json([
                'message' => 'Post status updated successfully',
            ], 200);
        }
    }
}
