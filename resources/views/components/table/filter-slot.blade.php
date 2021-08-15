@props(['title'])

<div class="my-4">
    <h3 class="font-bold text-md">{{ $title }}</h3>
    <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
        {{ $slot }}
    </div>
</div>
