@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-4 bg-white">
        <div class="mx-auto md:p-4 sm:p-0">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center mb-4">
                Events
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                @if ($events->isNotEmpty())
                    <a class="lg:col-span-2" href="{{ route('events.show', ['post' => $events[0]->id]) }}">
                        <div class="relative">
                            <img src="{{ asset('storage/posts/thumbnails/' . $events[0]->event->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $events[0]->event->title }}" class="w-full h-96 object-cover rounded-md shadow-lg">
                            <div class="absolute bottom-0 bg-black bg-opacity-50 text-white p-4 w-full">
                                <span class="text-red-500 font-bold">Latest</span>
                                <h2 class="text-xl font-semibold">{{ $events[0]->event->title }}</h2>
                                <p class="text-sm flex items-center gap-2 rounded-md shadow-sm px-2 py-1 w-max my-1 text-gray-800 bg-white border border-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($events[0]->event->start_date)->format('F j, Y') }}
                                </p>
                                <p class="text-sm">{{ \Carbon\Carbon::parse($events[0]->event->created_at)->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endif

                <div class="grid grid-cols-1 gap-4">
                    @forelse ($events->slice(1, 2) as $event)
                        <a class="flex border border-gray-300 rounded-md p-4" href="{{ route('events.show', ['post' => $event->id]) }}">
                            <img src="{{ asset('storage/posts/thumbnails/' . $event->event->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $event->event->title }}" class="w-36 h-36 object-cover rounded-md shadow-lg mr-4">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $event->event->title }}</h3>
                                <p class="text-sm flex items-center gap-2 rounded-md shadow-sm px-2 py-1 w-max my-1 text-gray-800 bg-white border border-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($event->event->start_date)->format('F j, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($event->event->created_at)->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-600">No additional events available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mx-auto md:p-4 sm:p-0">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($events->slice(3) as $event)
                    <a class="flex mb-4 border border-gray-300 rounded-md p-4" href="{{ route('events.show', ['post' => $event->id]) }}">
                        <img src="{{ asset('storage/posts/thumbnails/' . $event->event->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $event->event->title }}" class="w-36 h-36 object-cover rounded-md shadow-lg mr-4">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $event->event->title }}</h3>
                            <p class="text-sm flex items-center gap-2 rounded-md shadow-sm px-2 py-1 w-max my-1 text-gray-800 bg-white border border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($event->event->start_date)->format('F j, Y') }}
                            </p>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($event->event->created_at)->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                @endforelse
            </div>
        </div>

    </div>
@endsection
