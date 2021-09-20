<div>
    @if (isset($registration))
        <x-jet-form-section submit="">
            <x-slot name="title">
                <div class="w-full text-sm font-semibold flex items-center justify-between">
                    <p><span>{{ $registration->prospectus->level->level . ' - ' ?? 'N/A' }}</span>
                        <span>{{ $registration->prospectus->term->term . ' - ' ?? 'N/A' }}</span>Selected subject/s</p>
                    <p class="font-normal text-xs">Total Units: {{ $registration->grades->sum('prospectus_subject.unit') }}</p>
                </div>
            </x-slot>

            <x-slot name="description">
                {{-- OPTIONAL --}}
            </x-slot>

            <x-slot name="form">
                <table class="col-span-6">
                    {{--  DISPLAY LIST OF ENROLLED SUBJECTS IF NO SELECTED SECTION  --}}
                    @if (! isset($registration->section->name))
                        <thead>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Unit</th>
                            <th>Pre Requisite</th>
                        </thead>
                        <tbody>
                        @forelse ($registration->grades as $grade)
                            <tr>
                                <td class="pb-4 text-center">{{ $grade->prospectus_subject->subject->id ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ $grade->prospectus_subject->unit ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">
                                    @forelse ($grade->prospectus_subject->prerequisites as $requisite)
                                        {{ $loop->first ? '' : ', '  }}
                                        <span>{{ $requisite->code }}</span>
                                    @empty
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <x-table.no-result>No subjects found. 🤔</x-table.no-result>
                        @endforelse
                        </tbody>
                    {{--  DISPLAY LIST OF SCHEDULE IF THERE'S A SELECTED SECTION  --}}
                    @else
                        <thead>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Section</th>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Unit</th>
                        </thead>
                        @forelse ($registration->classes as $schedule)
                            <tr>
                                <td class="pb-4 text-center">{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ $schedule->section->name ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ $schedule->day->name ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ \Carbon\Carbon::parse($schedule->start_time)->format('g: ia') ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ \Carbon\Carbon::parse($schedule->end_time)->format('g: ia') ?? 'N/A' }}</td>
                                <td class="pb-4 text-center">{{ $schedule->prospectusSubject->unit ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <x-table.no-result>No schedules found. 🤔</x-table.no-result>
                        @endforelse
                    @endif
                </table>
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
