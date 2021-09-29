@props([ 'nameButton', 'event' ])

<button wire:click="{{ $event }}" class="w-20 py-4 border-t-4 border-indigo-500 border-opacity-0 hover:border-opacity-100 flex flex-col items-center outline-none focus:outline-none transition-all duration-300 ease-in-out" type="button">
    {{ $slot }}
    <p class="pt-1 text-xs font-semibold">{{ $nameButton }}</p>
</button>
