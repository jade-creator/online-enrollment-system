<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="py-4 grid grid-cols-12 gap-2">
            <x-table.column-title columnTitle="subject" class="col-span-1 text-blue-500"/>
            <x-table.column-title columnTitle="monday" class="col-span-2"/>
            <x-table.column-title columnTitle="tuesday" class="col-span-2"/>
            <x-table.column-title columnTitle="wednesday" class="col-span-2"/>
            <x-table.column-title columnTitle="thursday" class="col-span-2"/>
            <x-table.column-title columnTitle="friday" class="col-span-2"/>
            <x-table.column-title columnTitle="action" class="col-span-1"/>
        </div>

        <div class="grid grid-cols-12 gap-2">
            @forelse ($section->schedules as $schedule)
                <x-table.cell :value="$schedule->subject->code" classes="md:col-span-1"/>

                <x-table.cell :value="$schedule->start_time_monday ? \Carbon\Carbon::parse($schedule->start_time_monday)->format('g:ia') : '--'"
                    classes="md:col-span-2"/>

                <x-table.cell :value="$schedule->start_time_tuesday ? \Carbon\Carbon::parse($schedule->start_time_tuesday)->format('g:ia'): '--'"
                    classes="md:col-span-2"/>

                <x-table.cell :value="$schedule->start_time_wednesday ? \Carbon\Carbon::parse($schedule->start_time_wednesday)->format('g:ia') : '--'"
                    classes="md:col-span-2"/>

                <x-table.cell :value="$schedule->start_time_thursday ? \Carbon\Carbon::parse($schedule->start_time_thursday)->format('g:ia') : '--'"
                    classes="md:col-span-2"/>

                <x-table.cell :value="$schedule->start_time_friday ? \Carbon\Carbon::parse($schedule->start_time_friday)->format('g:ia') : '--'"
                    classes="md:col-span-2"/>

                <x-table.cell-action>
                    <x-slot name="container">
                        @if (auth()->user()->role->name == 'admin')
                            <button wire:click="updatedAddingSchedule({{ $schedule->id }})" class="hover:text-indigo-500 rounded-circle p-1 mx-1 focus:outline-none" data-toggle="tooltip" data-placement="top" title="Edit">
                                <x-icons.edit-icon/>
                            </button>
                        @else
                            <x-table.cell-button title="Administrative Access">
                                <x-slot name="icon">
                                    <x-icons.lock-icon/>
                                </x-slot>
                            </x-table.cell-button>
                        @endif
                    </x-slot>
                </x-table.cell-action>
            @empty
                <div class="py-4 col-span-12 md:col-span-12 font-bold text-xs">
                    <p class="truncate text-center">No added subject under the prospectus.</p>
                </div>
            @endforelse
        </div>
    </x-slot>
</x-table.nested-row>
