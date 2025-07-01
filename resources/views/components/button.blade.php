@props([
    'variant' => 'primary',
    'size' => 'md',
])

@php
$base = 'inline-flex items-center rounded-full focus:outline-none transition duration-150 ease-in-out hover:scale-105';

$colors = [
    'primary' => 'bg-indigo-400 hover:bg-indigo-600 text-white',
    'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-700',
    'warning' => 'bg-amber-200 hover:bg-amber-300 text-gray-700',
    'danger' => 'bg-red-400 hover:bg-red-500 text-white',
    'success' => 'bg-green-400 hover:bg-green-500 text-white',
];

$sizes = [
    'sm' => 'text-xs px-2 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2',
    'md' => 'text-sm px-3 py-1.5 sm:px-4 sm:py-2 md:px-5 md:py-2.5',
    'lg' => 'text-base px-4 py-2 sm:px-5 sm:py-3 md:px-6 md:py-3.5',
];
@endphp

<button {{ $attributes->merge([
    'class' => "$base {$colors[$variant]} {$sizes[$size]}"
]) }}>
    {{ $slot }}
</button>
