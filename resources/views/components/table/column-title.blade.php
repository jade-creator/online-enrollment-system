@props(['columnTitle'])

<div {{ $attributes->merge(['class' => 'font-bold text-xs text-gray-400 uppercase tracking-widest']) }}>{{ $columnTitle }}</div>
