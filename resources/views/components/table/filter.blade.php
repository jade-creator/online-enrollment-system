@props(['isSearchable' => true, 'isFilterable' => true])

<div class="flex justify-between items-center mb-4">
    @if ($isSearchable)
        <div class="my-4 w-full md:w-52 relative">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search...">
        </div>
    @endif

    <div x-data="{ open: false }" @close.stop="open = false">
        <button @click="open = true" :class="{'bg-gray-200': open, 'bg-white': ! open }" class="flex items-center focus:ring-2 focus:ring-opacity-50 hover:bg-gray-200 text-blue-500 mx-1 py-2.5 px-4 font-bold text-xs rounded-lg border border-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" height="16" viewBox="0 0 20 20" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path></svg>
            <span>Filter</span>
        </button>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="grid place-items-center fixed w-screen h-screen left-0 top-0 z-50 bg-gray-500 bg-opacity-75 overflow-hidden"
             style="display: none;">
            <div class="max-h-96 w-96 py-4 space-y-4 rounded-lg ring-1 ring-black ring-opacity-5 border border-gray-300 bg-white p-4 overflow-y-auto">
                <h1 class="w-full text-lg ">Filter</h1>
                @if($isFilterable)
                    <div class="flex-auto">
                        <div class="pb-2 flex items-center justify-between">
                            <h3>{{ __('Date')}}</h3>
                            @if (isset($this->dateMin))
                                <a wire:click="resetDates" class="cursor-pointer text-blue-500 hover:underline">{{ __('reset')}}</a>
                            @endif
                        </div>
                        <div class="flex flex-wrap justify-between gap-2">
                            <div class="flex flex-col flex-grow">
                                <label>{{ __('From')}}</label>
                                <div class="relative w-full bg-white transition-all duration-500 focus-within:border-gray-300">
                                    <input wire:model.debounce.300ms="dateMin" id="dateMin" type="date">
                                </div>
                            </div>
                            <div class="flex flex-col flex-grow">
                                <label>{{ __('To')}}</label>
                                <div class="relative w-full bg-white transition-all duration-500 focus-within:border-gray-300">
                                    <input wire:model.debounce.300ms="dateMax" type="date">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}

                <div class="text-right">
                    <x-jet-secondary-button @click="open = false">
                        {{ __('Close') }}
                    </x-jet-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
