<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Group;
use App\Models\GroupChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $onlineStatus = [];
        $timeoutMinutes = 5;
        $allUsers = User::with('adminInformation', 'alumniInformation')->pluck('id')->toArray();

        foreach ($allUsers as $id) {
            $session = \DB::table('sessions')->where('user_id', $id)->first();
            if ($session && isset($session->last_activity)) {
                $lastActivity = \Carbon\Carbon::createFromTimestamp($session->last_activity);
                $onlineStatus[$id] = $lastActivity->diffInMinutes(now()) < $timeoutMinutes;
            } else {
                $onlineStatus[$id] = false;
            }
        }

        $data = [
            'user' => Auth::user(),
            'users' => User::with('adminInformation', 'alumniInformation')->get(),
            'onlineStatus' => $onlineStatus
        ];
        return view('messages.index', $data);
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
            $request->validate([
                'receiver_id' => 'required',
                'is_group' => 'required|string',
            ]);

            if ($request->is_group === "true") {
                GroupChat::create([
                    'sent_by' => Auth::id(),
                    'group_id' => $request->receiver_id,
                    'message' => $request->message
                ]);
            } else {
                Chat::create([
                    'sent_by' => Auth::id(),
                    'received_by' => $request->receiver_id,
                    'message' => $request->message
                ]);
            }

            return response()->json([
                'message' => 'Successfully added message',
            ], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to add message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Group $group)
    {
        $onlineStatus = [];
        $timeoutMinutes = 5;
        $allUsers = User::with('adminInformation', 'alumniInformation')->pluck('id')->toArray();

        foreach ($allUsers as $id) {
            $session = \DB::table('sessions')->where('user_id', $id)->first();
            if ($session && isset($session->last_activity)) {
                $lastActivity = \Carbon\Carbon::createFromTimestamp($session->last_activity);
                $onlineStatus[$id] = $lastActivity->diffInMinutes(now()) < $timeoutMinutes;
            } else {
                $onlineStatus[$id] = false;
            }
        }

        if ($group->id) {
            $myGroups = Auth::user()->groups;
            $managedGroups = Auth::user()->groupsManaged;

            $allowedGroups = $myGroups->merge($managedGroups);
            $allowedGroupIds = $allowedGroups->pluck('id');

            if ($allowedGroupIds->contains($group->id)) {
                $user->load(['alumniInformation', 'adminInformation']);

                $data = [
                    'isGroup' => $group->id ? 'true' : 'false',
                    'chatId' => $group->id,
                    'user' => Auth::user(),
                    'group' => $group,
                    'receiver' => $user,
                    'users' => User::with('adminInformation', 'alumniInformation')->get(),
                    'onlineStatus' => $onlineStatus
                ];

                return view('messages.show', $data);
            } else {
                return redirect()->route('messages.index')->with('error', 'You are not allowed to access this group.');
            }
        } else {
            $user->load(['alumniInformation', 'adminInformation']);

            $data = [
                'isGroup' => $group->id ? true : false,
                'chatId' => $group->id ? $group->id : $user->id,
                'user' => Auth::user(),
                'group' => $group,
                'receiver' => $user,
                'users' => User::with('adminInformation', 'alumniInformation')->get(),
                'onlineStatus' => $onlineStatus
            ];
            return view('messages.show', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
