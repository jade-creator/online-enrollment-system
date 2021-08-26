<div {{ $attributes->merge([ 'class' => 'flex items-center col-span-12 truncate md:border-0 border-t border-gray-300 font-bold text-xs']) }}>
    <p class="truncate">{{ $slot }}</p>
</div>
