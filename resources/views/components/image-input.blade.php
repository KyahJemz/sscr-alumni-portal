@props(['disabled' => false, 'image' => null])

@php
    $classes = 'border-gray-300 dark:border-gray-700 bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
@endphp

@isset($image)
    <img id="profile-preview" src="{{ $image ?? '' }}" alt="Profile Image" class="rounded-full w-32 h-32 border-gray-300 dark:border-gray-700 mb-4">
@else
    <img id="profile-preview" src="" alt="Profile Image" class="rounded-full w-32 h-32 border-gray-300 dark:border-gray-700 mb-4" style="display: none">
@endisset

<input id="profile_image" type="file" name="profile_image" class="mt-1 block w-full cursor-pointer" {{ $attributes->merge(['class' => $classes]) }} accept="image/png, image/jpeg" />

