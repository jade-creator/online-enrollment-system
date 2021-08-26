@props([ 'event' ])

<button class="flex items-center font-bold text-xs text-gray-400 hover:text-gray-500 uppercase tracking-widest focus:outline-none" wire:click="{{ $event }}" title="sort">
    <span class="pr-1">{{ $slot }}</span>
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M3 9l4 -4l4 4m-4 -4v14"></path>
        <path d="M21 15l-4 4l-4 -4m4 4v-14"></path>
    </svg>
</button>
