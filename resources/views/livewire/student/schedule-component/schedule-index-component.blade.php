<div>
    @if (isset($registration))
        <x-jet-form-section submit="">
            <x-slot name="title">
                <div class="w-full text-sm font-semibold flex items-center justify-between">
                    <p><span>{{ $registration->prospectus->level->level . ' - ' ?? 'N/A' }}</span>
                        <span>{{ $registration->prospectus->term->term . ' - ' ?? 'N/A' }}</span>Selected subject/s</p>
                    <p class="font-normal text-xs">Total Units: {{ $registration->total_unit }}</p>
                </div>
            </x-slot>

            <x-slot name="description">
                {{-- OPTIONAL --}}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    {{--  DISPLAY LIST OF ENROLLED SUBJECTS IF NO SELECTED SECTION  --}}
                    @if (! isset($registration->section->name))
                        <div class="mb-4 grid grid-cols-8 gap-2 col-span-6 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">
                            <div class="col-span-1">code</div>
                            <div class="col-span-2">title</div>
                            <div class="col-span-1">unit</div>
                            <div class="col-span-2">co requisite</div>
                            <div class="col-span-2">pre requisite</div>
                        </div>
                        <div class="grid grid-cols-8 gap-2 col-span-6 py-2 text-left">
                            @forelse ($registration->grades as $grade)
                                <div class="col-span-1">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</div>
                                <div class="col-span-2 truncate">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</div>
                                <div class="col-span-1">{{ $grade->prospectus_subject->unit ?? 'N/A' }}</div>
                                <div class="col-span-2">
                                    @forelse ($grade->prospectus_subject->corequisites as $requisite)
                                        {{ $loop->first ? '' : ', '  }}
                                        <span>&nbsp;{{ $requisite->code }}</span>
                                    @empty
                                        N/A
                                    @endforelse
                                </div>
                                <div class="col-span-2">
                                    @forelse ($grade->prospectus_subject->prerequisites as $requisite)
                                        {{ $loop->first ? '' : ', '  }}
                                        <span>&nbsp;{{ $requisite->code }}</span>
                                    @empty
                                        N/A
                                    @endforelse
                                </div>
                            @empty
                                <x-table.no-result>No subjects found. Sorry! Unable to register.🤔</x-table.no-result>
                            @endforelse
                        </div>

                    {{--  DISPLAY LIST OF SCHEDULE IF THERE'S A SELECTED SECTION  --}}
                    @else
                        <div class="mb-4 grid grid-cols-8 gap-2 col-span-6 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">
                            <div class="col-span-1">code</div>
                            <div class="col-span-1">title</div>
                            <div class="col-span-1">professor</div>
                            <div class="col-span-1">section</div>
                            <div class="col-span-1">day</div>
                            <div class="col-span-1">start time</div>
                            <div class="col-span-1">end time</div>
                            <div class="col-span-1">unit</div>
                        </div>
                        <div class="grid grid-cols-8 gap-2 col-span-6 py-2 text-left text-xs">
                            @forelse ($registration->classes as $schedule)
                                <div class="col-span-1">{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</div>
                                <div class="col-span-1 truncate">{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</div>
                                <div class="col-span-1">{{ $schedule->employee->user->person->full_name ?? 'N/A' }}</div>
                                <div class="col-span-1">{{ $schedule->section->name ?? 'N/A' }}</div>
                                <div class="col-span-1">{{ $schedule->day->name ?? 'N/A' }}</div>
                                <div class="col-span-1">{{ \Carbon\Carbon::parse($schedule->start_time)->format('g: ia') ?? 'N/A' }}</div>
                                <div class="col-span-1">{{ \Carbon\Carbon::parse($schedule->end_time)->format('g: ia') ?? 'N/A' }}</div>
                                <div class="col-span-1">{{ $schedule->prospectusSubject->unit ?? 'N/A' }}</div>
                            @empty
                                <x-table.no-result>No subjects found. Sorry! Unable to register.🤔</x-table.no-result>
                            @endforelse
                        </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="actions">
                @can ('selectSection', $registration)
                    <x-jet-button wire:click.prevent="$emit('modalAddingClasses', {{ $registration }})" wire:loading.attr="disabled" class="{{ is_null($registration->section_id) ? 'bg-green-500 hover:bg-green-800' : 'bg-indigo-500 hover:bg-indigo-800' }}">
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
