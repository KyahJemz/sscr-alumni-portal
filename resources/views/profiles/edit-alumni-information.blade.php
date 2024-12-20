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
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 {{ Auth::user()->role === 'alumni' ? 'bg-gray-200' : '' }}" type="text"
                                {{ Auth::user()->role === 'alumni' ? 'readonly' : '' }}
                                value="{{ old('last_name', $information->last_name) }}" />
                        </div>
                        <div class="flex-1 md:w-1/4 px-3">
                            <label for="first_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">First Name</label>
                            <input id="first_name" name="first_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 {{ Auth::user()->role === 'alumni' ? 'bg-gray-200' : '' }}" type="text"
                                {{ Auth::user()->role === 'alumni' ? 'readonly' : '' }}
                                value="{{ old('first_name', $information->first_name) }}" required />
                        </div>
                        <div class="flex-1 md:w-1/4 px-3">
                            <label for="middle_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Middle Name</label>
                            <input id="middle_name" name="middle_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 {{ Auth::user()->role === 'alumni' ? 'bg-gray-200' : '' }}" type="text"
                                {{ Auth::user()->role === 'alumni' ? 'readonly' : '' }}
                                value="{{ old('middle_name', $information->middle_name) }}" />
                        </div>
                        <div class="flex-1 md:w-1/4 px-3">
                            <label for="suffix" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Suffix</label>
                            <input id="suffix" name="suffix"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 {{ Auth::user()->role === 'alumni' ? 'bg-gray-200' : '' }}" type="text"
                                {{ Auth::user()->role === 'alumni' ? 'readonly' : '' }}
                                value="{{ old('suffix', $information->suffix) }}" />
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Basic Information</h3>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="md:w-1/3 px-3">
                            <label for="nationality" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nationality <a class="text-sscr-red"> *</a></label>
                            <input list="nationalities" id="nationality" name="nationality"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                required
                                value="{{ old('nationality', $information->nationality) }}" />
                            <datalist id="nationalities">
                                @foreach ($nationalities as $nationality)
                                    <option value="{{ $nationality }}">{{ $nationality }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="md:w-1/3 px-3">
                            <label for="civil_status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Civil Status <a class="text-sscr-red"> *</a></label>
                            <input list="civil_statuses" id="civil_status" name="civil_status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                required
                                value="{{ old('civil_status', $information->civil_status) }}"/>
                            <datalist id="civil_statuses">
                                @foreach ($civilStatus as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="md:w-1/3 px-3">
                            <label for="age" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Age <a class="text-sscr-red"> *</a></label>
                            <input id="age" name="age"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="number"
                                required
                                value="{{ old('age', $information->age) }}" />
                        </div>
                        <div class=" md:w-1/2 px-3">
                            <label for="birth_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Birth Date <a class="text-sscr-red"> *</a></label>
                            <input id="birth_date" name="birth_date"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="date"
                                required
                                value="{{ old('birth_date', $information->birth_date ?? '') }}" />
                        </div>
                        <div class="md:w-1/2 px-3">
                            <label for="gender" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Gender <a class="text-sscr-red"> *</a></label>
                            <input list="genders" id="gender" name="gender"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                required
                                value="{{ old('gender', $information->gender) }}" />
                            <datalist id="genders">
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender }}">{{ $gender }}</option>
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
                            <label for="street_address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Street Address <a class="text-sscr-red"> *</a></label>
                            <input id="street_address" name="street_address"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                required
                                value="{{ old('street_address', $information->street_address) }}" />
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="md:w-1/2 px-3">
                            <label for="country" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Country <a class="text-sscr-red"> *</a></label>
                            <input list="countries" id="country" name="country"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                required
                                value="{{ old('country', $information->country) }}" />
                            <datalist id="countries">
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <label for="region" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Region <a class="text-sscr-red"> *</a></label>
                            <input list="regions" id="region" name="region"
                                type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                required
                                value="{{ old('region', $information->region) }}" />
                            <datalist id="regions">
                                <option value="">-</option>
                                @foreach ($locations as $regionCode => $regionData)
                                    <option value="{{ $regionCode }}">{{ $regionData['region_name'] }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <label for="province" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Province<a class="text-sscr-red"> *</a></label>
                            <input list="provinces" id="province" name="province"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                required
                                value="{{ old('province', $information->province) }}" />
                            <datalist id="provinces">

                            </datalist>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <label for="city" class="block font-medium text-sm text-gray-700 dark:text-gray-300">City<a class="text-sscr-red"> *</a></label>
                            <input list="cities" id="city" name="city"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                required
                                value="{{ old('city', $information->city) }}" />
                            <datalist id="cities">

                            </datalist>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="md:w-1/2 px-3">
                            <label for="barangay" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Barangay<a class="text-sscr-red"> *</a></label>
                            <input list="barangays" id="barangay" name="barangay"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3 "
                                required
                                value="{{ old('barangay', $information->barangay) }}" />
                            <datalist id="barangays">

                            </datalist>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <label for="postal_code" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Postal Code<a class="text-sscr-red"> *</a></label>
                            <input id="postal_code" name="postal_code"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                required
                                value="{{ old('postal_code', $information->postal_code) }}" />
                        </div>
                    </div>
                </div>

                <!-- Education and Career Information -->
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Education and Career Information</h3>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="md:w-1/2 px-3">
                            <label for="education_level" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Education Level<a class="text-sscr-red"> *</a></label>
                            <input list="education_levels" id="education_level" name="education_level"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                required
                                value="{{ old('education_level', $information->education_level) }}" />
                            <datalist id="education_levels">
                                @foreach ($educationLevels as $educationLevel)
                                    <option value="{{ $educationLevel }}">{{ $educationLevel }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <label for="occupation" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Occupation<a class="text-sscr-red"> *</a></label>
                            <input list="occupations" id="occupation" name="occupation"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3"
                                value="{{ old('occupation', $information->occupation) }}" />
                            <datalist id="occupations">
                                @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation }}">{{ $occupation }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="md:w-1/4 px-3">
                            <label for="batch" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Batch</label>
                            <input id="batch" name="batch"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 {{ Auth::user()->role === 'alumni' ? 'bg-gray-200' : '' }}" type="number"
                                {{ Auth::user()->role === 'alumni' ? 'readonly' : '' }}
                                value="{{ old('batch', $information->batch) }}" />
                        </div>
                        <div class="md:w-2/4 px-3">
                            <label for="course" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Course</label>
                            <input list="courses" id="course" name="course"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12 px-3 {{ Auth::user()->role === 'alumni' ? 'bg-gray-200' : '' }}"
                                {{ Auth::user()->role === 'alumni' ? 'readonly' : '' }}
                                value="{{ old('course', $information->course) }}" />
                            <datalist id="courses">
                                @foreach ($courses as $course)
                                    <option value="{{ $course }}">{{ $course }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="md:w-1/4 px-3">
                            <label for="phone" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Phone<a class="text-sscr-red"> *</a></label>
                            <input id="phone" name="phone"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm h-12" type="text"
                                required
                                value="{{ old('phone', $information->phone) }}" />
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

@section('scripts')
<script>
    const regions = @json($locations);

    document.getElementById('region').addEventListener('change', function () {
        const regionId = this.value;
        const region = regions[regionId].province_list;

        const provinceSelect = document.getElementById('provinces');
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        Object.entries(region).forEach(([key, province]) => {
            provinceSelect.innerHTML += `<option value="${key}">${key}</option>`;
        });
    });

    document.getElementById('province').addEventListener('change', function () {
        const provinceId = this.value;
        const regionId = document.getElementById('region').value;
        const municipalities = regions[regionId].province_list[provinceId].municipality_list;

        const municipalitySelect = document.getElementById('cities');
        municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
        Object.entries(municipalities).forEach(([key, municipality]) => {
            municipalitySelect.innerHTML += `<option value="${key}">${key}</option>`;
        });
    });

    document.getElementById('city').addEventListener('change', function () {
        const municipalityId = this.value;
        const regionId = document.getElementById('region').value;
        const provinceId = document.getElementById('province').value;

        const barangays = regions[regionId].province_list[provinceId].municipality_list[municipalityId].barangay_list;
        console.log(barangays);

        const barangaySelect = document.getElementById('barangays');
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangays.forEach(barangay => {
            barangaySelect.innerHTML += `<option value="${barangay}">${barangay}</option>`;
        });
    });
</script>
@endsection
