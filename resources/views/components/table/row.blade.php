@props(['active' => false])

@php
    $classes = ($active ?? false)
                ? 'bg-gray-200'
                : 'bg-white';
@endphp

<div @click="open = ! open"
     @click.away="open = false"
     @close.stop="open = false"
     class="w-full p-0 md:p-2 my-1 rounded-md shadow hover:border-indigo-500 border border-gray-200 cursor-pointer transition-colors {{$classes}}">
    {{ $slot }}
</div>
