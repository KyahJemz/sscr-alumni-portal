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

            $sanitizedMessage = $this->filterMessage($request->message);

            if ($request->is_group === "true") {
                GroupChat::create([
                    'sent_by' => Auth::id(),
                    'group_id' => $request->receiver_id,
                    'seen' => json_encode([Auth::id()]),
                    'message' => $sanitizedMessage
                ]);
            } else {
                Chat::create([
                    'sent_by' => Auth::id(),
                    'received_by' => $request->receiver_id,
                    'seen' => json_encode([Auth::id()]),
                    'message' => $sanitizedMessage
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

    private function filterMessage($message)
    {
        // words suggested by chat gpt
        $bannedWords = [
            'bobo', 'obob', 'tanga', 'gago', 'gaga', 'ulol', 'tarantado', 'lintik',
            'tangina', 'puta',
            'putangina', 'pakyu', 'inutil', 'siraulo', 'leche', 'hayop',
            'bwisit', 'hindot', 'kantot', 'titi', 'pekpek', 'puta', 'punyeta',
            'tae', 'utang', 'kupal', 'ampotangina', 'putragis', 'putres',
            'taragis', 'ungas'
        ];

        // words suggested by chat gpt
        $bannedWords = array_merge($bannedWords, [
            'fuck', 'shit', 'bitch', 'asshole', 'bastard', 'dick',
            'pussy', 'cunt', 'fucker', 'motherfucker', 'crap', 'jerk',
            'damn', 'slut', 'whore', 'prick', 'cock', 'wanker', 'twat',
            'bollocks', 'arsehole', 'douche', 'dumbass', 'faggot', 'retard'
        ]);

        foreach ($bannedWords as $word) {
            $pattern = "/\b" . preg_quote($word, '/') . "\b/i";
            $replacement = str_repeat('*', strlen($word));

            $message = preg_replace($pattern, $replacement, $message);

            $patternFlexible = "/(?<=\w)" . preg_quote($word, '/') . "(?=\w)/i";
            $message = preg_replace($patternFlexible, $replacement, $message);
        }
        return $message;
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

                $chats = GroupChat::where('group_id', $group->id)->get();

                foreach ($chats as $chat) {
                    $seen = json_decode($chat->seen, true) ?? [];

                    if (!in_array(Auth::id(), $seen)) {
                        $seen[] = Auth::id();
                        $chat->update(['seen' => json_encode($seen)]);
                    }
                }

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

            $chats = Chat::where(function ($query) use ($user) {
                $query->orWhere('sent_by', $user->id)
                      ->orWhere('received_by', $user->id);
            })->get();

            foreach ($chats as $chat) {
                $seen = json_decode($chat->seen, true) ?? [];

                if (!in_array(Auth::id(), $seen)) {
                    $seen[] = Auth::id();
                    $chat->update(['seen' => json_encode($seen)]);
                }
            }

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
