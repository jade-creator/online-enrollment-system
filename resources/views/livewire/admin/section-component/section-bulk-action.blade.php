<x-table.bulk-action-bar :count="count($selected)">
    @can('create', App\Models\Section::class)
        <x-slot name="buttons">
            <x-table.bulk-action-button nameButton="Export" event="$toggle('confirmingExport')">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                        <polyline points="7 11 12 16 17 11"></polyline>
                        <line x1="12" y1="4" x2="12" y2="16"></line>
                    </svg>
                </x-slot>
            </x-table.bulk-action-button>

            <x-table.bulk-action-button nameButton="Release" event="releaseAll">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 19v2h16v-14l-8 -4l-8 4v2"></path>
                        <path d="M13 14h-9"></path>
                        <path d="M7 11l-3 3l3 3"></path>
                    </svg>
                </x-slot>
            </x-table.bulk-action-button>
        </x-slot>
    @endcan
</x-table.bulk-action-bar>
