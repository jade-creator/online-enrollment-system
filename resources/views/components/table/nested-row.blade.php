<div x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-90"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-90"
     class="w-full py-2 px-4 my-1 rounded shadow hover:shadow-md bg-white border-t border-l border-r border-gray-200 border-opacity-80"
     x-cloak>

    {{ $nestedTable }}
</div>
