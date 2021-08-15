@props(['value', 'classes'])

<div class="flex items-center col-span-12 truncate md:border-0 border-t border-gray-300 font-bold text-xs {{ $classes }}">
    <p class="truncate">{{ $value ?? 'N/A' }}</p>
</div>
