<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    <div class="py-10">
        <div class="flex items-center justify-between">
            <p class="font-bold text-lg">Pre Registration</p>
            <x-jet-button wire:click.prevent="createPDF" wire:loading.attr="disabled" class="ml-2 bg-indigo-700 hover:bg-indigo-800 flex items-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                    <path d="M5 8v-3a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5"></path>
                    <circle cx="6" cy="14" r="3"></circle>
                    <path d="M4.5 17l-1.5 5l3 -1.5l3 1.5l-1.5 -5"></path>
                </svg>
                <span>{{ __('Export to PDF')}}</span>
            </x-jet-button>
        </div>
        <x-jet-section-border/>
    </div>

    <x-jet-form-section submit="">
        <x-slot name="title">
            <div class="w-full text-sm font-semibold flex items-center justify-between">
                <p>Pre Registration Info</p>
                <p class="font-normal text-xs">{{ $registration->created_at->format('F j, Y') }}</p>
            </div>
        </x-slot>

        <x-slot name="description"></x-slot>

        <x-slot name="form">
            <form>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Registration ID:') }}"/>
                    <x-jet-input type="text" class="mt-1 block w-full" value="{{ $registration->id ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Status:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->status->name ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Program:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->prospectus->program->code ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Level:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->prospectus->level->level ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Term:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->prospectus->term->term ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('School Year:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->school_year ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Section:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->section->name ?? 'N/A' }}" readonly/>
                </div>
            </form>
        </x-slot>

        <x-slot name="actions"></x-slot>
    </x-jet-form-section>
    <x-jet-section-border/>

    <x-jet-form-section submit="">
        <x-slot name="title">
            <div class="w-full text-sm font-semibold flex items-center justify-between">
                <p>Student Details</p>
            </div>
        </x-slot>

        <x-slot name="description"></x-slot>

        <x-slot name="form">
            <form>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Student ID:') }}"/>
                    <x-jet-input type="text" class="mt-1 block w-full" value="{{ $registration->student->custom_id ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Type:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->is_new ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Name:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->full_name ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Email:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->email ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Mobile Number:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->contact->mobile_number ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Address:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->contact->address ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Birthdate:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->birthdate->format('F j, Y') ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Birthplace:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->birthplace ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Gender:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->gender ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Civil Status:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->civil_status ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Religion:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->civil_status ?? 'N/A' }}" readonly/>
                </div>
                <div class="col-span-3">
                    <x-jet-label value="{{ __('Nationality:') }}"/>
                    <x-jet-input type="text" class="mt-1" value="{{ $registration->student->user->person->detail->country->name ?? 'N/A' }}" readonly/>
                </div>
            </form>
        </x-slot>

        <x-slot name="actions"></x-slot>
    </x-jet-form-section>
    <x-jet-section-border/>

    <x-jet-form-section submit="">
        <x-slot name="title">
            <div class="w-full text-sm font-semibold flex items-center justify-between">
                <p><span>{{ $registration->prospectus->level->level . ' - ' ?? 'N/A' }}</span>
                    <span>{{ $registration->prospectus->term->term . ' - ' ?? 'N/A' }}</span>Selected subject/s</p>
                <p class="font-normal text-xs">Total Units: {{ $registration->grades->sum('prospectus_subject.unit') }}</p>
            </div>
        </x-slot>

        <x-slot name="description"></x-slot>

        <x-slot name="form">
            <table class="col-span-6">
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

    @if ($registration->extensions->isNotEmpty())
        @foreach ($registration->extensions as $extension)
            <x-jet-form-section submit="">
                <x-slot name="title">
                    <div class="w-full text-sm font-semibold flex items-center justify-between">
                        <p><span>{{ $extension->registration->prospectus->level->level . ' - ' ?? 'N/A' }}</span>
                            <span>{{ $extension->registration->prospectus->term->term . ' - ' ?? 'N/A' }}</span>Selected subject/s</p>
                        <p class="font-normal text-xs">Total Units: {{ $extension->registration->grades->sum('prospectus_subject.unit') }}</p>
                    </div>
                </x-slot>

                <x-slot name="description"></x-slot>

                <x-slot name="form">
                    <table class="col-span-6">
                        @if (! isset($extension->registration->section->name))
                            <thead>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Unit</th>
                            <th>Pre Requisite</th>
                            </thead>
                            <tbody>
                            @forelse ($extension->registration->grades as $grade)
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
                            @forelse ($extension->registration->classes as $schedule)
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
                    @can ('selectSection', $extension->registration)
                        <x-jet-button wire:click.prevent="$emit('modalAddingClasses', {{ $extension->registration }})" wire:loading.attr="disabled" class="{{ is_null($extension->registration->section_id) ? 'bg-green-500 hover:bg-green-800' : 'bg-indigo-500 hover:bg-indigo-800' }}">
                            @if (is_null($extension->registration->section_id))
                                <span>{{ __('Select Section') }}</span>
                            @else
                                <span>{{ __('Update Section') }}</span>
                            @endif
                        </x-jet-button>
                    @endcan
                </x-slot>
            </x-jet-form-section>
            <x-jet-section-border/>
        @endforeach
    @endif

{{--    <div class="w-full mb-10"> TODO: fee module--}}
{{--        <div class="w-full bg-blue-100 bg-opacity-20 border-t border-l border-r border-blue-200 p-4 rounded-t-md font-semibold flex items-center justify-between">--}}
{{--            <p>Assessment</p>--}}
{{--            <p class="font-normal text-xs">Total: PHP {{ number_format((float)$registration->prospectus->fees->sum('price'), 2, '.', ',') }}</p>--}}
{{--        </div>--}}
{{--        <div class="border-b border-l border-r border-gray-200 rounded-b-md p-4">--}}
{{--            <table class="w-full">--}}
{{--                <thead>--}}
{{--                <th></th>--}}
{{--                <th></th>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @forelse ($registration->prospectus->fees as $fee)--}}
{{--                    <tr>--}}
{{--                        <td class="pb-4 text-left font-bold">{{ $fee->name ?? 'N/A' }}</td>--}}
{{--                        <td class="pb-4 text-left">PHP {{ number_format((float)$fee->price, 2, '.', ',') ?? 'N/A' }}</td>--}}
{{--                    </tr>--}}
{{--                @empty--}}
{{--                    <tr>--}}
{{--                        <td rowspan="2">No Payment Found.</td>--}}
{{--                    </tr>--}}
{{--                @endforelse--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}

    {{--Main action buttons: submit,enroll,pending,reject--}}
    <livewire:partials.registration-form-buttons :registration="$registration" key="{{ 'registration-form-buttons-'.now() }}">

    {{--Modal form: selecting section and apply schedules--}}
    <livewire:partials.select-section-form key="{{ 'select-section-form-'.now() }}">

    <div wire:loading>
        @include('partials.loading')
    </div>
</div>
