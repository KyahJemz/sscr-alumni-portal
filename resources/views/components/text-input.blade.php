@props(['disabled' => false])

@php
$classes = ($disabled ?? false)
            ? 'border-gray-300 dark:border-gray-700 dark:bg-gray-200 bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'
            : 'border-gray-300 dark:border-gray-700 dark:bg-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';
@endphp

<input {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
