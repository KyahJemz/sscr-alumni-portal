@extends('master')

@section('content')

    <div class="container mx-auto max-w-7xl sm:p-2 md:p-6 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    Alumni Organization Clubs
                </h2>
                @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
                    <button onclick="document.getElementById('add-group-modal').classList.toggle('hidden');"
                        class="text-sm items-center transition duration-150 ease-in-out flex gap-1 text-white bg-sscr-red hover:bg-sscr-red/80 active:bg-sscr-red/60 border border-sscr-red px-3 py-1 rounded">
                        @include('components.icons.add')Add New
                    </button>
                @endif
            </div>


            <div class="flex justify-center">
                <input type="text" id="search-bar" placeholder="Search Clubs..."
                    class="w-full sm:w-1/2 px-4 py-2 border rounded-md shadow-sm focus:ring-sscr-red focus:border-sscr-red"
                    oninput="filterClubs()" />
            </div>

            @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
            <div>
                <h2 class="text-xl font-semibold text-gray-800">All Clubs</h2>
                <div id="recommended-clubs" class="flex flex-wrap justify-around items-center gap-4 py-4">
                    @forelse ($recommended as $group)
                        <a data-name="{{$group->name}}" href="{{ route('groups.show', ['group' => $group->id]) }}" class="flex flex-col items-center bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-50 group-card flex-shrink-0 w-80 h-max">
                            <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}"
                                onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';"
                                alt="{{ $group->name }}" class="h-44 w-full object-cover rounded-t-lg">
                            <div class="flex flex-col px-4 py-2 w-full">
                                <p class="group-name text-sm font-bold text-gray-700">{{ $group->name }}</p>
                                <p class="text-sm font-medium text-gray-700">{{ $group->group_members->whereNotNull('approved_at')->whereNull('deleted_at')->count() + $group->group_admins->whereNull('deleted_at')->count() }} members * {{ $group->posts->whereNotNull('approved_at')->whereNull('deleted_at')->count() }} posts</p>
                                <p class="text-sm font-light text-gray-400">Founded: {{ $group->created_at->format('F j, Y') }}</p>
                            </div>
                        </a>
                    @empty
                        <p>No clubs</p>
                    @endforelse
                </div>
            </div>


            @else
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">My Clubs</h2>
                    <div id="my-clubs" class="flex flex-row gap-4 overflow-x-auto py-4">
                        @forelse ($myGroupsMerged as $group)
                            <a data-name="{{$group->name}}" href="{{ route('groups.show', ['group' => $group->id]) }}" class="flex flex-col items-center bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-50 group-card flex-shrink-0 w-80 h-max">
                                <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}"
                                    onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';"
                                    alt="{{ $group->name }}" class="h-44 w-full object-cover rounded-t-lg">
                                <div class="flex flex-col px-4 py-2 w-full">
                                    <p class="group-name text-md font-bold text-gray-700">{{ $group->name }}</p>
                                    <p class="text-sm font-medium text-gray-700">{{ $group->group_members->whereNotNull('approved_at')->whereNull('deleted_at')->count() + $group->group_admins->whereNull('deleted_at')->count() }} members * {{ $group->posts->whereNotNull('approved_at')->whereNull('deleted_at')->count() }} posts</p>
                                    <p class="text-sm font-light text-gray-400">Founded: {{ $group->created_at->format('F j, Y') }}</p>
                                </div>
                            </a>
                        @empty
                            <a href="#"
                                class="flex flex-col items-center bg-white border border-gray-300 rounded-lg p-4 shadow-md hover:bg-gray-50 flex-shrink-0 w-48">
                                Join some groups
                            </a>
                        @endforelse
                    </div>
                </div>

                @if($suggested)
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Suggested Clubs</h2>
                        <div id="suggested-clubs" class="flex flex-row gap-4 overflow-x-auto py-4">
                            @forelse ($suggested as $group)
                                <a data-name="{{$group->name}}" href="{{ route('groups.show', ['group' => $group->id]) }}" class="flex flex-col items-center bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-50 group-card flex-shrink-0 w-80 h-max">
                                    <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}"
                                        onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';"
                                        alt="{{ $group->name }}" class="h-44 w-full object-cover rounded-t-lg">
                                    <div class="flex flex-col px-4 py-2 w-full">
                                        <p class="group-name text-md font-bold text-gray-700">{{ $group->name }}</p>
                                        <p class="text-sm font-medium text-gray-700">{{ $group->group_members->whereNotNull('approved_at')->whereNull('deleted_at')->count() + $group->group_admins->whereNull('deleted_at')->count() }} members * {{ $group->posts->whereNotNull('approved_at')->whereNull('deleted_at')->count() }} posts</p>
                                        <p class="text-sm font-light text-gray-400">Founded: {{ $group->created_at->format('F j, Y') }}</p>
                                    </div>
                                </a>
                            @empty
                                <a href="#"
                                    class="flex flex-col items-center bg-white border border-gray-300 rounded-lg p-4 shadow-md hover:bg-gray-50 flex-shrink-0 w-48">
                                    Join some groups
                                </a>
                            @endforelse
                        </div>
                    </div>
                @endif

                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Other Clubs</h2>
                    <div id="recommended-clubs" class="flex flex-row gap-4 overflow-x-auto py-4">
                        @forelse ($recommended as $group)
                            <a data-name="{{$group->name}}" href="{{ route('groups.show', ['group' => $group->id]) }}" class="flex flex-col items-center bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-50 group-card flex-shrink-0 w-80 h-max">
                                <img src="{{ asset('storage/groups/images/' . $group->image ?? 'default.jpg') }}"
                                    onerror="this.onerror=null;this.src='{{ asset('storage/groups/images/default.jpg') }}';"
                                    alt="{{ $group->name }}" class="h-44 w-full object-cover rounded-t-lg">
                                <div class="flex flex-col px-4 py-2 w-full">
                                    <p class="group-name text-sm font-bold text-gray-700">{{ $group->name }}</p>
                                    <p class="text-sm font-medium text-gray-700">{{ $group->group_members->whereNotNull('approved_at')->whereNull('deleted_at')->count() + $group->group_admins->whereNull('deleted_at')->count() }} members * {{ $group->posts->whereNotNull('approved_at')->whereNull('deleted_at')->count() }} posts</p>
                                    <p class="text-sm font-light text-gray-400">Founded: {{ $group->created_at->format('F j, Y') }}</p>
                                </div>
                            </a>
                        @empty
                            <a href="#"
                                class="flex flex-col items-center bg-white border border-gray-300 rounded-lg p-4 shadow-md hover:bg-gray-50 flex-shrink-0 w-48">
                                No groups to join
                            </a>
                        @endforelse
                    </div>
                </div>
            @endif

        </div>
    </div>

    @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
        <div id="add-group-modal"
            class="hidden fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div id="send-feedback-form"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                <form action="{{ route('groups.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2
                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 flex justify-between items-center">
                        Add Club Form
                        <button type="button"
                            onclick="document.getElementById('add-group-modal').classList.toggle('hidden');"
                            class="text-sscr-red">
                            @include('components.icons.x')
                        </button>
                    </h2>

                    <div class="flex flex-row gap-4">
                        <div class="flex w-max flex-col items-start">
                            <img id="image-preview" src="{{ asset('storage/groups/images/default.jpg') }}"
                                alt="Group Image"
                                class="rounded-md w-32 h-32 border border-gray-300 dark:border-gray-700 mb-4">
                            <input id="image-upload" class="hidden block cursor-pointer w-32" type="file" name="image"
                                accept="image/png, image/jpeg" />
                            <button type="button" class="flex"
                                onclick="document.getElementById('image-upload').click();">@include('components.icons.image')&nbsp;
                                Upload Image</button>
                        </div>

                        <div class="flex flex-col flex-1 space-y-4">
                            <div>
                                <label for="name" class="text-sm font-semibold text-gray-700 dark:text-gray-200">Club
                                    Name</label>
                                <input id="name" type="text" name="name"
                                    class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm"
                                    required>
                            </div>
                            <div>
                                <label for="admins"
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-200">Admins</label>
                                <input list="alumni-list" onchange="handleAdminSelection(event)"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm h-12" />
                                <datalist id="alumni-list">
                                    @foreach ($alumni_list as $alumni)
                                        <option value="{{ $alumni->id }}">
                                            {{ $alumni->alumniInformation->first_name . ' ' . $alumni->alumniInformation->last_name }}
                                        </option>
                                    @endforeach
                                </datalist>
                                <div id="admin-list"
                                    class="flex flex-col gap-2 mt-2 border border-gray-300 dark:border-gray-700 rounded-md">
                                </div>
                                <input id="admin_ids" type="text" class="hidden" name="admin_ids">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="description"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-200">Description</label>
                        <textarea id="description" name="description" required
                            class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100" rows="4"
                            placeholder="Enter club description..."></textarea>
                    </div>

                    <div class="mt-6">
                        <input type="submit"
                            class="w-full bg-sscr-red text-white font-light py-2 px-4 rounded-md cursor-pointer hover:bg-red-600 transition duration-150"
                            value="Create Club">
                    </div>
                </form>
            </div>
        </div>
    @endif

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

    @if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator')
        <script>
            let admins = [];
            const alumniList = @json($alumni_list).map(alumni => {
                return {
                    id: alumni.id,
                    name: alumni.alumni_information.first_name + ' ' + (alumni.alumni_information.middle_name ? alumni
                        .alumni_information.middle_name + ' ' : '') + alumni.alumni_information.last_name
                };
            });

            document.getElementById('image-upload').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('image-preview').src = e.target.result;
                        document.getElementById('image-preview').style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            function handleAdminSelection(e) {

                const selectedAlumni = alumniList.find(alumni => alumni.id == e.target.value);

                if (selectedAlumni && !admins.includes(selectedAlumni.id)) {
                    admins.push(selectedAlumni.id);

                    let adminList = document.getElementById('admin-list');
                    adminList.innerHTML += `
                    <div id="admin-${selectedAlumni.id}" class="flex justify-between items-center p-2">
                        ${selectedAlumni.name}
                        <button type="button" class="text-red-500 ml-2" onclick="removeAdmin(${selectedAlumni.id})">X</button>
                    </div>
                `;
                }

                document.getElementById('admin_ids').value = JSON.stringify(admins);
                e.target.value = '';
            }

            function removeAdmin(adminId) {
                admins = admins.filter(id => id !== adminId);

                let adminElement = document.getElementById(`admin-${adminId}`);
                if (adminElement) {
                    adminElement.remove();
                }
                document.getElementById('admin_ids').value = JSON.stringify(admins);
            }
        </script>
    @endif
@endsection
