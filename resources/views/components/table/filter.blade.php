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
<<<<<<< HEAD
            </div>
        </div>

        <div class="flex-grow md:ml-5 lg:ml-10">
            {{ $slot }}
        </div>
    </div>
=======
            </div>
        </div>

        <div class="flex-grow md:ml-5 lg:ml-10">
            {{ $slot }}
        </div>
    </div>

    <!-- <div class="my-4">
        <div class="relative border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4">
                    <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" class=""></path>
                </svg>
            </div>
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search..." class="block w-52 pl-8 pr-4 bg-white border-0 focus:outline-none focus:ring focus:ring-gray-100 focus:ring-opacity-0">
        </div>
    </div> -->
>>>>>>> main
</div>
