<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="md:hidden grid grid-cols-12 place-items-center py-4 bg-indigo-500">
            <x-table.column-title class="col-span-12"><span class="text-white">Schedule for {currentSectionName}</span></x-table.column-title>
        </div>
        <div class="py-4 hidden md:grid grid-cols-12 gap-2 px-4 bg-indigo-500">
            <x-table.column-title class="col-span-2"><span class="text-white">subject</span></x-table.column-title>
            <x-table.column-title class="col-span-3"><span class="text-white">title</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">day</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">start time</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">end time</span></x-table.column-title>
            <x-table.column-title class="col-span-1"><span class="text-white">action</span></x-table.column-title>
        </div>

        <div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
            @forelse ($section->schedules as $schedule)
                <x-table.cell headerLabel="Subject" class="md:col-span-2">{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="Title" class="md:col-span-3">{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="Day" class="md:col-span-2">{{ $schedule->day->name ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="Start Time" class="md:col-span-2">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i a') ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="End Time" class="md:col-span-2">{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i a') ?? 'N/A' }}</x-table.cell>
                <x-table.cell-action>
                    @can ('update', $schedule)
                        <x-table.cell-button wire:click.prevent="$emit('modalViewingSchedule', {{ $section }}, {{ $schedule }})">
                            <div class="w-full text-center">
                                <x-icons.edit-icon class="hidden md:block"/>
                                <div class="flex justify-center md:hidden">
                                    <span>Edit</span>
                                    <x-icons.corner-right-up />
                                </div>
                            </div>
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
