@extends('master')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                Edit Alumni Information Section
            </h2>
            <form method="post" action="{{ route('alumni-information.update', ['alumniInformation' => $information->id]) }}" class=" space-y-6">
                @csrf
                @method('patch')

                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Personal Information</h3>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full  md:w-1/4 px-3">
                            <label for="last_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Last Name</label>
                            <input id="last_name" name="last_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                value="{{ old('last_name', $information->last_name) }}" />
                        </div>
                        <div class="flex-1 md:w-1/4 px-3">
                            <label for="first_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">First Name</label>
                            <input id="first_name" name="first_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
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
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Basic Information</h3>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/4 px-3">
                            <label for="nationality" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nationality</label>
                            <input list="nationalities" id="nationality" name="nationality"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('nationality', $information->nationality) }}" />
                            <datalist id="nationalities">
                                @foreach ($nationalities as $nationality)
                                    <option value="{{ $nationality }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="civil_status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Civil Status</label>
                            <input list="civil_statuses" id="civil_status" name="civil_status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('civil_status', $information->civil_status) }}" />
                            <datalist id="civil_statuses">
                                @foreach ($civilStatus as $status)
                                    <option value="{{ $status }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="age" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Age</label>
                            <input id="age" name="age"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="number"
                                value="{{ old('age', $information->age) }}" />
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="birth_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Birth Date</label>
                            <input id="birth_date" name="birth_date"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="date"
                                value="{{ old('birth_date', $information->birth_date ?? '') }}" />
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="gender" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Gender</label>
                            <input list="genders" id="gender" name="gender"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('gender', $information->gender) }}" />
                            <datalist id="genders">
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Address Information</h3>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="street_address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Street Address</label>
                            <input id="street_address" name="street_address"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                value="{{ old('street_address', $information->street_address) }}" />
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/4 px-3">
                            <label for="country" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Country</label>
                            <input list="countries" id="country" name="country"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('country', $information->country) }}" />
                            <datalist id="countries">
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="region" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Region</label>
                            <input list="regions" id="region" name="region"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('region', $information->region) }}" />
                            <datalist id="regions">
                                @foreach ($regions as $region)
                                    <option value="{{ $region }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="province" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Province</label>
                            <input list="provinces" id="province" name="province"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('province', $information->province) }}" />
                            <datalist id="provinces">
                                @foreach ($provinces as $province)
                                    <option value="{{ $province }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="city" class="block font-medium text-sm text-gray-700 dark:text-gray-300">City</label>
                            <input list="cities" id="city" name="city"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('city', $information->city) }}" />
                            <datalist id="cities">
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/4 px-3">
                            <label for="barangay" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Barangay</label>
                            <input list="barangays" id="barangay" name="barangay"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3 "
                                value="{{ old('barangay', $information->barangay) }}" />
                            <datalist id="barangays">
                                @foreach ($barangays as $barangay)
                                    <option value="{{ $barangay }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="postal_code" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Postal Code</label>
                            <input id="postal_code" name="postal_code"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                value="{{ old('postal_code', $information->postal_code) }}" />
                        </div>
                    </div>
                </div>

                <!-- Education and Career Information -->
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Education and Career Information</h3>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/4 px-3">
                            <label for="education_level" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Education Level</label>
                            <input list="education_levels" id="education_level" name="education_level"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('education_level', $information->education_level) }}" />
                            <datalist id="education_levels">
                                @foreach ($educationLevels as $educationLevel)
                                    <option value="{{ $educationLevel }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="batch" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Batch</label>
                            <input id="batch" name="batch"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="number"
                                value="{{ old('batch', $information->batch) }}" />
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="course" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Course</label>
                            <input list="courses" id="course" name="course"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('course', $information->course) }}" />
                            <datalist id="courses">
                                @foreach ($courses as $course)
                                    <option value="{{ $course }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="w-full md:w-1/4 px-3">
                            <label for="phone" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Phone</label>
                            <input id="phone" name="phone"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                value="{{ old('phone', $information->phone) }}" />
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/4 px-3">
                            <label for="occupation" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Occupation</label>
                            <input list="occupations" id="occupation" name="occupation"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('occupation', $information->occupation) }}" />
                            <datalist id="occupations">
                                @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <a href="{{ route('user.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 hover:bg-gray-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-sscr-red text-white py-2 px-4 rounded-md shadow-sm hover:bg-sscr-red-dark focus:outline-none focus:ring-2 focus:ring-sscr-red focus:ring-opacity-50">{{ __('Save') }}</button>

                    @if (session('status'))
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{session('status')}}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
