@props(['action', 'buttonName'])

<button wire:click.prevent="{{ $action }}" wire:loading.attr="disabled" class="focus:ring-2 focus:bg-blue-500 focus:ring-opacity-50 bg-blue-500 hover:bg-blue-600 text-white py-2.5 px-4 font-bold text-xs rounded-lg border border-white">{{ $buttonName }}</button>

