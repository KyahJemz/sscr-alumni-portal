@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                Edit Alumni Information Section
            </h2>
            <form method="post" action="{{ route('admin-information.update', ['adminInformation' => $information->id]) }}" class=" space-y-6">
                @csrf
                @method('patch')

                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Personal Information</h3>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full  md:w-1/4 px-3">
                            <label for="last_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Last Name <a class="text-sscr-red"> *</a></label>
                            <input id="last_name" name="last_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                required
                                value="{{ old('last_name', $information->last_name) }}" />
                        </div>
                        <div class="flex-1 md:w-1/4 px-3">
                            <label for="first_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">First Name <a class="text-sscr-red"> *</a></label>
                            <input id="first_name" name="first_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                required
                                value="{{ old('first_name', $information->first_name) }}" required />
                        </div>
                        <div class="flex-1 md:w-1/4 px-3">
                            <label for="middle_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Middle Name</label>
                            <input id="middle_name" name="middle_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                value="{{ old('middle_name', $information->middle_name) }}" />
                        </div>
                        <div class="flex-1 md:w-1/4 px-3">
                            <label for="suffix" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Suffix</label>
                            <input id="suffix" name="suffix"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                value="{{ old('suffix', $information->suffix) }}" />
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Additional Information</h3>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/4 px-3">
                            <label for="department" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Department <a class="text-sscr-red"> *</a></label>
                            <input list="department" id="department" name="department"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-2"
                                required
                                value="{{ old('department', $information->department) }}" />
                            <datalist id="department">
                                @foreach ($departments as $department)
                                    <option value="{{ $department }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <button type="submit"
                        class="bg-sscr-red text-white py-2 px-4 rounded-md shadow-sm hover:bg-sscr-red-dark focus:outline-none focus:ring-2 focus:ring-sscr-red focus:ring-opacity-50">{{ __('Save') }}</button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
