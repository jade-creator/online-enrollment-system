@props(['title'])

<button {{ $attributes }} class="flex w-full px-4 py-2 hover:bg-gray-200 outline-none focus:outline-none transition-all duration-300 ease-in-out">
    {{ $icon }}
    <p class="pl-2">{{ $title }}</p>
</button>
