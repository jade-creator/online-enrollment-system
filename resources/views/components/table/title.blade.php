@props([ 'tableTitle', 'isSelectedAll', 'count', 'route', 'routeTitle' ])

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
        <a href="{{ $route }}" class="focus:outline-none focus:ring-2 focus:bg-blue-500 focus:ring-opacity-50 btn btn-default bg-blue-500 hover:bg-blue-600 text-white py-2.5 px-4 font-bold text-xs rounded-lg border border-white">{{ $routeTitle }}</a>
    </div>
</div>