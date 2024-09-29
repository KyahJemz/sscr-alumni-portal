<h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex justify-between items-center mb-4">
    <p>About</p>
    <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="text-gray-800 font-bold py-2 px-4 rounded">
        @include('components.icons.edit')
    </a>
</h2>

<div class="">
    <div class="md:col-span-2 pt-4">
        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">Profile Image</p>
            <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}" alt="{{ $group->name }}" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';" class="w-32 h-32 object-cover mb-4">
        </div>

        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">Group Name</p>
            <h3 class="text-xl font-bold text-gray-800">{{ $group->name }}</h3>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm font-semibold text-gray-700 mb-2">Description</p>
            <p class="text-gray-600">{{ $group->description }}</p>
        </div>
    </div>

    <div class="md:col-span-2 border-t border-gray-300 pt-2 mt-4">
        <p class="text-sm font-semibold text-gray-700">History</p>
        <p class="text-gray-600">Founded: {{ $group->created_at->format('F j, Y') }}</p>
        <p class="text-gray-600">Last Modified: {{ $group->updated_at->format('F j, Y') }}</p>
    </div>

    <div class="md:col-span-2 border-t border-gray-300 pt-2 mt-4">
        <p class="text-sm font-semibold text-gray-700">Summary</p>
        <div class="grid grid-cols-2 gap-4 mt-2">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12a4 4 0 01-8 0 4 4 0 018 0zm0 0a4 4 0 004 4h0a4 4 0 000-8h0a4 4 0 00-4 4zm5 0a4 4 0 014 4h0a4 4 0 000-8h0a4 4 0 00-4 4z" />
                </svg>
                <p class="text-gray-600">Total Members: {{ $group->total_members }}</p>
            </div>

            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v5a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 0v5m0 0h16M3 9v11a1 1 0 001 1h16a1 1 0 001-1V9m-9 4v4" />
                </svg>
                <p class="text-gray-600">Total Posts: {{ $group->total_posts }}</p>
            </div>

            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2h6v2a4 4 0 010 8h-6a4 4 0 01-6 0v-2h16v2" />
                </svg>
                <p class="text-gray-600">Total Events: {{ $group->total_events }}</p>
            </div>

            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20a4 4 0 01-4 4H7a4 4 0 01-4-4V10a4 4 0 014-4h6a4 4 0 014 4v10z" />
                </svg>
                <p class="text-gray-600">Total News: {{ $group->total_news }}</p>
            </div>

            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-700 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l4-4m0 0l4 4m-4-4v12" />
                </svg>
                <p class="text-gray-600">Total Announcements: {{ $group->total_announcements }}</p>
            </div>
        </div>
    </div>
</div>
