@props([ 'routeName' => 'N/A', 'route' => 'N/A', 'parameter' => '', 'value' => 'N/A', 'name' => 'N/A' ])

<a href="{{filled($parameter) ? route($routeName, [$parameter => $value]) : route($routeName)}}" class="{{ request()->is($route.'/*') || request()->is($route) ? 'text-indigo-500 h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700'
    : 'text-gray-800 h-11 relative flex flex-row items-center focus:outline-none hover:bg-gray-200 focus:bg-gray-200 font-bold hover:text-gray-700'}}">
    <x-sidebar.icon>
        {{ $slot }}
    </x-sidebar.icon>

    <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ $name }}</span>
</a>
