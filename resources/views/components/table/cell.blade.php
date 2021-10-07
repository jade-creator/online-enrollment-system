@props(['headerLabel' => 'Header'])

<div {{ $attributes->merge([ 'class' => 'flex items-center col-span-12 border md:border-0 truncate font-bold text-xs']) }}>
    <p class="md:hidden w-1/2 h-full uppercase px-2 text-indigo-500 border-r flex items-center">{{ $headerLabel }}</p>
    <p class="truncate py-4 ml-2 md:ml-0 overflow-hidden">{{ $slot }}</p>
</div>
