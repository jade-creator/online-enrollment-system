<div class="py-3 mb-1">
    <div class="flex items-center justify-between text-gray-600">
        <h5>{{ __('Displaying ')}}
            @if ($paginator->total() > 0)
                <span class="font-bold">{{ $paginator->firstItem() }}</span>
                <span>{{ __('to ')}}</span>
                <span class="font-bold">{{ $paginator->lastItem() }}</span>
            @else
                <span class="font-bold">{{ __('0')}}</span>
                <span>{{ __('to ')}}</span>
                <span class="font-bold">{{ __('0')}}</span>
            @endif
        </h5>

        <div class="flex items-center justify-between">
            @if ($paginator->hasPages())
                <h5 class="pr-2">
                    <span class="font-bold">{{ $paginator->currentPage() }}</span>
                    <span>{{ __(' - ')}}</span>
                    <span class="font-bold">{{ $paginator->lastPage() }}</span>
                </h5>
            @else
                <h5 class="pr-2">
                    <span>{{ __('--')}}</span>
                </h5>
            @endif
            <div class="flex">
                @if ($paginator->onFirstPage())
                    <span class="py-3 px-4 mr-1 text-gray-400">
                        <x-icons.left-arrow-icon/>
                    </span>
                @else
                    <button wire:click="previousPage" rel="prev" class="mr-1 py-3 px-4 rounded-l-lg bg-gray-200 transition-colors duration-500 focus:outline-none focus:bg-gray-300" title="Previous Page">
                        <x-icons.left-arrow-icon/>
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" rel="next" class="py-3 px-4 rounded-r-lg bg-gray-200 transition-colors duration-500 focus:outline-none focus:bg-gray-300" title="Next Page">
                        <x-icons.right-arrow-icon/>
                    </button>
                @else
                    <span class="py-3 px-4 text-gray-400">
                        <x-icons.right-arrow-icon/>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
