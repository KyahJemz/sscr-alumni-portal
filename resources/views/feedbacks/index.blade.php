@extends('master')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
        <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
            User Feedback
        </h2>
        <div class="flex flex-row gap-4 flex-1 w-full justify-center">
            <div class="flex flex-col px-10 items-end w-1/3">
                <div class="flex flex-col items-center">
                    <p class="ms-1 font-bold text-md text-gray-500 mb-6 ">Ratings and Reviews</p>
                    <p class="ms-1 font-bold text-sscr-red text-5xl">{{ $total }}</p>
                    <p class="ms-1 font-bold text-md text-gray-500">out of 5</p>
                </div>
            </div>
            <div class="flex flex-col w-2/3">
                <div class="flex items-center mt-4">
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">5 star</a>
                    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
                        <div class="h-5 bg-sscr-red rounded" style="width: {{ $ratings['4']['percentage'] }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $ratings['4']['percentage'] }}%</span>
                </div>
                <div class="flex items-center mt-4">
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">4 star</a>
                    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
                        <div class="h-5 bg-sscr-red rounded" style="width: {{ $ratings['3']['percentage'] }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $ratings['3']['percentage'] }}%</span>
                </div>
                <div class="flex items-center mt-4">
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">3 star</a>
                    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
                        <div class="h-5 bg-sscr-red rounded" style="width: {{ $ratings['2']['percentage'] }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $ratings['2']['percentage'] }}%</span>
                </div>
                <div class="flex items-center mt-4">
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">2 star</a>
                    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
                        <div class="h-5 bg-sscr-red rounded" style="width: {{ $ratings['1']['percentage'] }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $ratings['1']['percentage'] }}%</span>
                </div>
                <div class="flex items-center mt-4">
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">1 star</a>
                    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
                        <div class="h-5 bg-sscr-red rounded" style="width: {{ $ratings['0']['percentage'] }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $ratings['0']['percentage'] }}%</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4">
            @forelse ($feedbacks as $feedback)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex gap-4">
                        <img class="w-12 h-12 rounded-full object-cover" src="{{ asset('storage/profile/images') }}/{{ $feedback->user->image }}" alt="User Image">
                        <div>
                            <div class="text-md font-semibold">{{ $feedback->user->alumniInformation->first_name }} {{ $feedback->user->alumniInformation->middle_name }} {{ $feedback->user->alumniInformation->last_name }} {{ $feedback->user->alumniInformation->suffix }}</div>
                            <div class="text-gray-500 font-light text-xs">Date: {{ $feedback->created_at->format('M. j, Y \a\t g:ia') }}</div>
                            <span class="inline-block bg-yellow-500 text-sscr-red py-1 text-sm font-semibold flex items-center">
                                Rating:
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $feedback->rating)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke-width="1.5" class="size-4"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>
                                    @endif
                                @endfor
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm">{{ $feedback->feedback }}</p>
                </div>
            @empty
                <p class="text-gray-700 text-sm">No feedback yet.</p>
            @endforelse
        </div>









    </div>
</div>
@endsection
