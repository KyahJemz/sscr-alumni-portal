<div wire:poll>
    @forelse ($chats as $chat)
        @if($chat->group)
            <a href="{{ route('messages.show', ['user' => Auth::user()->id, 'group' => $chat->group->id]) }}" class="w-full bg-white dark:bg-gray-700 p-2 rounded-lg flex items-center gap-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                <img class="w-10 h-10 rounded-full object-cover bg-gray-300"
                    src="{{ asset('storage/groups/images/' . ($chat->group->image ?? 'default.jpg')) }}" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';" alt="Person 1">
            </a>
        @else
            <a href="{{ route('messages.show', ['user' => ($chat->sent_by === Auth::user()->id) ? $chat->receiver->id : $chat->sender->id]) }}" class="w-full bg-white dark:bg-gray-700 p-2 rounded-lg flex items-center gap-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                @if ($chat->sent_by === Auth::user()->id)
                <img class="w-10 h-10 rounded-full object-cover bg-gray-300"
                    src="{{ asset('storage/profile/images/' . ($chat->receiver->image ?? 'default.jpg')) }}" onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';" alt="Person 1">
                @else
                <img class="w-10 h-10 rounded-full object-cover bg-gray-300"
                    src="{{ asset('storage/profile/images/' . ($chat->sender->image ?? 'default.jpg')) }}" onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';" alt="Person 1">
                @endif
            </a>
        @endif
    @empty
        <p></p>
    @endforelse
</div>
