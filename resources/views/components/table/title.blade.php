@props([ 'tableTitle', 'isSelectedAll', 'count' ])

<div class="mb-4 pb-3 border-b border-gray-200">
    <div class="flex items-center justify-between">
        <div class="flex items-center justify-between">
            <div class="text-2xl font-bold text-gray-500">{{ $tableTitle }}</div>

            @if ( $count > 0 && !$isSelectedAll )
                <div class="px-2 text-green-600 font-bold">{{ __('[')}}
                    <span>{{ $count }}</span>
                    <span>{{ __('selected ]')}}</span>
                </div>
            @endif

            @if ( $isSelectedAll )
                <div class="px-2 text-green-600 font-bold">{{ __('[')}}
                    <span>{{ __('selected all ')}}</span>
                    <span>{{ $count }}</span>
                    <span>{{ __(' records ]')}}</span>
                </div>
            @endif
        </div>

        {{ $slot }}
    </div>
</div>
