@extends('master')

@section('content')
    <div class="container my-6 mx-auto p-6 max-w-7xl bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center mb-4">
                Hobbies Management
            </h2>
            <div class="mb-4">
                <button onclick="openAddHobbyModal()" class="bg-sscr-red text-xs text-white px-4 py-2 rounded">Add New Hobby</button>
            </div>
        </div>
        <div id="hobby-list">
        </div>
    </div>

    <div id="add-hobby-modal" class="fixed inset-0 bg-gray-700 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Add New Hobby</h3>
            <form id="add-hobby-form" onsubmit="addHobby(event)" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="hobby-name" class="block text-gray-700 text-sm font-semibold">Hobby Name</label>
                    <input type="text" name="name" id="hobby-name" class="p-2 text-xs border border-gray-300 rounded w-full" required>
                </div>
                <div class="mb-4">
                    <label for="hobby-description" class="block text-gray-700 text-sm font-semibold">Description</label>
                    <textarea id="hobby-description" name="description" class="p-2 text-xs  border border-gray-300 rounded w-full" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="hobby-category" class="block text-gray-700 text-sm font-semibold">Category</label>
                    <input type="text" id="hobby-category" name="category" class="p-2 text-xs border border-gray-300 rounded w-full" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeAddHobbyModal()" class="bg-gray-500 text-sm text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" class="bg-sscr-red text-white px-4 py-2 text-sm rounded">Add Hobby</button>
                </div>
            </form>
        </div>
    </div>

    <div id="group-modal" class="fixed inset-0 bg-gray-700 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700" id="modal-hobby-name">Groups for Hobby</h3>
            <div class="flex justify-between items-center">
                <select type="text" id="add-group-select" onchange="groupSelectionChanged(event)" placeholder="Enter group name" class="p-2 border border-gray-300 rounded w-full mr-2  text-sm ">
                    <option value="">Select Group...</option>
                    @forelse ($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @empty
                        <option value="">No groups found</option>
                    @endforelse
                </select>
                <button onclick="addGroupToHobby()" id="add-group-btn" class="bg-sscr-red text-white text-sm px-4 py-2 whitespace-nowrap rounded">Add Group</button>
            </div>
            <p id="new-group-error" class="hidden text-sscr-red text-xs">group is already in the list.</p>
            <ul id="group-list" class="my-4">
            </ul>
            <button onclick="closeModal()" class="mt-4 bg-gray-500 text-sm  text-white px-4 py-2 rounded">Close</button>
        </div>
    </div>

    <div id="hobby-edit-modal" class="fixed inset-0 bg-gray-700 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-700" id="edit-modal-hobby-name">Edit Hobby</h3>
            <form id="update-hobby-form" onsubmit="updateHobby(event)" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="edit-hobby-name" class="block text-gray-700 text-sm font-semibold">Hobby Name</label>
                    <input type="text" name="name" id="edit-hobby-name" class="p-2 text-xs border border-gray-300 rounded w-full" required>
                </div>
                <div class="mb-4">
                    <label for="edit-hobby-description" class="block text-gray-700 text-sm font-semibold">Description</label>
                    <textarea name="description" id="edit-hobby-description" class="p-2 text-xs  border border-gray-300 rounded w-full" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="edit-hobby-category" class="block text-gray-700 text-sm font-semibold">Category</label>
                    <input type="text" name="category" id="edit-hobby-category" class="p-2 text-xs border border-gray-300 rounded w-full" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="mt-4 bg-gray-500 text-sm  text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="mt-4 bg-sscr-red text-sm text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let hobbies = [];
        const groups = @json($groups);
        let selectedHobby = null;

        function groupSelectionChanged (e) {
            const note = document.getElementById('new-group-error');
            const btn = document.getElementById('add-group-btn');
            const groupId = e.target.value;
            console.log(groupId);
            if (!groupId || !selectedHobby) {
                return;
            }
            if (groupId) {
                const hobbyGroups = selectedHobby.groups;
                if (hobbyGroups && hobbyGroups.find(group => +group.id === +groupId)) {
                    note.classList.remove('hidden');
                    btn.disabled = true;
                    console.log("true");
                } else {
                    note.classList.add('hidden');
                    btn.disabled = false;
                    console.log("false");
                }
            }
        }

        function layoutHobbies(hobbies = []) {
            const hobbyList = document.getElementById('hobby-list');
            hobbyList.innerHTML = '';

            let categories = {};

            hobbies.forEach(hobby => {
                if (!categories[hobby.category]) {
                    categories[hobby.category] = [];
                }
                categories[hobby.category].push(hobby);
            });

            for (const category in categories) {
                let categorySection = document.createElement('div');
                categorySection.classList.add('mb-6');
                categorySection.innerHTML = `<h3 class="text-md border-t-2 pt-1 font-semibold text-gray-700 mb-4">${category}</h3>`;

                let hobbyCards = document.createElement('div');
                hobbyCards.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-6');

                categories[category].forEach(hobby => {
                    let hobbyData = JSON.stringify(hobby);
                    let hobbyCard = document.createElement('div');
                    hobbyCard.classList.add('border', 'border-gray-200', 'p-4', 'rounded', 'shadow-sm', 'hover:shadow-md', 'transition', 'flex', 'items-center', 'space-x-4');

                    hobbyCard.innerHTML = `
                        <div class="flex-grow">
                            <h4 class="text-md font-semibold text-gray-800">${hobby.name}</h4>
                            <p class="text-sm text-gray-600">${hobby.description}</p>
                            <div class="flex justify-between mt-2">
                                <button onclick="openModal(${hobby.id})" class="text-sscr-red text-xs mt-2">Manage Groups</button>
                                <button onclick="openEditModal(${hobby.id})" class="text-sscr-red text-xs mt-2">Edit</button>
                            </div>
                        </div>
                    `;

                    hobbyCards.appendChild(hobbyCard);
                });

                categorySection.appendChild(hobbyCards);
                hobbyList.appendChild(categorySection);
            }
        }

        function openModal(hobbyId) {
            const modal = document.getElementById('group-modal');
            const hobby = hobbies.find(hobby => hobby.id === hobbyId);
            selectedHobby = hobby;
            document.getElementById('modal-hobby-name').innerText = `Groups for ${hobby.name}`;

            const groupList = document.getElementById('group-list');
            groupList.innerHTML = '';

            hobby.groups && hobby.groups.forEach(group => {
                let groupItem = document.createElement('li');
                groupItem.classList.add('flex', 'justify-between', 'items-center', 'mb-2');
                groupItem.innerHTML = `
                    <span class="text-gray-700 px-6">${group.name}</span>
                    <button onclick="removeGroupFromHobbyConfirmation(${hobby.id}, ${group.id})" class="text-sscr-red text-xs">Remove</button>
                `;
                groupList.appendChild(groupItem);
            });

            modal.classList.remove('hidden');
        }

        function openEditModal(hobbyId) {
            const modal = document.getElementById('hobby-edit-modal');
            const hobby = hobbies.find(hobby => hobby.id === hobbyId);
            selectedHobby = hobby;
            document.getElementById('edit-modal-hobby-name').innerText = `Editing ${hobby.name}`;
            document.getElementById('edit-hobby-name').value = hobby?.name ?? "";
            document.getElementById('edit-hobby-description').value = hobby?.description ?? "";
            document.getElementById('edit-hobby-category').value = hobby?.category ?? "";

            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('hobby-edit-modal');
            modal.classList.add('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('group-modal');
            modal.classList.add('hidden');
        }

        function openAddHobbyModal() {
            document.getElementById('add-hobby-modal').classList.remove('hidden');
        }

        function closeAddHobbyModal() {
            document.getElementById('add-hobby-modal').classList.add('hidden');
        }

        async function addHobby(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const url = "{{ route('api.hobbies.store') }}";
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                alertModal(json.message);
                e.target.reset();
                closeAddHobbyModal();
                fetchHobbies();
            } catch (error) {
                alertModal(error.message);
                console.error(error.message);
            }
        }

        async function updateHobby(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append("_method", "PATCH");
            const url = "/api/hobbies/"+selectedHobby.id;
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                alertModal(json.message);
                closeEditModal();
                fetchHobbies();
            } catch (error) {
                alertModal(error.message);
                closeEditModal();
                console.error(error.message);
            }
        }

        function removeHobbyConfirmation(id) {
            confirmation('Are you sure you want to delete this hobby?', () => removeHobby(id));
        }

        async function addGroupToHobby() {
            const selectedGroupId = document.getElementById('add-group-select').value;

            if (!selectedGroupId) {
                alertModal('Please select a group');
                return;
            }

            const formData = new FormData();
            formData.append('group_id', selectedGroupId);
            formData.append('hobby_id', selectedHobby.id);
            const url = "{{ route('api.group-hobbies.store') }}";
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                alertModal(json.message);
                document.getElementById('add-group-select').value = '';
                closeModal();
                fetchHobbies();
            } catch (error) {
                alertModal(error.message);
                console.error(error.message);
            }
        }

        async function removeHobby(id) {
            const formData = new FormData();
            formData.append("_method", "DELETE");
            const url = "/api/hobbies/"+id;
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                alertModal(json.message);
                fetchHobbies();
            } catch (error) {
                alertModal(error.message);
                console.error(error.message);
            }
        }

        function removeGroupFromHobbyConfirmation(hobbyId, groupId) {
            confirmation('Are you sure you want to remove this group from this hobb?', () => removeGroupFromHobby(hobbyId, groupId));
        }

        async function removeGroupFromHobby(hobbyId, groupId) {
            const formData = new FormData();
            formData.append('group_id', groupId);
            formData.append('hobby_id', hobbyId);
            formData.append("_method", "DELETE");
            const url = "{{ route('api.group-hobbies.destroy') }}";
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                alertModal(json.message);
                closeModal();
                fetchHobbies();
            } catch (error) {
                closeModal();
                alertModal(error.message);
                console.error(error.message);
            }
        }

        async function fetchHobbies() {
            const url = "{{ route('api.hobbies.index') }}";

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const json = await response.json();
                hobbies = json.hobbies;
                console.log(json);
                layoutHobbies(json.hobbies);
            } catch (error) {
                console.error('Error fetching posts:', error.message);
            }
        }

        fetchHobbies();
    </script>
@endsection
{{-- async function sendLike(e) {
    e.preventDefault();
    const likeBox = e.target.querySelector('.like');
    const formData = new FormData(e.target);
    const url = "{{ route('api.like.store') }}";
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content')
            }
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        likeBox.innerHTML = `@include('components.icons.heart-filled')`;
        getPosts();
    } catch (error) {
        console.error(error.message);
    }
}

async function deleteLike(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append("_method", "DELETE");
    const url = "{{ route('api.like.destroy') }}";
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content')
            }
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        getPosts();
    } catch (error) {
        console.error(error.message);
    }
} --}}
