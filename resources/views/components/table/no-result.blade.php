@props([ 'title' ])

<div class="col-span-12 md:border-0 border-t border-gray-300">
    <div class="flex flex-col items-center bg-white p-4 my-2 rounded-lg shadow border-t border-l border-r border-gray-200">
        <h4 class="font-bold">{{ $title }}</h4>
        <p class="text-xs text-gray-500">{{ __('Please double check the filters.') }}</p>
    </div>
</div>