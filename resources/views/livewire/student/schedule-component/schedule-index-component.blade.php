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
                <table class="col-span-6">
                    {{--  DISPLAY LIST OF ENROLLED SUBJECTS IF NO SELECTED SECTION  --}}
                    @if (! isset($registration->section->name))
                        <thead>
                            <tr class="text-gray-500 border-b">
                                <th>ID</th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Pre Requisite</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($registration->grades as $grade)
                            <tr>
                                <td class="pb-2 pt-4 text-center">{{ $grade->prospectus_subject->subject->id ?? 'N/A' }}</td>
                                <td class="pb-2 text-center">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</td>
                                <td class="pb-2 text-center">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</td>
                                <td class="pb-2 text-center">{{ $grade->prospectus_subject->unit ?? 'N/A' }}</td>
                                <td class="pb-2 text-center">
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
                            <tr class="text-gray-400 border-b">
                                <th class="pb-2">Subject Code</th>
                                <th class="pb-2">Subject Name</th>
                                <th class="pb-2">Section</th>
                                <th class="pb-2">Day</th>
                                <th class="pb-2">Start Time</th>
                                <th class="pb-2">End Time</th>
                                <th class="pb-2">Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($registration->classes as $schedule)
                            <tr class="text-center">
                                <td class="pt-2">{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</td>
                                <td class="pt-2">{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</td>
                                <td class="pt-2">{{ $schedule->section->name ?? 'N/A' }}</td>
                                <td class="pt-2">{{ $schedule->day->name ?? 'N/A' }}</td>
                                <td class="pt-2">{{ \Carbon\Carbon::parse($schedule->start_time)->format('g: ia') ?? 'N/A' }}</td>
                                <td class="pt-2">{{ \Carbon\Carbon::parse($schedule->end_time)->format('g: ia') ?? 'N/A' }}</td>
                                <td class="pt-2">{{ $schedule->prospectusSubject->unit ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <x-table.no-result>No schedules found. 🤔</x-table.no-result>
                        @endforelse
                        </tbody>
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
