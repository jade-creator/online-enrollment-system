<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="md:hidden grid grid-cols-12 place-items-center py-4 bg-indigo-500">
            <x-table.column-title class="col-span-12"><span class="text-white">Schedule for {{ $section->name ?? 'N/A' }}</span></x-table.column-title>
        </div>
        <div class="py-4 hidden md:grid grid-cols-12 gap-2 px-4 bg-indigo-500">
            <x-table.column-title class="col-span-2"><span class="text-white">subject</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">title</span></x-table.column-title>
            <x-table.column-title class="col-span-3"><span class="text-white">professor</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">day</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">time</span></x-table.column-title>
            <x-table.column-title class="col-span-1"><span class="text-white">action</span></x-table.column-title>
        </div>

        <div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
            @forelse ($section->schedules as $schedule)
                <x-table.cell headerLabel="Subject" class="md:col-span-2">{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="Title" class="md:col-span-2">{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="Professor" class="md:col-span-3">{{ $schedule->employee->user->person->full_name ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="Day" class="md:col-span-2">{{ $schedule->day->name ?? 'N/A' }}</x-table.cell>
                <x-table.cell headerLabel="Time" class="md:col-span-2">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i a') ?? 'N/A' }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i a') ?? 'N/A' }}</x-table.cell>
                <x-table.cell-action>
                    @can ('update', $schedule)
                        <button wire:click.prevent="$emit('modalViewingSchedule', {{ $section }}, {{ $schedule }})" title="Edit" class="w-min py-2 px-1 focus:outline-none hover:text-yellow-500">
                            <x-icons.edit-icon/>
                        </button>
                    @endcan

                    @can ('destroy', $schedule)
                        <button wire:click.prevent="$emit('removeScheduleConfirm', {{ $schedule }})" title="Delete" class="w-min py-2 px-1 focus:outline-none hover:text-red-500">
                            <x-icons.delete-icon/>
                        </button>
                    @endcan

                    <a href="{{ route('stream.class-list.pdf', [
                            'employee' => $schedule->employee,
                            'prospectusSubject' => $schedule->prospectusSubject,
                            'section' => $section
                        ]) }}" target="_blank">
                        <button title="Print Classlist" class="w-min py-2 px-1 focus:outline-none hover:text-indigo-500">
                            <x-icons.export-icon/>
                        </button>
                    </a>
                </x-table.cell-action>
            @empty
                <x-table.no-result>No added classes yet.🤔</x-table.no-result>
            @endforelse
        </div>
    </x-slot>
</x-table.nested-row>
