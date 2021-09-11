<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="py-4 grid grid-cols-12 gap-2">
            <x-table.column-title class="col-span-2 text-blue-500">subject</x-table.column-title>
            <x-table.column-title class="col-span-3">title</x-table.column-title>
            <x-table.column-title class="col-span-2">Day</x-table.column-title>
            <x-table.column-title class="col-span-2">Start Time</x-table.column-title>
            <x-table.column-title class="col-span-2">End Time</x-table.column-title>
            <x-table.column-title class="col-span-1">action</x-table.column-title>
        </div>

        <div class="grid grid-cols-12 gap-2">
            @forelse ($section->schedules as $schedule)
                <x-table.cell class="md:col-span-2">{{ $schedule->subject->code ?? 'N/A' }}</x-table.cell>
                <x-table.cell class="md:col-span-3">{{ $schedule->subject->title ?? 'N/A' }}</x-table.cell>
                <x-table.cell class="md:col-span-2">{{ $schedule->day->name ?? 'N/A' }}</x-table.cell>
                <x-table.cell class="md:col-span-2">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i a') ?? 'N/A' }}</x-table.cell>
                <x-table.cell class="md:col-span-2">{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i a') ?? 'N/A' }}</x-table.cell>
                <x-table.cell-action>
                    @can ('update', $schedule)
                        <x-table.cell-button wire:click.prevent="$emit('modalViewingSchedule', {{ $section }}, {{ $schedule }})">
                            <x-icons.edit-icon/>
                        </x-table.cell-button>
                    @elsecan ('view', App\Models\Schedule::class)
                        <x-table.cell-button title="Administrative Access">
                            <x-icons.lock-icon/>
                        </x-table.cell-button>
                    @endcan
                </x-table.cell-action>
            @empty
                <x-table.no-result>No added classes yet.🤔</x-table.no-result>
            @endforelse
        </div>
    </x-slot>
</x-table.nested-row>
