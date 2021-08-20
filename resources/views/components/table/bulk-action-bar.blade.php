@props(['count'])

@if ( $count > 0)
    <div class="fixed right-0 bottom-0 pb-3 w-full bg-white bg-opacity-40 border-t border-gray-200" style="backdrop-filter: blur(20px);">
        <div class="flex items-center justify-end min-full">
            <div class="flex pr-5">
                <x-table.bulk-action-button nameButton="Cancel" event="$emit('DeselectPage', false)">
                    <x-icons.cancel-icon/>
                </x-table.bulk-action-button>
            </div>
            <div class="py-3 border-r border-gray-300">&nbsp;</div>
            <div class="flex items-align pl-5">
                {{ $slot }}

                <x-table.bulk-action-button nameButton="Select All" event="selectAll">
                    <x-icons.select-icon/>
                </x-table.bulk-action-button>
            </div>
        </div>
    </div>
@endif
