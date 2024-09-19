<?php

namespace App\Http\Controllers;

use App\Models\announcement;
use App\Models\Event;
use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $data = [
            'posts' => Post::all()->sortByDesc('created_at'),
            'user' => $user,
        ];
        return view('posts.index', $data);
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
        try {
            $user = Auth::user();

            $thumbnail = null;
            $imagePaths = [];
            $videosPaths = [];
            $filesPaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = 'i_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/posts/images', $imageName);
                    $imagePaths[] = $imageName;
                }
            }
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    $videoName = 'v_' . time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                    $video->storeAs('public/posts/videos', $videoName);
                    $videosPaths[] = $videoName;
                }
            }
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = 'f_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/posts/files', $fileName);
                    $filesPaths[] = $fileName;
                }
            }
            if ($request->hasFile('thumbnail')) {
                $thumbnailFile = $request->file('thumbnail');
                $thumbnailName = 't_' . time() . '_' . uniqid() . '.' . $thumbnailFile->getClientOriginalExtension();
                $thumbnailFile->storeAs('public/posts/thumbnails', $thumbnailName);
                $thumbnail = $thumbnailName;
            }

            $event = null;
            $announcement = null;
            $news = null;

            switch ($request->type) {
                case 'event':
                    $request->validate([
                        'startDate' => 'nullable|date',
                        'endDate' => 'nullable|date',
                        'location' => 'nullable|string',
                        'description' => 'required|string',
                        'title' => 'required|string',
                    ]);
                    $event = Event::create([
                        'title' => $request->title,
                        'description' => $request->description,
                        'location' => $request->location,
                        'start_date' => $request->startDate,
                        'end_date' => $request->endDate,
                        'status' => 'active',
                        'thumbnail' => $thumbnail,
                    ]);
                    break;

                case 'announcement':
                    $request->validate([
                        'description' => 'required|string',
                        'title' => 'required|string',
                    ]);
                    $announcement = Announcement::create([
                        'title' => $request->title,
                        'description' => $request->description,
                        'thumbnail' => $thumbnail,
                    ]);
                    break;

                case 'news':
                    $request->validate([
                        'description' => 'required|string',
                        'title' => 'required|string',
                    ]);
                    $news = News::create([
                        'title' => $request->title,
                        'description' => $request->description,
                        'thumbnail' => $thumbnail,
                    ]);
                    break;

                default:
                    $request->validate([
                        'type' => 'required|string',
                        'content' => 'nullable|string',
                    ]);
                    break;
            }

            Post::create([
                'type' => $request->type,
                'created_by' => $user->id,
                'approved_by' => null,
                'approved_at' => null,
                'group_id' => null,
                'event_id' => $event ? $event->id : null,
                'news_id' => $news ? $news->id : null,
                'announcement_id' => $announcement ? $announcement->id : null,
                'content' => $request->content ?? null,
                'images' => json_encode($imagePaths),
                'files' => json_encode($filesPaths),
                'videos' => json_encode($videosPaths),
            ]);

            return redirect()->back()->with('success', 'Post created successfully with media.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
