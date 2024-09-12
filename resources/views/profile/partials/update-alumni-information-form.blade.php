<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-wrap -mx-3 mb-6">
            <!-- Row 1: Names -->
            <div class="w-full md:w-1/4 px-3">
                <label for="last_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Last Name</label>
                <input id="last_name" name="last_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" required />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="first_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">First Name</label>
                <input id="first_name" name="first_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" required />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="middle_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Middle Name</label>
                <input id="middle_name" name="middle_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="suffix" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Suffix</label>
                <input id="suffix" name="suffix" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
        </div>

        <!-- Row 2: Nationality, Civil Status, Age, Gender -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/4 px-3">
                <label for="nationality" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nationality</label>
                <input list="nationalities" id="nationality" name="nationality" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="nationalities">
                    @foreach ($nationalities as $nationality)
                        <option value="{{ $nationality }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="civil_status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Civil Status</label>
                <input list="civil_statuses" id="civil_status" name="civil_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="civil_statuses">
                    @foreach ($civilStatus as $status)
                        <option value="{{ $status }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="age" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Age</label>
                <input id="age" name="age" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="number" />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="gender" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Gender</label>
                <input list="genders" id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="genders">
                    @foreach ($genders as $gender)
                        <option value="{{ $gender }}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>

        <!-- Row 3: Address -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label for="street_address" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Street Address</label>
                <input id="street_address" name="street_address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
        </div>

        <!-- Row 4: Country, Region, Province, City -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/4 px-3">
                <label for="country" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Country</label>
                <input list="countries" id="country" name="country" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="countries">
                    @foreach ($countries as $country)
                        <option value="{{ $country }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="region" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Region</label>
                <input list="regions" id="region" name="region" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="regions">
                    @foreach ($regions as $region)
                        <option value="{{ $region }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="province" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Province</label>
                <input list="provinces" id="province" name="province" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="provinces">
                    @foreach ($provinces as $province)
                        <option value="{{ $province }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="city" class="block font-medium text-sm text-gray-700 dark:text-gray-300">City</label>
                <input list="cities" id="city" name="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="cities">
                    @foreach ($cities as $city)
                        <option value="{{ $city }}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>

        <!-- Row 5: Barangay, Postal Code, Education Level, Batch -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/4 px-3">
                <label for="barangay" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Barangay</label>
                <input list="barangays" id="barangay" name="barangay" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="barangays">
                    @foreach ($barangays as $barangay)
                    <option value="{{ $barangay }}"></option>
                @endforeach
                </datalist>
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="postal_code" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Postal Code</label>
                <input id="postal_code" name="postal_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="education_level" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Education Level</label>
                <input list="education_levels" id="education_level" name="education_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="education_levels">
                    @foreach ($educationLevels as $educationLevel)
                        <option value="{{ $educationLevel }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="batch" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Batch</label>
                <input id="batch" name="batch" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="number" />
            </div>
        </div>

        <!-- Row 6: Course, Phone, Birth Date, Occupation -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/4 px-3">
                <label for="course" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Course</label>
                <input list="courses" id="course" name="course" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="courses">
                    @foreach ($courses as $course)
                        <option value="{{ $course }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="phone" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Phone</label>
                <input id="phone" name="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="birth_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Birth Date</label>
                <input id="birth_date" name="birth_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="date" />
            </div>
            <div class="w-full md:w-1/4 px-3">
                <label for="occupation" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Occupation</label>
                <input list="occupations" id="occupation" name="occupation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                <datalist id="occupations">
                    @foreach ($occupations as $occupation)
                        <option value="{{ $occupation }}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>















        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>

</script>
