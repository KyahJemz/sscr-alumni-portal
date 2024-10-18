@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red">
                Edit User Hobbies Section
            </h2>
            <form method="post" action="{{ route('user-hobbies.update', ['user_id' => $user->id]) }}" class="space-y-6">
                @csrf
                @method('patch')

                <div id="saved-user-hobbies-container" class="space-y-4">
                    <h3 class="text-md font-semibold text-gray-700">Hobbies:</h3>
                    @forelse ($userHobbies as $userHobby)
                        <div class="hobby-group flex items-center gap-2">
                            <button type="button" class="remove-button text-sscr-red py-2 rounded-md text-sm hover:text-red-600"
                                onclick="removeSavedHobby(this, '{{ $userHobby->hobbies_id }}', '{{ $hobbies->find($userHobby->hobbies_id)->name }}')">
                                @include('components.icons.x')
                            </button>
                            <div class="text-gray-700 text-md font-medium">{{ $hobbies->find($userHobby->hobbies_id)->name }}</div>
                            -
                            <div class="text-gray-700 text-xs font-light italic">{{ $hobbies->find($userHobby->hobbies_id)->description }}</div>
                            <input type="hidden" name="hobbies_id[]" value="{{ $userHobby->hobbies_id }}">
                        </div>
                    @empty
                        <p class="text-sm text-gray-600 dark:text-gray-400">No hobbies added yet.</p>
                    @endforelse
                    @foreach ($userHobbies as $userHobby)
                        <input type="hidden" name="user_hobby_ids[]" value="{{ $userHobby->hobbies_id }}">
                    @endforeach
                </div>

                <div id="add-new-hobby-container" class="mt-6">
                    <h3 class="text-md font-semibold text-gray-700">Add New Hobby:</h3>
                    <div class="new-hobby-group flex items-center space-x-4">
                        <select name="hobbies_id[]" id="new_hobbies_id"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sscr-red focus:border-sscr-red sm:text-sm">
                            <option value="" disabled selected>Select Hobby</option>
                            @foreach ($hobbies as $hobby)
                                @if (!$userHobbies->contains('hobbies_id', $hobby->id))
                                    <option value="{{ $hobby->id }}">{{ $hobby->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="button" id="add-hobby"
                            class="add-button flex items-center whitespace-nowrap gap-2 text-sscr-red border border-sscr-red px-4 py-2 rounded-md text-sm hover:bg-sscr-red hover:text-white transition">
                            @include('components.icons.add') Add Hobby
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <button type="submit"
                        class="bg-sscr-red text-white py-2 px-4 rounded-md shadow-sm hover:bg-sscr-red-dark focus:outline-none focus:ring-2 focus:ring-sscr-red focus:ring-opacity-50">
                        {{ __('Save') }}
                    </button>
                    @if (session('status') || session('error'))
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ session('status') ?? session('error') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('add-hobby').addEventListener('click', function() {
            const container = document.getElementById('saved-user-hobbies-container');
            const selectElement = document.getElementById('new_hobbies_id');
            const selectedHobbyText = selectElement.options[selectElement.selectedIndex].text;
            const selectedHobbyId = selectElement.value;

            if (!selectedHobbyId) {
                alert('Please select a hobby to add.');
                return;
            }

            const newHobbyGroup = document.createElement('div');
            newHobbyGroup.className = 'hobby-group flex items-center gap-2 mt-4';
            newHobbyGroup.innerHTML = `
                <button type="button" class="remove-button text-sscr-red py-2 rounded-md text-sm hover:text-red-600" onclick="removeSavedHobby(this, '${selectedHobbyId}', '${selectedHobbyText}')">
                    @include('components.icons.x')
                </button>
                <div class="text-gray-700 text-md font-medium">${selectedHobbyText}</div>
                <input type="hidden" name="hobbies_id[]" value="${selectedHobbyId}">
            `;

            container.appendChild(newHobbyGroup);
            removeOptionFromSelect(selectedHobbyId);
            selectElement.selectedIndex = 0;
        });

        function removeOptionFromSelect(hobbyId) {
            const selectElement = document.getElementById('new_hobbies_id');
            const options = Array.from(selectElement.options);
            const optionToRemove = options.find(option => option.value === hobbyId);

            if (optionToRemove) {
                optionToRemove.remove();
            }
        }

        function removeSavedHobby(button, hobbyId, hobbyName) {
            const container = document.getElementById('saved-user-hobbies-container');
            container.removeChild(button.parentElement);
            addOptionToSelect(hobbyId, hobbyName);
        }

        function addOptionToSelect(hobbyId, hobbyName) {
            const selectElement = document.getElementById('new_hobbies_id');
            const newOption = document.createElement('option');
            newOption.value = hobbyId;
            newOption.textContent = hobbyName;

            selectElement.appendChild(newOption);
        }
    </script>
@endsection
