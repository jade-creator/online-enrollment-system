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
                    <span class="py-3 px-4 mr-1">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <button wire:click="previousPage" rel="prev" class="mr-1 py-3 px-4 rounded-l-lg bg-gray-200 transition-colors duration-500 focus:outline-none focus:bg-gray-300" title="Previous Page">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" rel="next" class="py-3 px-4 rounded-r-lg bg-gray-200 transition-colors duration-500 focus:outline-none focus:bg-gray-300" title="Next Page">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @else
                    <span class="py-3 px-4 text-gray-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>