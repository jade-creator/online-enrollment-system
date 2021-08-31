@props(['value'])

<div class="col-span-12 md:col-span-2 truncate font-bold text-xs">
    <div class="flex items-center">
        <input wire:model="selected" wire:loading.attr="disabled" value="{{ $value }}" type="checkbox" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
        <div class="h-10 flex items-center">
            {{ $slot }}
        </div>
    </div>
</div>
