@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'w-full p-2 my-1 rounded-md shadow hover:shadow-md bg-gray-200 border-t border-l border-r border-gray-200 border-opacity-80 cursor-pointer'
                : 'w-full p-2 my-1 rounded-md shadow hover:shadow-md bg-white border-t border-l border-r border-gray-200 border-opacity-80 cursor-pointer';
@endphp

<div @click="open = ! open"
     @click.away="open = false"
     @close.stop="open = false"
    {{ $attributes->merge(['class' => $classes]) }}>

    {{ $slot }}
</div>
