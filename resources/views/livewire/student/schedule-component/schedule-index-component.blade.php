<div>
    @if (isset($registration))
        <x-jet-form-section submit="">
            <x-slot name="title">
                <div class="w-full text-sm font-semibold flex flex-wrap gap-5 items-center justify-between">
                    <p><span>{{ $registration->prospectus->level->level . ' - ' ?? 'N/A' }}</span>
                        <span>{{ $registration->prospectus->term->term . ' - ' ?? 'N/A' }}</span>Selected subject/s</p>
                    <p class="font-normal text-xs">Total Units: {{ $registration->total_unit }}</p>
                </div>
            </x-slot>

            <x-slot name="description"></x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    <x-table.main>
                        <x-slot name="filter"></x-slot>
                        <x-slot name="paginationLink"></x-slot>
                        @if (! isset($registration->section->name))
                            <x-slot name="head">
                                <x-table.column-title class="col-span-2">code</x-table.column-title>
                                <x-table.column-title class="col-span-2">title</x-table.column-title>
                                <x-table.column-title class="col-span-2">unit</x-table.column-title>
                                <x-table.column-title class="col-span-3">co requisite</x-table.column-title>
                                <x-table.column-title class="col-span-3">pre requisite</x-table.column-title>
                            </x-slot>
                        @else
                            <x-slot name="head">
                                <x-table.column-title class="col-span-2">subject</x-table.column-title>
                                @if ( auth()->user()->role->name == 'student' && ($registration->status->name !== 'enrolled' && $registration->status->name !== 'released') )
                                    <x-table.column-title class="col-span-3">title</x-table.column-title>
                                @else
                                    <x-table.column-title class="col-span-3">professor</x-table.column-title>
                                @endif
                                <x-table.column-title class="col-span-2">section</x-table.column-title>
                                <x-table.column-title class="col-span-2">day</x-table.column-title>
                                <x-table.column-title class="col-span-2">time</x-table.column-title>
                                <x-table.column-title class="col-span-1">unit</x-table.column-title>
                            </x-slot>
                        @endif

                        <x-slot name="body">
                            {{--  DISPLAY LIST OF ENROLLED SUBJECTS IF NO SELECTED SECTION  --}}
                            @if (! isset($registration->section->name))
                                @forelse ($registration->grades as $grade)
                                    <div wire:key="table-row-{{$grade->prospectus_subject->subject->code}}">
                                        <x-table.row>
                                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                                <x-table.cell headerLabel="Code" class="justify-start md:col-span-2">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
                                                <x-table.cell headerLabel="title" class="justify-start truncate md:col-span-2">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                                                <x-table.cell headerLabel="unit" class="justify-start md:col-span-2">{{ $grade->prospectus_subject->unit ?? 'N/A' }}</x-table.cell>
                                                <x-table.cell headerLabel="co requisite" class="justify-start md:col-span-3">
                                                    @forelse ($grade->prospectus_subject->corequisites as $requisite)
                                                        {{ $loop->first ? '' : ', '  }}
                                                        <span>&nbsp;{{ $requisite->code }}</span>
                                                    @empty
                                                        {!! '<span class="text-gray-400">N/A</span>' !!}
                                                    @endforelse
                                                </x-table.cell>
                                                <x-table.cell headerLabel="pre requisite" class="justify-start md:col-span-3">
                                                    @forelse ($grade->prospectus_subject->prerequisites as $requisite)
                                                        {{ $loop->first ? '' : ', '  }}
                                                        <span>&nbsp;{{ $requisite->code }}</span>
                                                    @empty
                                                        {!! '<span class="text-gray-400">N/A</span>' !!}
                                                    @endforelse
                                                </x-table.cell>
                                            </div>
                                        </x-table.row>
                                    </div>
                                @empty
                                    <x-table.no-result>No subjects found. Sorry! Unable to register.🤔</x-table.no-result>
                                @endforelse
                            @else
                                @forelse ($registration->classes as $schedule)
                                    <div wire:key="table-row-{{$schedule->prospectusSubject->subject->code}}">
                                        <x-table.row>
                                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                                <x-table.cell headerLabel="code" class="md:col-span-2">{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</x-table.cell>
                                                @if ( auth()->user()->role->name == 'student' && ($registration->status->name !== 'enrolled' && $registration->status->name !== 'released') )
                                                    <x-table.cell headerLabel="title" class="truncate md:col-span-3">{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</x-table.cell>
                                                @else
                                                    <x-table.cell headerLabel="professor" class="truncate md:col-span-3">
                                                        <span>{{ $schedule->employee->user->salutation ?? '' }}</span>
                                                        <span>{{ $schedule->employee->user->person->full_name ?? 'N/A' }}</span>
                                                    </x-table.cell>
                                                @endif
                                                <x-table.cell headerLabel="section" class="md:col-span-2">{{ $schedule->section->name ?? 'N/A' }}</x-table.cell>
                                                <x-table.cell headerLabel="day" class="md:col-span-2">{{ $schedule->day->name ?? 'N/A' }}</x-table.cell>
                                                <x-table.cell headerLabel="time" class="md:col-span-2">
                                                    <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g: ia') ?? 'N/A' }}</span>
                                                    <span>-</span>
                                                    <span>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g: ia') ?? 'N/A' }}</span>
                                                </x-table.cell>
                                                <x-table.cell headerLabel="unit" class="md:col-span-1 justify-center">{{ $schedule->prospectusSubject->unit ?? 'N/A' }}</x-table.cell>
                                            </div>
                                        </x-table.row>
                                    </div>
                                @empty
                                    <x-table.no-result>No subjects found. Sorry! Unable to register.🤔</x-table.no-result>
                                @endforelse
                            @endif
                        </x-slot>
                    </x-table.main>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can ('selectSection', $registration)
                    <x-jet-button  wire:click.prevent="$emit('modalAddingClasses', {{ $registration }})" class="{{ is_null($registration->section_id) ? 'bg-green-500 hover:bg-green-800' : 'bg-indigo-500 hover:bg-indigo-800' }}">
                        @if (is_null($registration->section_id))
                            <span>{{ __('Select Section') }}</span>
                        @else
                            <span>{{ __('Update Section') }}</span>
                        @endif
                    </x-jet-button>
                @endcan
            </x-slot>
        </x-jet-form-section>
        <x-jet-section-border/>
    @endif
</div>
