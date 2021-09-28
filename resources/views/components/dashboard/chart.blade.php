<div class="flex flex-wrap w-full justify-around bg-white rounded-lg p-4 border border-gray-100 shadow overflow-hidden dark:bg-gray-900 dark:border-gray-800">
    @isset($slot)
        {{ $slot }}
    @endisset
</div>
