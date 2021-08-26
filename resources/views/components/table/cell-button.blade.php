@props(['title'])

<button {{ $attributes->merge(['class' => 'flex w-full px-4 py-2 hover:bg-gray-200 outline-none focus:outline-none transition-all duration-300 ease-in-out']) }} wire:loading.attr="disabled">
    {{ $slot }}
    <p class="pl-2">{{ $title }}</p>
</button>
