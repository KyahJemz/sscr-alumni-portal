<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6 max-w-7xl mx-auto max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="flex justify-between">
            <h1 class="text-3xl font-bold mb-4">Personal Information</h1>
            <a href="{{ route('profile.edit') }}" class="text-gray-800 font-bold py-2 px-4 rounded">Edit</a>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Row 1: Basic Information -->
            <div class="space-y-6 border-b border-gray-200 pb-6 mb-6">
                <h2 class="text-md font-semibold text-gray-800 border-l-4 border-sscr-red pl-2">Personal Information</h2>
                <div class="flex gap-4">
                    <div class="space-y-2 mt-4 text-sm">
                        <img id="profile-preview" src="{{ $profile->image ? asset('storage/profile/images/' . $profile->image) : asset('storage/profile/images/defailt.jpg') }}" alt="Profile Image" class="rounded-4 border-sscr-red border-2 w-32 h-32 border-gray-300 dark:border-gray-700 mb-4">
                    </div>
                    <div class="space-y-2 mt-4 text-sm">
                        <p><strong>First Name:</strong> {{ $profile->alumniInformation->first_name ?? 'N/A' }}</p>
                        <p><strong>Last Name:</strong> {{ $profile->alumniInformation->last_name ?? 'N/A' }}</p>
                        <p><strong>Middle Name:</strong> {{ $profile->alumniInformation->middle_name ?? 'N/A' }}</p>
                        <p><strong>Suffix:</strong> {{ $profile->alumniInformation->suffix ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Row 2: Additional Information -->
            <div class="space-y-6 border-b border-gray-200 pb-6 mb-6">
                <h2 class="text-md font-semibold text-gray-800 border-l-4 border-sscr-red pl-2">Additional Information</h2>
                <div class="space-y-2 mt-4 text-sm">
                    <p><strong>Nationality:</strong> {{ $profile->alumniInformation->nationality ?? 'N/A' }}</p>
                    <p><strong>Civil Status:</strong> {{ $profile->alumniInformation->civil_status ?? 'N/A' }}</p>
                    <p><strong>Age:</strong> {{ $profile->alumniInformation->age ?? 'N/A' }}</p>
                    <p><strong>Gender:</strong> {{ $profile->alumniInformation->gender ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Row 3: Address Information -->
            <div class="space-y-6 border-b border-gray-200 pb-6 mb-6">
                <h2 class="text-md font-semibold text-gray-800 border-l-4 border-sscr-red pl-2">Address Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 text-sm">
                    <div class="space-y-2">
                        <p><strong>Street Address:</strong> {{ $profile->alumniInformation->street_address ?? 'N/A' }}</p>
                        <p><strong>Country:</strong> {{ $profile->alumniInformation->country ?? 'N/A' }}</p>
                        <p><strong>Region:</strong> {{ $profile->alumniInformation->region ?? 'N/A' }}</p>
                        <p><strong>Province:</strong> {{ $profile->alumniInformation->province ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-2">
                        <p><strong>City:</strong> {{ $profile->alumniInformation->city ?? 'N/A' }}</p>
                        <p><strong>Barangay:</strong> {{ $profile->alumniInformation->barangay ?? 'N/A' }}</p>
                        <p><strong>Postal Code:</strong> {{ $profile->alumniInformation->postal_code ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-md font-semibold text-gray-800 border-l-4 border-sscr-red pl-2">Educational Information</h2>
                        <p><strong>Education Level:</strong> {{ $profile->alumniInformation->education_level ?? 'N/A' }}</p>
                        <p><strong>Batch:</strong> {{ $profile->alumniInformation->batch ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Row 4: Contact Information -->
            <div class="space-y-6 border-b border-gray-200 pb-6 mb-6">
                <h2 class="text-md font-semibold text-gray-800 border-l-4 border-sscr-red pl-2">Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 text-sm">
                    <div class="space-y-2">
                        <p><strong>Course:</strong> {{ $profile->alumniInformation->course ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $profile->alumniInformation->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-2">
                        <p><strong>Birth Date:</strong> {{ $profile->alumniInformation->birth_date ? $profile->alumniInformation->birth_date->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Row 5: Occupation -->
            <div>
                <h2 class="text-md font-semibold text-gray-800 border-l-4 border-sscr-red pl-2">Occupation</h2>
                <div class="mt-4 text-sm">
                    <p><strong>Occupation:</strong> {{ $profile->alumniInformation->occupation ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
