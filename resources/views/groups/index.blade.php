@extends('master')

@section('content')

<div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
        <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
            Alumni Organization Clubs
        </h2>

        <div class="flex justify-center">
            <input type="text" id="search-bar" placeholder="Search Clubs..." class="w-full sm:w-1/2 px-4 py-2 border rounded-md shadow-sm focus:ring-sscr-red focus:border-sscr-red" oninput="filterClubs()" />
        </div>

        <div>
            <h2 class="text-xl font-semibold text-gray-800">My Clubs</h2>
            <div id="my-clubs" class="flex flex-row space-x-4 overflow-x-auto py-4">
                @forelse  ($myGroups as $group)
                    <a href="{{ route('groups.show', ['group' => $group->id]) }}" class="flex flex-col items-center bg-white border border-gray-300 rounded-lg p-4 shadow-md hover:bg-gray-50 group-card" data-name="{{ $group->name }}">
                        <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';" alt="{{ $group->name }}" class="w-24 h-24 rounded-full object-cover mb-2">
                        <p class="text-sm font-medium text-gray-700">{{ $group->name }}</p>
                    </a>
                    @empty
                    <a href="#" class="flex flex-col items-center bg-white border border-gray-300 rounded-lg p-4 shadow-md hover:bg-gray-50">
                        Join some groups
                    </a>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold text-gray-800">Other Clubs</h2>
            <div id="recommended-clubs" class="flex flex-row space-x-4 overflow-x-auto py-4">
                @forelse ($recommended as $group)
                    <a href="{{ route('groups.show', ['group' => $group->id]) }}" class="flex flex-col items-center bg-white border border-gray-300 rounded-lg p-4 shadow-md hover:bg-gray-50 group-card" data-name="{{ $group->name }}">
                        <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}" onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';" alt="{{ $group->name }}" class="w-24 h-24 rounded-full object-cover mb-2">
                        <p class="text-sm font-medium text-gray-700">{{ $group->name }}</p>
                    </a>
                    @empty
                    <a href="#" class="flex flex-col items-center bg-white border border-gray-300 rounded-lg p-4 shadow-md hover:bg-gray-50">
                        No groups to join
                    </a>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    function filterClubs() {
        let searchValue = document.getElementById('search-bar').value.toLowerCase();

        let clubCards = document.querySelectorAll('.group-card');

        clubCards.forEach(function(card) {
            let clubName = card.getAttribute('data-name').toLowerCase();
            if (clubName.includes(searchValue)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

        if (searchValue === '') {
            clubCards.forEach(function(card) {
                card.style.display = 'flex';
            });
        }
    }
</script>

@endsection
