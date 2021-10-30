@props([ 'title' => 'N/A' ])

<li title="{{ $title }}" {{ $attributes }}>
    {{ $slot }}
</li>
