<?php

namespace App\Livewire;

use App\Models\Chat;
use App\Models\GroupChat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatsHide extends Component
{
    public function render()
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

        $userIds = $chatHeads->pluck('sent_by')->merge($chatHeads->pluck('received_by'))->unique();
        $onlineStatus = [];
        $timeoutMinutes = 5;

        foreach ($userIds as $userId) {
            $session = \DB::table('sessions')->where('user_id', $userId)->first();
            if ($session && isset($session->last_activity)) {
                $lastActivity = \Carbon\Carbon::createFromTimestamp($session->last_activity);
                $onlineStatus[$userId] = $lastActivity->diffInMinutes(now()) < $timeoutMinutes;
            } else {
                $onlineStatus[$userId] = false;
            }
        }


        return view('livewire.chatshide', [
            'chats' => $mergedChats ?? [],
            'onlineStatus' => $onlineStatus,
        ]);
    }
}
