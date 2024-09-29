@extends('master')

@section('css')
    @if($user->role === 'alumni')
        <style>
            #alumni-id-card {
                background-image: url("{{ asset('storage/school.jpg') }}");
                background-repeat: no-repeat;
                background-size: cover;
                background-position: right;
                background-color: rgba(255, 255, 255, 0.8);
                background-blend-mode: overlay;
            }
        </style>
    @endif
@endsection

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl sm:px-6 lg:px-8 space-y-6">
        @if($user->role === 'alumni')
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    Alumni Digital Identification Card
                </h2>
                <div id="alumni-id-card" class="relative w-[500px] h-[300px] bg-gray-100 rounded-lg shadow-lg border-2 border-gray-500 m-auto mb-10">
                    <div class="text-center bg-sscr-red pb-2 p-4 rounded-t-lg">
                        <p class="text-sm font-semibold text-sscr-yellow">San Sebastian College - Recoletos de Cavite</p>
                        <p class="text-lg font-semibold text-sscr-yellow">SSCR Alumni Identification Card</p>
                        <p class="text-sm italic text-sscr-yellow">Caritas et Scientia</p>
                    </div>

                    <p class="text-sm font-light text-sscr-red px-4 pt-2">Alumni Id: – {{ $user->username }}</p>

                    <div class="flex space-x-4 pt-2 px-4">
                        <div class="w-32 h-32 rounded-lg">
                            <img id="profile-preview"
                                src="{{ $user->image ? asset('storage/profile/images/' . $user->image) : asset('storage/profile/images/default.jpg') }}"
                                onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                                alt="Profile Image" class="rounded-lg w-full h-full object-cover">
                        </div>

                        <div class="text-sm">
                            <p><span class="font-semibold">Last Name: </span> {{ $information->last_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Given Name: </span> {{ $information->first_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Middle Name: </span> {{ $information->middle_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Date of Birth: </span> {{ $information->birth_date ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Course: </span> {{ $information->course ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Batch: </span> {{ $information->batch ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="absolute bottom-4 left-4 text-sm">
                        <p><span class="font-semibold">Address:</span> {{ $address ?? false ? $address : 'N/A' }}</p>
                    </div>

                    <div class="absolute top-4 left-4">
                        <img src="{{ asset('/storage/logo.png') }}" alt="Seal" class="w-12 h-12">
                    </div>

                    <div class="absolute top-4 right-4">
                        <img src="{{ asset('/storage/oar_logo.png') }}" alt="Seal" class="w-12 h-12">
                    </div>
                </div>
            </div>
        @endif
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                User Information
                <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                    class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
            </h2>
            <div class="flex flex-col md:flex-row gap-6 items-start">
                <div class="w-32 h-32">
                    <img id="profile-preview"
                        src="{{ $user->image ? asset('storage/profile/images/' . $user->image) : asset('storage/profile/images/default.jpg') }}"
                        onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                        alt="Profile Image" class="rounded-lg border-2 border-sscr-red w-full h-full object-cover">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                    <div class="flex flex-col">
                        <p class="font-semibold text-gray-800">{{ $information->first_name ?? 'N/A' }}</p>
                        <p class="font-light text-sm text-gray-500">First Name</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold text-gray-800">{{ $information->last_name ?? 'N/A' }}</p>
                        <p class="font-light text-sm text-gray-500">Last Name</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold text-gray-800">{{ $information->middle_name ?? 'N/A' }}</p>
                        <p class="font-light text-sm text-gray-500">Middle Name</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold text-gray-800">{{ $information->suffix ?? 'N/A' }}</p>
                        <p class="font-light text-sm text-gray-500">Suffix</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold text-gray-800">{{ $user->username ?? 'N/A' }}</p>
                        <p class="font-light text-sm text-gray-500">Username</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold text-gray-800">{{ $user->email ?? 'N/A' }}</p>
                        <p class="font-light text-sm text-gray-500">Email</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="flex flex-col">
                    <p class="font-semibold text-sm">{{ $user->created_at ? $user->created_at->format('M. j, Y \a\t g:ia') : 'N/A' }}</p>
                    <p class="font-light text-sm text-gray-500">Date Joined</p>
                </div>
                <div class="flex flex-col">
                    <p class="font-semibold text-sm">{{ $user->updated_at ? $user->updated_at->format('M. j, Y \a\t g:ia') : 'N/A' }}</p>
                    <p class="font-light text-sm text-gray-500">Last Updated</p>
                </div>
                <div class="flex flex-col">
                    <p class="font-semibold text-sm">{{ $user->approved_at ? $user->approved_at->format('M. j, Y \a\t g:ia') : 'N/A' }}</p>
                    <p class="font-light text-sm text-gray-500">Date Join Approved</p>
                </div>
            </div>
        </div>

        @if ($user->role === 'alumni')
            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    More Information
                    @if ($user->role === 'alumni')
                        <a href="{{ route('alumni-information.edit', ['alumniInformation' => $user->id]) }}"
                            class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                    @else
                        <a href="{{ route('admin-information.edit', ['alumniInformation' => $user->id]) }}"
                            class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                    @endif
                </h2>
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h2 class="text-md font-semibold text-gray-800 mb-4">Additional Information</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->nationality ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Nationality</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->civil_status ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Civil Status</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->age ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Age</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->gender ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Gender</p>
                        </div>
                    </div>
                </div>
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h2 class="text-md font-semibold text-gray-800 font">Address Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 text-sm">
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->street_address ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Street Address</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->country ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Country</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->region ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Region</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->province ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Province</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->city ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">City</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->barangay ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Barangay</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->postal_code ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Postal Code</p>
                        </div>
                    </div>
                </div>
                <div class="">
                    <h2 class="text-md font-semibold text-gray-800">Contact Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 text-sm">
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->course ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Course</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->phone ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Phone</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ !empty($information->birth_date) ? $information->birth_date->format('d/m/Y') : 'N/A' }}</p>
                            <p class="font-light text-gray-500">Birth Date</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    User Hobbies
                    @if ($user->role === 'alumni')
                        <a href="{{ route('user-hobbies.edit', ['user_id' => $user->id]) }}"
                            class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                    @endif
                </h2>
                <div>
                    <h2 class="text-md font-semibold text-gray-800">Hobbies Information</h2>
                     @if ($hobbies->isEmpty())
                        <p class="font-light text-sm text-gray-500">No hobbies available.</p>
                    @else
                        <ul class="list-disc list-inside text-sm text-gray-700">
                            @foreach ($hobbies as $hobby)
                                <li>{{ $hobby->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    More Information
                    @if ($user->role === 'alumni')
                        <a href="{{ route('alumni-information.edit', ['alumniInformation' => $user->id]) }}"
                            class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                    @else
                        <a href="{{ route('admin-information.edit', ['adminInformation' => $user->id]) }}"
                            class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                    @endif
                </h2>
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h2 class="text-md font-semibold text-gray-800 mb-4">Additional Information</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $information->department ?? 'N/A' }}</p>
                            <p class="font-light text-gray-500">Department</p>
                        </div>

                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection
