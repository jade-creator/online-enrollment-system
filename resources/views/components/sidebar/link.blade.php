@props([
    'routeName' => 'N/A',
    'routes' => '',
    'route' => 'N/A',
    'parameter' => '',
    'value' => 'N/A',
    'name' => 'N/A',
    'activeColor' => 'bg-indigo-500 text-white hover:bg-indigo-100',
    'defaultColor' => 'bg-white hover:bg-indigo-100'
])

@php
    $bgColor = in_array(request()->route()->getName(), is_string($routes) ? [] : $routes) ? $activeColor : $defaultColor;
@endphp

<a href="{{is_string($parameter) ? route($routeName) : route($routeName, $parameter)}}"
    {{ $attributes->merge(['class' => 'flex flex-row items-center py-3 font-bold focus:outline-none hover:text-black transition-colors '.$bgColor]) }}>
    <x-sidebar.icon>
        {{ $slot }}
    </x-sidebar.icon>
    <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ $name }}</span>
</a>
