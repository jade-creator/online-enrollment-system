@props(['isSearchable' => true, 'isFilterable' => true])

<div>
    @if ($isSearchable)
        <div class="my-4 w-full md:w-52 relative border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4">
                    <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" class=""></path>
                </svg>
            </div>
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search..." class="block w-full pl-8 pr-4 bg-white border-0 focus:outline-none focus:ring focus:ring-gray-100 focus:ring-opacity-0">
        </div>
    @endif
    <div class="relative" x-data="{ open: false }" @close.stop="open = false">
        <div @click="open = ! open">
            <button :class="{'bg-gray-200': open, 'bg-white': ! open }" class="flex items-center focus:ring-2 focus:ring-opacity-50 hover:bg-gray-200 text-blue-500 mx-1 py-2.5 px-4 font-bold text-xs rounded-lg border border-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" height="16" viewBox="0 0 20 20" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path></svg>
                <span>Filter</span>
            </button>
        </div>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute mt-2 w-72 rounded-md origin-top-right right-0"
             style="display: none;">
            <div class="rounded-md ring-1 ring-black ring-opacity-5 border border-gray-300 bg-white py-4 overflow-y-auto">
                {{ $slot }}

                @if($isFilterable)
                    <div class="px-4 flex-auto">
                        <div class="pb-4 flex items-center justify-between">
                            <h3 class="font-bold text-md">{{ __('Date')}}</h3>
                            @if (isset($this->dateMin))
                                <a wire:click="resetDates" class="cursor-pointer text-blue-500 hover:underline">{{ __('reset')}}</a>
                            @endif
                        </div>
                        <div>
                            <div>
                                <h3 class="font-bold text-md">{{ __('From')}}</h3>
                                <div class="relative w-full bg-white pb-3 transition-all duration-500 focus-within:border-gray-300">
                                    <input wire:model.debounce.300ms="dateMin" id="dateMin" type="date" class="w-full bg-white border-0 focus:outline-none focus:ring focus:ring-gray-100 focus:ring-opacity-0">
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-md">{{ __('To')}}</h3>
                                <div class="relative w-full bg-white pb-3 transition-all duration-500 focus-within:border-gray-300">
                                    <input wire:model.debounce.300ms="dateMax" type="date" class="w-full bg-white border-0 focus:outline-none focus:ring focus:ring-gray-100 focus:ring-opacity-0">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
