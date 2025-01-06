@extends('master')

@section('css')
    @if($user->role === 'alumni')
        <style>
            .alumni-id-card {
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
    <div class="container mx-auto py-2 max-w-7xl sm:p-2 md:p-6 md:py-6 md:space-y-6 sm:space-y-2">
        @if($user->role === 'alumni')
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    <div>Alumni Digital Identification Card</div>
                    <div class="flex flex-row ml-auto gap-2">
                        <button onclick="switchSide()" class="bg-sscr-red text-white px-3 py-1 rounded text-xs">Switch</button>
                        <button onclick="downloadAsImage()" class="sm:hidden md:block bg-sscr-red text-white px-3 py-1 rounded text-xs">Download</button>
                        <button onclick="downloadAsImage2()" class="sm:block md:hidden bg-sscr-red text-white px-3 py-1 rounded text-xs">Download</button>
                    </div>
                </h2>
                <div id="alumni-id-card" class="sm:hidden md:block alumni-id-card relative w-[500px] h-max bg-gray-100 rounded-lg shadow-lg border-2 border-gray-500  mb-10">
                    <div class="text-center bg-sscr-red pb-2 p-4 rounded-t-lg">
                        <p class="text-sm font-semibold text-sscr-yellow">San Sebastian College - Recoletos de Cavite</p>
                        <p class="text-lg font-semibold text-sscr-yellow">SSCR Alumni Identification Card</p>
                        <p class="text-sm italic text-sscr-yellow">Caritas et Scientia</p>
                    </div>

                    <p class="text-sm font-light text-sscr-red px-4 pt-2">Alumni Id: {{ $user->username }}</p>

                    <div class="flex space-x-4 pt-2 px-4">
                        <div class="w-32 h-32 rounded-lg">
                            <img id="profile-preview"
                                src="{{ $user->id_image ? asset('storage/profile/images/' . $user->id_image) : ( $user->image ? asset('storage/profile/images/' . $user->image) : asset('storage/profile/images/default.jpg') ) }}"
                                onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                                alt="Profile Image" class="rounded-lg w-full h-full object-cover">
                        </div>

                        <div class="text-sm">
                            <p><span class="font-semibold">Last Name: </span> {{ $information->last_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Given Name: </span> {{ $information->first_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Middle Name: </span> {{ $information->middle_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Date of Birth: </span> {{ !empty($information->birth_date) ? \Carbon\Carbon::parse($information->birth_date)->format('d F Y') : 'N/A' }}</p>
                            <p><span class="font-semibold">Course: </span> {{ $information->course ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Batch: </span> {{ $information->batch ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="mx-4 mb-4 text-sm">
                        <p><span class="font-semibold">Address:</span> {{ $address ?? false ? $address : 'N/A' }}</p>
                    </div>

                    <div class="absolute top-4 left-4">
                        <img src="{{ asset('/storage/logo.png') }}" alt="Seal" class="w-12 h-12">
                    </div>

                    <div class="absolute top-4 right-4">
                        <img src="{{ asset('/storage/oar_logo.png') }}" alt="Seal" class="w-12 h-12">
                    </div>
                </div>

                <div id="alumni-id-card-back" class="sm:hidden md:block hidden alumni-id-card relative w-[500px] h-max bg-gray-100 rounded-lg shadow-lg border-2 border-gray-500  mb-10">
                    <div class="text-center bg-sscr-red pb-2 p-4 rounded-t-lg">
                        <p class="text-xl font-semibold text-sscr-yellow">San Sebastian College - Recoletos de Cavite</p>
                        <p class="text-md italic text-sscr-yellow">Caritas et Scientia</p>
                    </div>

                    <p class="text-sm font-light text-sscr-red px-4 pt-2">Alumni Id: {{ $user->username }}</p>

                    <div class="flex flex-col space-y-4 pt-2 px-4 h-44 w-full">
                        <p class="text-center text-sm">{{ $address ?? false ? $address : 'N/A' }} </p>
                        <p class="text-sm"><span class="font-semibold">Civil Status: </span> {{ $information->civil_status ?? 'N/A' }}</p>
                        <p class="text-sm"><span class="font-semibold">Sex / Gender: </span> {{ $information->gender ?? 'N/A' }}</p>
                    </div>
                </div>

                <div id="alumni-id-card-2" class="md:hidden sm:block alumni-id-card relative w-[350px] h-max bg-gray-100 rounded-lg shadow-lg border-2 border-gray-500">
                    <div class="text-center bg-sscr-red pb-2 p-4 rounded-t-lg">
                        <p class="text-xs font-semibold text-sscr-yellow">San Sebastian College - Recoletos de Cavite</p>
                        <p class="text-md font-semibold text-sscr-yellow">SSCR Alumni Identification Card</p>
                        <p class="text-xs italic text-sscr-yellow">Caritas et Scientia</p>
                    </div>

                    <p class="text-xs font-light text-sscr-red px-4 pt-2">Alumni Id: {{ $user->username }}</p>

                    <div class="flex space-x-4 pt-2 px-4">
                        <div class="w-20 h-20 rounded-lg">
                            <img id="profile-preview"
                                src="{{ $user->id_image ? asset('storage/profile/images/' . $user->id_image) : ( $user->image ? asset('storage/profile/images/' . $user->image) : asset('storage/profile/images/default.jpg') ) }}"
                                onerror="this.onerror=null;this.src='{{ asset('storage/profile/images/default.jpg') }}';"
                                alt="Profile Image" class="rounded-lg w-full h-full object-cover">
                        </div>

                        <div class="text-xs">
                            <p><span class="font-semibold">Last Name: </span> {{ $information->last_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Given Name: </span> {{ $information->first_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Middle Name: </span> {{ $information->middle_name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Date of Birth: </span> {{ !empty($information->birth_date) ? \Carbon\Carbon::parse($information->birth_date)->format('d F Y') : 'N/A' }}</p>
                            <p><span class="font-semibold">Course: </span> {{ $information->course ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Batch: </span> {{ $information->batch ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="mx-4 mb-4 text-xs">
                        <p><span class="font-semibold">Address:</span> {{ $address ?? false ? $address : 'N/A' }}</p>
                    </div>

                    <div class="absolute top-4 left-4">
                        <img src="{{ asset('/storage/logo.png') }}" alt="Seal" class="w-8 h-8">
                    </div>

                    <div class="absolute top-4 right-4">
                        <img src="{{ asset('/storage/oar_logo.png') }}" alt="Seal" class="w-8 h-8">
                    </div>
                </div>

                <div id="alumni-id-card-2-back" class="md:hidden sm:block hidden alumni-id-card relative w-[350px] h-max bg-gray-100 rounded-lg shadow-lg border-2 border-gray-500 mb-10">
                    <div class="text-center bg-sscr-red pb-2 p-4 rounded-t-lg">
                        <p class="text-sm font-semibold text-sscr-yellow">San Sebastian College - Recoletos de Cavite </p>
                        <p class="text-md italic text-sscr-yellow">Caritas et Scientia</p>
                    </div>

                    <p class="text-sm font-light text-sscr-red px-4 pt-2">Alumni Id: {{ $user->username }}</p>

                    <div class="flex flex-col space-y-4 pt-2 px-4 h-40 w-full">
                        <p class="text-center text-sm">{{ $address ?? false ? $address : 'N/A' }} </p>
                        <p class="text-sm"><span class="font-semibold">Civil Status: </span> {{ $information->civil_status ?? 'N/A' }}</p>
                        <p class="text-sm"><span class="font-semibold">Sex / Gender: </span> {{ $information->gender ?? 'N/A' }}</p>
                    </div>
                </div>

            </div>
        @endif
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col gap-6">
            <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                User Information
                @if (Auth::user()->role === 'cict_admin' || Auth::user()->rol === 'alumni_coordinator' || Auth::user()->id === $user->id)
                    <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                        class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                @endif
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
                    @if (Auth::user()->role === 'cict_admin' || Auth::user()->rol === 'alumni_coordinator' || Auth::user()->id === $user->id)
                        @if ($user->role === 'alumni')
                            <a href="{{ route('alumni-information.edit', ['alumniInformation' => $user->alumniInformation->id]) }}"
                                class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                        @else
                            <a href="{{ route('admin-information.edit', ['adminInformation' => $user->adminInformation->id]) }}"
                                class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                        @endif
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
                            <p class="font-semibold">{{ !empty($information->birth_date) ? \Carbon\Carbon::parse($information->birth_date)->format('d F Y') : 'N/A' }}</p>

                            <p class="font-light text-gray-500">Birth Date</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                <h2 class="text-lg font-bold text-gray-800 border-l-4 border-sscr-red pl-2 text-sscr-red flex items-center">
                    User Hobbies
                    @if (Auth::user()->role === 'cict_admin' || Auth::user()->rol === 'alumni_coordinator' || Auth::user()->id === $user->id)
                        @if ($user->role === 'alumni')
                            <a href="{{ route('user-hobbies.edit', ['user_id' => $user->id]) }}"
                                class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                        @endif
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
                        <a href="{{ route('alumni-information.edit', ['alumniInformation' => $user->alumniInformation->id]) }}"
                            class="text-gray-800 font-bold py-2 px-4 rounded">@include('components.icons.edit')</a>
                    @else
                        <a href="{{ route('admin-information.edit', ['adminInformation' => $user->adminInformation->id]) }}"
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

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

    <script>
        function downloadAsImage() {
            const node = document.getElementById('alumni-id-card');
            const scale = 2;

        domtoimage.toPng(node, {
            width: node.offsetWidth * scale,
            height: node.offsetHeight * scale,
            style: {
                transform: `scale(${scale})`,
                transformOrigin: 'top left',
                width: `${node.offsetWidth}px`,
                height: `${node.offsetHeight}px`
            }
        }).then(function (dataUrl) {
            const link = document.createElement('a');
            link.download = 'alumni-id-card.png';
            link.href = dataUrl;
            link.click();
        }).catch(function (error) {
            console.error('Failed to download image:', error);
        });
        }
    </script>

    <script>
        function switchSide() {
            document.getElementById('alumni-id-card').classList.toggle('hidden');
            document.getElementById('alumni-id-card-back').classList.toggle('hidden');
            document.getElementById('alumni-id-card-2').classList.toggle('hidden');
            document.getElementById('alumni-id-card-2-back').classList.toggle('hidden');
        }
    </script>


    <script>
        function downloadAsImage2() {
            const node = document.getElementById('alumni-id-card-2');
            const scale = 2;

        domtoimage.toPng(node, {
            width: node.offsetWidth * scale,
            height: node.offsetHeight * scale,
            style: {
                transform: `scale(${scale})`,
                transformOrigin: 'top left',
                width: `${node.offsetWidth}px`,
                height: `${node.offsetHeight}px`
            }
        }).then(function (dataUrl) {
            const link = document.createElement('a');
            link.download = 'alumni-id-card.png';
            link.href = dataUrl;
            link.click();
        }).catch(function (error) {
            console.error('Failed to download image:', error);
        });
        }
    </script>
@endsection
