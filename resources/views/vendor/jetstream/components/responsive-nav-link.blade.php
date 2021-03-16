@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 text-base font-medium text-indigo-700 bg-gray-200 focus:outline-none focus:text-indigo-800 focus:bg-gray-200 transition duration-150 ease-in-out'
            : 'block pl-3 pr-4 py-2 border-transparent text-base font-medium text-gray-600 hover:bg-gray-200 focus:outline-none focus:text-gray-800 focus:bg-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
