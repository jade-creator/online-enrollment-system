@props(['title'])

<div class="my-4">
    <label>{{ $title }}</label>
    <div class="relative w-full">
        {{ $slot }}
    </div>
</div>
