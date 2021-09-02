<div class="py-3 mb-1">
    <div class="flex flex-col md:flex-row space-x-3 items-center md:justify-between text-gray-600">
        <div class="flex flex-wrap justify-end items-center">
            <div class="flex items-center mb-2 md:mb-0 md:mr-3">
                <h5 class="mr-3">{{ __('Displaying ')}}
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

                <select wire:model="paginateValue" id="result" aria-label="Result per page" class="w-full bg-white border-b border-gray-200 flex-1 px-5 py-2 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="flex items-center">
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

            <!-- paginator Counter -->
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
