@props(['count'])

@if ( $count > 0)
    <div class="fixed right-0 bottom-0 pb-3 w-full bg-white bg-opacity-40 border-t border-gray-200" style="backdrop-filter: blur(20px);">
        <div class="flex items-center justify-end min-full">
            <div class="flex pr-5">
                <x-table.bulk-action-button nameButton="Cancel" event="$emit('DeselectPage', false)">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="9" y1="6" x2="20" y2="6"></line>
                            <line x1="9" y1="12" x2="20" y2="12"></line>
                            <line x1="9" y1="18" x2="20" y2="18"></line>
                            <line x1="5" y1="6" x2="5" y2="6.01"></line>
                            <line x1="5" y1="12" x2="5" y2="12.01"></line>
                            <line x1="5" y1="18" x2="5" y2="18.01"></line>
                        </svg>
                    </x-slot>
                </x-table.bulk-action-button>
            </div>
            <div class="py-3 border-r border-gray-300">&nbsp;</div>
            <div class="flex items-align pl-5">
                {{ $buttons }}

                <x-table.bulk-action-button nameButton="Select All" event="selectAll">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3.5 5.5l1.5 1.5l2.5 -2.5"></path>
                            <path d="M3.5 11.5l1.5 1.5l2.5 -2.5"></path>
                            <path d="M3.5 17.5l1.5 1.5l2.5 -2.5"></path>
                            <line x1="11" y1="6" x2="20" y2="6"></line>
                            <line x1="11" y1="12" x2="20" y2="12"></line>
                            <line x1="11" y1="18" x2="20" y2="18"></line>
                        </svg>
                    </x-slot>
                </x-table.bulk-action-button>
            </div>
        </div>
    </div>
@endif