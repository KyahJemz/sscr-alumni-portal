<?php

namespace App\Livewire;

use App\Models\Chat;
use App\Models\GroupChat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Messages extends Component
{
    public $messageContent;

    public $receiverId;
    public $isGroup;

    public function mount($receiverId, $isGroup = false)
    {
        $this->receiverId = $receiverId;
        $this->isGroup = $isGroup;
    }


    public function render()
    {

        if ($this->isGroup) {
            $messages = GroupChat::with(['sender', 'group', 'deletedBy'])->where('group_id', $this->receiverId)
                ->get();
            GroupChat::where('group_id', $this->receiverId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        } else {
            $messages = Chat::with(['sender', 'receiver', 'deletedBy'])->where(function($query) {
                $query->where('sent_by', Auth::id())
                      ->where('received_by', $this->receiverId);
                })
                ->orWhere(function($query) {
                    $query->where('sent_by', $this->receiverId)
                        ->where('received_by', Auth::id());
                })
                ->orderBy('created_at', 'asc')
                ->get();

            Chat::where(function($query) {
                $query->where('sent_by', Auth::id())
                      ->where('received_by', $this->receiverId);
                })
                ->orWhere(function($query) {
                    $query->where('sent_by', $this->receiverId)
                        ->where('received_by', Auth::id());
                })
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return view('livewire.messages', ['messages' => $messages]);
    }
}
