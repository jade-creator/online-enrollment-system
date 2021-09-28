<div class="flex flex-col lg:flex-row w-full lg:space-x-4 space-y-2 lg:space-y-0 mb-2 lg:mb-4">
    @isset($slot)
        {{ $slot }}
    @endisset
</div>
