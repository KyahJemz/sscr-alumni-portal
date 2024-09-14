@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                Edit User Hobbies Section
            </h2>
            <form method="post" action="{{ route('user-hobbies.update', ['user_id' => $user->id]) }}" class=" space-y-6">
                @csrf
                @method('patch')

                <div id="edit-user-hobbies-container">
                    @foreach ($userHobbies as $userHobby)
                        <div class="mb-4 hobby-group flex items-center">
                            <label for="hobbies_id_{{ $userHobby->id }}" class="block text-gray-700 font-medium mb-1">Select
                                Hobby:</label>
                            <select name="hobbies_id[]" id="hobbies_id_{{ $userHobby->hobbies_id }}"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach ($hobbies as $hobby)
                                    <option value="{{ $hobby->id }}"
                                        {{ $userHobby->hobbies_id == $hobby->id ? 'selected' : '' }}>
                                        {{ $hobby->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="button" class="remove-button ml-4 px-3 py-2 rounded-md text-sm text-red"
                                onclick="removeHobby(this)">@include('components.icons.x')</button>
                        </div>
                    @endforeach
                    @foreach ($userHobbies as $userHobby)
                        <input type="hidden" name="user_hobby_ids[]" value="{{ $userHobby->hobbies_id }}">
                    @endforeach
                </div>

                <button type="button" id="add-hobby"
                    class="add-button px-4 py-2 rounded-md text-sm text-sscr-red">@include('components.icons.add')</button>

                <div class="flex items-center gap-4 mt-6">
                    <button type="submit"
                        class="bg-sscr-red text-white py-2 px-4 rounded-md shadow-sm hover:bg-sscr-red-dark focus:outline-none focus:ring-2 focus:ring-sscr-red focus:ring-opacity-50">{{ __('Save') }}</button>
                    @if (session('status') || session('error'))
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ session('status') || session('error') }}</p>
                    @endif
                </div>
            </form>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('add-hobby').addEventListener('click', function() {
            const container = document.getElementById('edit-user-hobbies-container');
            const index = container.children.length + 1;

            const newHobbyGroup = document.createElement('div');
            newHobbyGroup.className = 'mb-4 hobby-group flex items-center';
            newHobbyGroup.innerHTML = `
            <label for="hobbies_id_${index}" class="block text-gray-700 font-medium mb-1">Select Hobby:</label>
            <select name="hobbies_id[]" id="hobbies_id_${index}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach ($hobbies as $hobby)
                    <option value="{{ $hobby->id }}">{{ $hobby->name }}</option>
                @endforeach
            </select>
            <button type="button" class="remove-button ml-4 px-3 py-2 rounded-md text-sm text-red" onclick="removeHobby(this)">
                @include('components.icons.x')
                </button>
        `;

            container.appendChild(newHobbyGroup);
        });

        function removeHobby(button) {
            const container = document.getElementById('edit-user-hobbies-container');
            container.removeChild(button.parentElement);
        }
    </script>
@endsection
