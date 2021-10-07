@props(['value'])

<div class="col-span-12 md:col-span-2 truncate font-bold text-xs self-center rounded-t-md bg-indigo-500 md:bg-transparent">
    <div class="flex items-center">
        <input wire:model="selected" wire:loading.attr="disabled" value="{{ $value }}" type="checkbox" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
        <div class="h-10 flex items-center text-white md:text-black">
            {{ $slot }}
        </div>
    </div>
</div>
