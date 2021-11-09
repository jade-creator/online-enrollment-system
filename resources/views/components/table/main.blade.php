<div class="w-full mt-3">
    {{ $filter }}

    <div class="hidden md:grid grid-cols-12 gap-2 pl-1 py-2 ">
        {{ $head }}
    </div>

    <div wire:loading.class="hidden" wire:target="search, sortFieldSelected" class="grid mt-2">
        {{ $body }}
    </div>

    <div wire:loading class="w-full mt-2 animate-pulse" wire:target="search, sortFieldSelected">
        @for($i = 0; $i < 3; $i++)
            <div class="mt-2 w-full py-6 px-4 rounded-md shadow-md no-underline bg-white flex items-center justify-evenly">
                <div class="w-1/4 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
                <div class="w-1/2 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
                <div class="w-1/4 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
            </div>

            <div class="mt-2 w-full py-6 px-4 rounded-md shadow-md no-underline bg-white flex items-center justify-evenly">
                <div class="w-1/2 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
                <div class="w-1/4 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
                <div class="w-1/4 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
            </div>

            <div class="mt-2 w-full py-6 px-4 rounded-md shadow-md no-underline bg-white flex items-center justify-evenly">
                <div class="w-1/4 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
                <div class="w-1/4 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
                <div class="w-1/2 rounded-full h-4 bg-gray-100 mx-4">&nbsp;</div>
            </div>
        @endfor
    </div>

    <!-- Pagination and Datatable -->
    {{ $paginationLink }}
</div>



