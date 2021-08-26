<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="py-4 grid grid-cols-12 gap-2">
            <x-table.column-title class="col-span-1 text-blue-500">subject</x-table.column-title>
            <x-table.column-title class="col-span-2">monday</x-table.column-title>
            <x-table.column-title class="col-span-2">tuesday</x-table.column-title>
            <x-table.column-title class="col-span-2">wednesday</x-table.column-title>
            <x-table.column-title class="col-span-2">thursday</x-table.column-title>
            <x-table.column-title class="col-span-2">friday</x-table.column-title>
            <x-table.column-title class="col-span-1">action</x-table.column-title>
        </div>

        <div class="grid grid-cols-12 gap-2">
            @forelse ($section->schedules as $schedule)
                <x-table.cell class="md:col-span-1">{{ $schedule->subject->code ?? 'N/A' }}</x-table.cell>

                <x-table.cell class="md:col-span-2">
                    {{ $schedule->start_time_monday ? $schedule->start_time_monday : '' }}
                    <span>-</span>
                    {{ $schedule->end_time_monday ? \Carbon\Carbon::parse($schedule->end_time_monday)->format('g:ia') : '' }}
                </x-table.cell>

                <x-table.cell class="md:col-span-2">
                    {{ $schedule->start_time_tuesday ? \Carbon\Carbon::parse($schedule->start_time_tuesday)->format('g:ia'): '' }}
                </x-table.cell>

                <x-table.cell class="md:col-span-2">
                    {{ $schedule->start_time_wednesday ? \Carbon\Carbon::parse($schedule->start_time_wednesday)->format('g:ia') : '' }}
                </x-table.cell>

                <x-table.cell class="md:col-span-2">
                    {{ $schedule->start_time_thursday ? \Carbon\Carbon::parse($schedule->start_time_thursday)->format('g:ia') : '' }}
                </x-table.cell>

                <x-table.cell class="md:col-span-2">
                    {{ $schedule->start_time_friday ? \Carbon\Carbon::parse($schedule->start_time_friday)->format('g:ia') : '' }}
                </x-table.cell>

                <x-table.cell-action>
                    @can ('update', $schedule)
                        <button wire:click.prevent="$emit('modalViewingSchedule', {{ $schedule }})" class="hover:text-indigo-500 rounded-circle p-1 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Edit">
                            <x-icons.edit-icon/>
                        </button>
                    @elsecan ('view', App\Models\Schedule::class)
                        <x-table.cell-button title="Administrative Access">
                            <x-icons.lock-icon/>
                        </x-table.cell-button>
                    @endcan
                </x-table.cell-action>
            @empty
                <x-table.no-result>No added subject under the prospectus.🤔</x-table.no-result>
            @endforelse
        </div>
    </x-slot>
</x-table.nested-row>
