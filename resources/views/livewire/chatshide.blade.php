<div wire:poll>
    @forelse ($chats as $chat)
        @if($chat->group)
            <a href="{{ route('messages.show', ['user' => Auth::user()->id, 'group' => $chat->group->id]) }}" class="w-full bg-white dark:bg-gray-700 p-2 rounded-lg flex items-center gap-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 relative">
                <img class="w-10 h-10 rounded-full object-cover bg-gray-300"
                    src="{{ asset('storage/groups/images/' . ($chat->group->image ?? 'default.jpg')) }}" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';" alt="Person 1">
                <svg class="absolute left-2 bottom-2" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 20 20">
                    <circle cx="10" cy="10" r="10" fill="green"/>
                </svg>
            </a>
        @else
            <a href="{{ route('messages.show', ['user' => ($chat->sent_by === Auth::user()->id) ? $chat->receiver->id : $chat->sender->id]) }}" class="w-full bg-white dark:bg-gray-700 p-2 rounded-lg flex items-center gap-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 relative">
                @if ($chat->sent_by === Auth::user()->id)
                    <img class="w-10 h-10 rounded-full object-cover bg-gray-300"
                        src="{{ asset('storage/profile/images/' . ($chat->receiver->image ?? 'default.jpg')) }}" onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';" alt="Person 1">
                    @if(isset($onlineStatus[$chat->received_by]) && $onlineStatus[$chat->received_by])
                        <svg class="absolute left-2 bottom-2" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="10" fill="green"/>
                        </svg>
                    @endif
                @else
                    <img class="w-10 h-10 rounded-full object-cover bg-gray-300"
                        src="{{ asset('storage/profile/images/' . ($chat->sender->image ?? 'default.jpg')) }}" onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';" alt="Person 1">
                    @if(isset($onlineStatus[$chat->sent_by]) && $onlineStatus[$chat->sent_by])
                        <svg class="absolute left-2 bottom-2" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="10" fill="green"/>
                        </svg>
                    @endif
                @endif
            </a>
        @endif
    @empty
        <p></p>
    @endforelse
</div>
