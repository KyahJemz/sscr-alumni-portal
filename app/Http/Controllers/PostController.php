<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Group;
use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = [
            'user' => $user,
        ];
        return view('posts.index', $data);
    }
    public function apiIndex()
    {
        $posts = Post::with(['likes.user', 'comments.user.adminInformation', 'comments.user.alumniInformation', 'comments.deletedBy', 'postedBy.alumniInformation', 'postedBy.adminInformation', 'approvedBy', 'rejected_by', 'event', 'announcement', 'news'])
                ->where('group_id', null)
                ->whereNull('deleted_at')
                ->whereNotNull('approved_at')
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
            DB::beginTransaction();

            $user = Auth::user();

            $thumbnail = null;
            $imagePaths = [];
            $videosPaths = [];
            $filesPaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $imageName = 'i_' . $originalName . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/posts/images', $imageName);
                    $imagePaths[] = $imageName;
                }
            }
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    $originalName = pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME);
                    $videoName = 'v_' . $originalName . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                    $video->storeAs('public/posts/videos', $videoName);
                    $videosPaths[] = $videoName;
                }
            }
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = 'f_' . $originalName . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/posts/files', $fileName);
                    $filesPaths[] = $fileName;
                }
            }
            if ($request->hasFile('thumbnail')) {
                $thumbnailFile = $request->file('thumbnail');
                $originalName = pathinfo($thumbnailFile->getClientOriginalName(), PATHINFO_FILENAME);
                $thumbnailName = 't_' . $originalName . '_' . uniqid() . '.' . $thumbnailFile->getClientOriginalExtension();
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
                        'contributions' => 'nullable|string',
                        'amount' => 'nullable|string',
                    ]);
                    $event = Event::create([
                        'title' => $request->title,
                        'description' => $request->description,
                        'location' => $request->location,
                        'url' => $request->url,
                        'start_date' => $request->startDate,
                        'end_date' => $request->endDate,
                        'status' => 'active',
                        'thumbnail' => $thumbnail,
                        'contribution' => $request->contributions,
                        'amount' => $request->amount,
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
                'approved_by' => (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator') ? $user->id : null,
                'approved_at' => (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator') ? Carbon::now('Asia/Manila') : null,
                'group_id' => null,
                'event_id' => $event ? $event->id : null,
                'news_id' => $news ? $news->id : null,
                'announcement_id' => $announcement ? $announcement->id : null,
                'content' => $request->content ?? null,
                'images' => json_encode($imagePaths),
                'files' => json_encode($filesPaths),
                'videos' => json_encode($videosPaths),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Post created successfully with media.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        return view('posts.show', $data);
    }

    public function apiShow(string $id)
    {
        $data = [
            'post' => Post::with(['likes.user', 'comments.user.adminInformation', 'comments.user.alumniInformation', 'comments.deletedBy', 'postedBy.alumniInformation', 'postedBy.adminInformation', 'approvedBy', 'rejected_by', 'event', 'announcement', 'news'])->where('group_id', null)->where('id', $id)->first(),
        ];
        return response()->json([
            'data' => $data,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, Group $group)
    {
        if($post) {
            $data = [
                'user' => Auth::user(),
                'post' => Post::with(['postedBy.alumniInformation', 'postedBy.adminInformation', 'event', 'announcement', 'news'])->where('id', $post->id)->first(),
            ];
        }
        // dd($data);
        return view('posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Group $group)
{

    try {
        DB::beginTransaction();

        $imagePaths = [];
        $videosPaths = [];
        $filesPaths = [];
        $thumbnail = null;
        $isImagesChanged = $request->images_current !== $post->images;
        $isVideosChanged = $request->videos_current !== $post->videos;
        $isFilesChanged = $request->files_current !== $post->files;
        $isThumbnailChanged = false;
        $existingThumbnail = null;
        if ($post->type === 'news') {
            $existingThumbnail = $post->news->thumbnail;
            $isThumbnailChanged = $request->thumbnail_current !== optional($post->news)->thumbnail;
        } elseif ($post->type === 'event') {
            $existingThumbnail = $post->event->thumbnail;
            $isThumbnailChanged = $request->thumbnail_current !== optional($post->event)->thumbnail;
        } elseif ($post->type === 'announcement') {
            $existingThumbnail = $post->announcement->thumbnail;
            $isThumbnailChanged = $request->thumbnail_current !== optional($post->announcement)->thumbnail;
        }
        $thumbnailToSave = $isThumbnailChanged ? $thumbnail : $existingThumbnail;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = 'i_' . $originalName . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/posts/images', $imageName);
                $imagePaths[] = $imageName;
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $originalName = pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME);
                $videoName = 'v_' . $originalName . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                $video->storeAs('public/posts/videos', $videoName);
                $videosPaths[] = $videoName;
            }
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = 'f_' . $originalName . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/posts/files', $fileName);
                $filesPaths[] = $fileName;
            }
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $originalName = pathinfo($thumbnailFile->getClientOriginalName(), PATHINFO_FILENAME);
            $thumbnailName = 't_' . $originalName . '_' . uniqid() . '.' . $thumbnailFile->getClientOriginalExtension();
            $thumbnailFile->storeAs('public/posts/thumbnails', $thumbnailName);
            $thumbnailToSave = $thumbnailName;
        }

        switch ($post->type) {
            case 'event':
                $request->validate([
                    'startDate' => 'nullable|date',
                    'endDate' => 'nullable|date',
                    'location' => 'nullable|string',
                    'description' => 'required|string',
                    'title' => 'required|string',
                    'contributions' => 'nullable|string',
                    'amount' => 'nullable|string',
                ]);
                $startDate = $request->startDate ? Carbon::createFromFormat('Y-m-d\TH:i', $request->startDate)->format('Y-m-d H:i:s') : null;
                $endDate = $request->endDate ? Carbon::createFromFormat('Y-m-d\TH:i', $request->endDate)->format('Y-m-d H:i:s') : null;

                if (!$endDate || $endDate === '1970-01-01 00:00:00') {
                    $endDate = null;
                }
                $post->event()->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'location' => $request->location,
                    'url' => $request->url,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                    'thumbnail' => $thumbnailToSave,
                    'contribution' => $request->contributions,
                    'amount' => $request->amount,
                ]);
                break;

            case 'announcement':
                $request->validate([
                    'description' => 'required|string',
                    'title' => 'required|string',
                ]);

                $post->announcement()->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'thumbnail' => $thumbnailToSave,
                ]);
                break;

            case 'news':
                $request->validate([
                    'description' => 'required|string',
                    'title' => 'required|string',
                ]);

                $post->news()->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'thumbnail' => $thumbnailToSave,
                ]);
                break;
        }

        $post->update([
            'content' => $request->content ?? $post->content,
            'images' => ((count($imagePaths) !== 0) ? json_encode($imagePaths) : ($isImagesChanged ? json_encode([]) : $post->images)),
            'videos' => ((count($videosPaths) !== 0) ? json_encode($videosPaths) : ($isVideosChanged ? json_encode([]) : $post->videos)),
            'files' => ((count($filesPaths) !== 0) ? json_encode($filesPaths) : ($isFilesChanged ? json_encode([]) : $post->files)),
        ]);

        DB::commit();

        return redirect()->back()->with('status', 'Post updated successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Post Update Error: ' . $e->getMessage());

        return redirect()->back()->with('status', 'Something went wrong. Please try again.');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function apiDestroy(Post $post)
    {
        $post->deleted_by = Auth::user()->id;
        $post->save();

        $post->delete();

        return response()->json([
            'message' => 'Post successfully deleted',
        ], 200);
    }

}
