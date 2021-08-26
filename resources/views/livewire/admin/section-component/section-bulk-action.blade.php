<x-table.bulk-action-bar :count="count($selected)">
    @can('create', App\Models\Section::class)
        <x-table.bulk-action-button nameButton="Export" event="$toggle('confirmingExport')">
            <x-icons.export-icon/>
        </x-table.bulk-action-button>

        <x-table.bulk-action-button nameButton="Release" event="releaseAll">
            <x-icons.release-icon/>
        </x-table.bulk-action-button>
    @endcan
</x-table.bulk-action-bar>
