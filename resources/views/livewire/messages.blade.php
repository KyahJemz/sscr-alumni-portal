<div id="messages-container" wire:poll class="flex-grow space-y-2 overflow-y-auto scrollbar-hide bg-white flex-col-reverse justify-end">
    @if ($messages->isEmpty())
        <p>No messages found.</p>
    @else
        @foreach ($messages as $message)
            @if ($message->sent_by === Auth::id())
                <div class="flex items-start justify-end">
                    <div class="ml-2 bg-sscr-red text-white px-3 py-2 rounded-lg max-w-md">
                        <p class="text-sm" title="{{ $message->created_at->format('M. j, Y \a\t g:ia') }}">{{ $message->message }}</p>
                    </div>
                </div>
            @else
                <div class="flex items-start">
                    <img class="w-10 h-10 rounded-full" src="{{ asset('storage/profile/images/' . ($message->sender->image ?? 'default.jpg')) }}" onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';" alt="User Avatar">
                    <div class="ml-2 bg-gray-200 dark:bg-gray-700 px-3 py-2 rounded-lg max-w-md">
                        <p class="text-xs font-light text-gray-500">
                            {{ optional($message->sender->alumniInformation)->first_name
                                ? optional($message->sender->alumniInformation)->first_name . ' ' . optional($message->sender->alumniInformation)->last_name
                                : (optional($message->sender->adminInformation)->first_name
                                    ? optional($message->sender->adminInformation)->first_name . ' ' . optional($message->sender->adminInformation)->last_name
                                    : 'Unknown') }}
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-300" title="{{ $message->created_at->format('M. j, Y \a\t g:ia') }}">{{ $message->message }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
