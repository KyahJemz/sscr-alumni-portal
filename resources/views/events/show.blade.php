@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-4 bg-white">

        <div class="container mx-auto p-4">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center mb-4">
                Events
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                @if ($events->isNotEmpty())
                    <a class="lg:col-span-2" href="{{ route('events.show', ['post' => $events[0]->id]) }}">
                        <div class="relative">
                            <img src="{{ asset('storage/posts/thumbnails/' . $events[0]->events->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $events[0]->events->title }}" class="w-full h-96 object-cover rounded-md shadow-lg">
                            <div class="absolute bottom-0 bg-black bg-opacity-50 text-white p-4 w-full">
                                <span class="text-red-500 font-bold">Latest</span>
                                <h2 class="text-xl font-semibold">{{ $events[0]->events->title }}</h2>
                                <p class="text-sm">{{ \Carbon\Carbon::parse($events[0]->approved_at, 'Asia/Manila')->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endif

                <div class="grid grid-cols-1 gap-4">
                    @forelse ($events->slice(1, 2) as $events)
                        <a class="flex border border-gray-300 rounded-md p-4" href="{{ route('events.show', ['post' => $events->id]) }}">
                            <img src="{{ asset('storage/posts/thumbnails/' . $events->events->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $events->events->title }}" class="w-36 h-36 object-cover rounded-md shadow-lg mr-4">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $events->events->title }}</h3>
                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($events->approved_at, 'Asia/Manila')->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-600">No additional events available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="container mx-auto p-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                @forelse ($events->slice(3) as $events)
                    <a class="flex mb-4 border border-gray-300 rounded-md p-4" href="{{ route('events.show', ['post' => $events->id]) }}">
                        <img src="{{ asset('storage/posts/thumbnails/' . $events->events->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $events->events->title }}" class="w-36 h-36 object-cover rounded-md shadow-lg mr-4">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $events->events->title }}</h3>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($events->approved_at, 'Asia/Manila')->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                @endforelse
            </div>
        </div>

    </div>
@endsection
