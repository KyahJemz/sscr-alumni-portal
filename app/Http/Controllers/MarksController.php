<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\GroupChat;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class MarksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function markNotificationRead()
    {
        Notification::where('user_id', Auth::user()->id)->update(['is_read' => 1]);
        return response()->json(['success' => true]);
    }
    public function getMessagesMark()
    {
        $myGroups = Auth::user()->groups;
        $managedGroups = Auth::user()->groupsManaged;

        $allowedGroups = $myGroups->merge($managedGroups);

        $allowedGroupIds = $allowedGroups->pluck('id');

        $groupChatHeads = GroupChat::with(['sender.alumniInformation', 'sender.adminInformation', 'group'])
            ->whereIn('group_id', $allowedGroupIds)
            ->latest('created_at')
            ->get()
            ->unique('group_id');

        $chatHeads = Chat::with(['sender.alumniInformation', 'sender.adminInformation', 'receiver.alumniInformation', 'receiver.adminInformation'])
            ->where(function ($query) {
                $query->where('sent_by', Auth::id())
                    ->orWhere('received_by', Auth::id());
            })
            ->latest('created_at')
            ->get()
            ->unique(function ($chat) {
                return $chat->sent_by == Auth::id() ? $chat->received_by : $chat->sent_by;
            });

        $mergedChats = $groupChatHeads->merge($chatHeads)->sortByDesc('created_at');

        $hasMessage = false;

        foreach ($mergedChats as $chat) {
            if (collect(json_decode($chat->seen))->contains(Auth::user()->id)) {

            } else {
                $hasMessage = true;
                break;
            }
        }

        return response()->json([
            'hasMessage' => $hasMessage,
        ]);
    }
}
