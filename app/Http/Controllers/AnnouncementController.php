<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'announcements' => Post::with(['postedBy', 'announcement'])->has('announcement')->whereNull('group_id')->whereNull('deleted_at')->whereNotNull('approved_at')->whereNull('rejected_at')->orderBy('created_at', 'desc')->get(),
            'latest_news' => Post::with(['postedBy', 'news'])->has('news')->whereNull('group_id')->whereNull('deleted_at')->whereNotNull('approved_at')->whereNull('rejected_at')->orderBy('created_at', 'desc')->first(),
            'latest_event' => Post::with(['postedBy', 'event'])->has('event')->whereNull('group_id')->whereNull('deleted_at')->whereNotNull('approved_at')->whereNull('rejected_at')->orderBy('created_at', 'desc')->first(),
        ];
        return view('announcements.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user = Auth::user();
        if($post) {
            $data = [
                'user' => $user,
                'post_id' => $post->id,
            ];
        }
        return view('posts.show-custom', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
