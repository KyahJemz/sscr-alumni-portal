<div wire:poll>
    @forelse ($chats as $chat)
        @if($chat->group)
            <a href="{{ route('messages.show', ['user' => Auth::user()->id, 'group' => $chat->group->id]) }}" class="w-full bg-white dark:bg-gray-700 p-2 rounded-lg flex items-center gap-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                <img class="w-10 h-10 rounded-full object-cover bg-gray-300"
                    src="{{ asset('storage/groups/images/' . ($chat->group->image ?? 'default.jpg')) }}" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';" alt="Person 1">
                <div class="flex flex-col w-full ">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $chat->group->name }}
                    </p>
                    <div class="text-xs text-gray-500 dark:text-gray-400 flex justify-between w-full {{ ($chat->sent_by === Auth::user()->id) ? 'font-light' : ($chat->read_at ? 'font-light' : 'font-black text-black') }}">
                        <p class="truncate">
                            @if ($chat->sent_by === Auth::user()->id)
                                you: {{ $chat->message }}
                            @else
                                {{ optional($chat->sender->alumniInformation)->first_name ?? optional($chat->sender->adminInformation)->first_name ?? ''}}: {{ $chat->message }}
                            @endif
                        </p>
                        <p class="w-max whitespace-nowrap text-xs italic">{{ $chat->created_at->diffForHumans() }}</p>
                    </div>
                </div>
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
                <div class="flex flex-col w-full ">
                    @if ($chat->sent_by === Auth::user()->id && $chat->received_by === Auth::user()->id)
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">You</p>
                    @else
                        @if ($chat->sent_by === Auth::user()->id)
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                {{ optional($chat->receiver->alumniInformation)->first_name
                                    ? optional($chat->receiver->alumniInformation)->first_name . ' ' . optional($chat->receiver->alumniInformation)->last_name
                                    : (optional($chat->receiver->adminInformation)->first_name
                                        ? optional($chat->receiver->adminInformation)->first_name . ' ' . optional($chat->receiver->adminInformation)->last_name
                                        : 'Unknown') }}
                            </p>
                        @else
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                {{ optional($chat->sender->alumniInformation)->first_name
                                    ? optional($chat->sender->alumniInformation)->first_name . ' ' . optional($chat->sender->alumniInformation)->last_name
                                    : (optional($chat->sender->adminInformation)->first_name
                                        ? optional($chat->sender->adminInformation)->first_name . ' ' . optional($chat->sender->adminInformation)->last_name
                                        : 'Unknown') }}
                            </p>
                        @endif
                    @endif
                    <div class="text-xs text-gray-500 dark:text-gray-400 flex justify-between w-full {{ ($chat->sent_by === Auth::user()->id) ? 'font-light' : ($chat->read_at ? 'font-light' : 'font-black text-black') }}">
                        <p class="truncate">
                            @if ($chat->sent_by === Auth::user()->id)
                                you: {{ $chat->message }}
                            @else
                                {{ optional($chat->sender->alumniInformation)->first_name ?? optional($chat->sender->adminInformation)->first_name ?? ''}}: {{ $chat->message }}
                            @endif
                        </p>
                        <p class="w-max whitespace-nowrap text-xs italic">{{ $chat->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </a>
        @endif
    @empty
        <p>No messages found, try socializing.</p>
    @endforelse
</div>
