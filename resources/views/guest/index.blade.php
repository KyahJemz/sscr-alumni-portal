@extends('guest-master')

@section('content')
    <h1 class="text-3xl font-bold text-sscr-red mb-4">
        Welcome to
    </h1>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
        San Sebastian College - Recoletos de Cavite
    </h2>
    <h3 class="text-lg text-gray-600 dark:text-gray-400 mb-8">
        Alumni Portal
    </h3>
    <a href="{{ route('login') }}" class="bg-sscr-red text-white font-semibold py-2 px-6 rounded-full hover:bg-red-700 transition-colors cursor-pointer">
        Login
    </a>
    <a href="/" class="absolute bottom-4 right-4">
        <img src="{{ asset('storage/stags.png') }}" class="w-24 sm:w-32" alt="San Sebastian Stags Logo">
    </a>
@endsection
