@extends('master')

@section('content')
<div class="flex justify-center items-center h-screen bg-gray-100">
    <div class="relative w-[500px] h-[300px] bg-white rounded-lg shadow-lg border-2 border-gray-300 p-4">
        <div class="text-center">
            <p class="text-sm font-semibold">San Sebastian College - Recoletos de Cavite</p>
            <p class="text-lg font-semibold">SSCR Alumni Identification Card</p>
            <p class="text-sm italic">Caritas et Scientia</p>
        </div>

        <p class="text-sm font-light">Alumni Id: – {{ $user->username }}</p>

        <div class="flex space-x-4 mt-4">
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
            <p><span class="font-semibold">Address:</span> {{ $address ? $address : 'N/A' }}</p>
        </div>

        <div class="absolute top-4 left-4">
            <img src="path/to/government-seal.png" alt="Seal" class="w-12 h-12">
        </div>
    </div>
</div>

@endsection
