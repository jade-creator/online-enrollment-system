@props(['title', 'value', 'default' => true])

<div class="widget w-full p-4 rounded-lg bg-white border border-gray-100 shadow dark:bg-gray-900 dark:border-gray-800">
    @if ($default)
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-col">
                <div class="text-xs uppercase font-light text-gray-500">{{ $title ?? 'N/A' }}</div>
                <div class="text-xl font-bold">{{ $value ?? 'N/A' }}</div>
            </div>
            {{-- icon slot --}}
            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
    @else
        {{-- custom content eg. recently enrolled widget--}}
        @isset($slot)
            {{ $slot }}
        @endisset
    @endif
</div>
