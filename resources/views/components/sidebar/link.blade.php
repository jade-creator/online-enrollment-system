@props([ 'routeName' => 'N/A', 'route' => 'N/A', 'parameter' => '', 'value' => 'N/A', 'name' => 'N/A'])
<a href="{{filled($parameter) ? route($routeName, [$parameter => $value]) : route($routeName)}}" 
    class="flex flex-row items-center py-3 font-bold focus:outline-none hover:bg-indigo-100 hover:text-black transition-colors  {{ request()->is($route.'/*') || request()->is($route) ? 'bg-indigo-500 text-white'
    : 'bg-white'}} ">
    <x-sidebar.icon>
        {{ $slot }}
    </x-sidebar.icon>

    <span class="ml-4 mt-1 text-sm tracking-wide truncate">{{ $name }}</span>
</a>
