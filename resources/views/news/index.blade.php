@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-4 bg-white">

        <div class="mx-auto md:p-4 sm:p-0">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center mb-4">
                News
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                @if ($news->isNotEmpty())
                    <a class="lg:col-span-2" href="{{ route('news.show', ['post' => $news[0]->id]) }}">
                        <div class="relative">
                            <img src="{{ asset('storage/posts/thumbnails/' . $news[0]->news->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $news[0]->news->title }}" class="w-full h-96 object-cover rounded-md shadow-lg">
                            <div class="absolute bottom-0 bg-black bg-opacity-50 text-white p-4 w-full">
                                <span class="text-red-500 font-bold">Latest</span>
                                <h2 class="text-xl font-semibold">{{ $news[0]->news->title }}</h2>
                                <p class="text-sm">{{ \Carbon\Carbon::parse($news[0]->news->created_at)->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endif

                <div class="grid grid-cols-1 gap-4">
                    @forelse ($news->slice(1, 2) as $newsItem)
                        <a class="flex border border-gray-300 rounded-md p-4" href="{{ route('news.show', ['post' => $newsItem->id]) }}">
                            <img src="{{ asset('storage/posts/thumbnails/' . $newsItem->news->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $newsItem->news->title }}" class="w-36 h-36 object-cover rounded-md shadow-lg mr-4">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $newsItem->news->title }}</h3>
                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($newsItem->news->created_at)->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-600">No additional news available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mx-auto md:p-4 sm:p-0">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($news->slice(3) as $newsItem)
                    <a class="flex mb-4 border border-gray-300 rounded-md p-4" href="{{ route('news.show', ['post' => $newsItem->id]) }}">
                        <img src="{{ asset('storage/posts/thumbnails/' . $newsItem->news->thumbnail) }}" onerror="this.onerror=null;this.src='{{ asset('storage/posts/thumbnails/default.jpg') }}';" alt="{{ $newsItem->news->title }}" class="w-36 h-36 object-cover rounded-md shadow-lg mr-4">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $newsItem->news->title }}</h3>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($newsItem->news->created_at)->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                @endforelse
            </div>
        </div>

    </div>
@endsection
