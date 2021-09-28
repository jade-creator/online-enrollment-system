@props(['minWidth'])

@php
    $minWidth = [
     '1' => 'lg:w-1/4',
     '2' => 'lg:w-2/4',
     '3' => 'lg:w-3/4',
     '4' => 'lg:w-4/4',
    ][$minWidth ?? '1'];
    // if minWidth is null, 1 is the default
@endphp

<div class="w-full {{ $minWidth }}">
    @isset($slot)
        {{ $slot }}
    @endisset
</div>
