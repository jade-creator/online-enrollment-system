<div class="flex-grow shadow p-4 text-gray-500">
    <h3 class="font-bold text-lg mb-4">{{ __('Filters')}}</h3>

    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0">

        <div class="flex-auto">
            <div class="pb-4 flex items-center justify-between">
                <h3 class="font-bold text-md">{{ __('Date')}}</h3>
                @if (isset($this->dateMin))
                    <a wire:click="resetDates" class="cursor-pointer text-blue-500 hover:underline">{{ __('reset')}}</a>
                @endif
            </div>
            <div class="flex flex-wrap sm:space-x-2 ">
                <div>
                    <h3 class="font-bold text-md">{{ __('From')}}</h3>
                    <div class="relative w-full bg-white pb-3 transition-all duration-500 focus-within:border-gray-300">
                        <input wire:model.debounce.300ms="dateMin" id="dateMin" type="date" class="block w-52 bg-white border-0 focus:outline-none focus:ring focus:ring-gray-100 focus:ring-opacity-0">
                    </div>
                </div>
                <div>
                    <h3 class=" font-bold text-md">{{ __('To')}}</h3>
                    <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                        <input wire:model.debounce.300ms="dateMax" type="date" class="block w-52 bg-white border-0 focus:outline-none focus:ring focus:ring-gray-100 focus:ring-opacity-0">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-grow md:ml-5 lg:ml-10">
            {{ $slot }}
        </div>
    </div>
</div>
