@props([
    'routes' => '',
    'title' => ''
])

@php
    $bgColor = in_array(request()->route()->getName(), is_string($routes) ? [] : $routes)
        ? 'bg-indigo-500 text-white hover:bg-indigo-100' : 'bg-white hover:bg-indigo-100';
@endphp

<x-sidebar.item
    title="{{$title}}"
    @click="dropdown = ! dropdown"
    @click.stop>
    <p class="flex flex-row items-center font-bold focus:outline-none hover:text-black transition-colors cursor-pointer {{ $bgColor }}">
        <span class="flex flex-row items-center py-3 font-bold focus:outline-none hover:text-black transition-colors">
            <x-sidebar.icon>
                {{$slot}}
            </x-sidebar.icon>
        </span>

        <span class="flex items-center justify-between w-full">
            <span class="ml-4 mt-1 text-sm tracking-wide truncate">
                @isset ($title)
                    {{$title}}
                @endisset
            </span>
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': dropdown, 'rotate-0': !dropdown}" class="inline w-4 h-4 mt-1 mx-2 transition-transform duration-200 transform">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </span>
    </p>
</x-sidebar.item>
