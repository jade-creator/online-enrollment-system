<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Pre Registrations">
            <x-table.nav-button wire:click="createNewRegistration">
                Create New Registration
            </x-table.nav-button>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter>
                    <x-table.filter-slot title="Archive">
                        <select wire:model="isArchived" wire:loading.attr="disabled" name="Archive" class="w-full flex-1">
                            <option value="">All</option>
                            <option value="0">Active</option>
                            <option value="1">Archived</option>
                        </select>
                    </x-table.filter-slot>
                    <x-table.filter-slot title="Status">
                        <select wire:model="statusId" wire:loading.attr="disabled" name="statusId">
                            <option value="">All</option>
                            <option value="1">Pending</option>
                            <option value="2">Confirming</option>
                            <option value="3">Finalized</option>
                            <option value="4">Enrolled</option>
                            <option value="5">Denied</option>
                        </select>
                    </x-table.filter-slot>
                    <x-table.filter-slot title="Program">
                        <select wire:model="programId" wire:loading.attr="disabled" name="programId">
                            <option value="">All</option>
                            @forelse ($this->programs as $program)
                                <option value="{{ $program->id }}">{{ $program->code }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                    </x-table.filter-slot>
                    <x-table.filter-slot title="Level">
                        <select wire:model="levelId" wire:loading.attr="disabled" name="levelId">
                            <option value="">All</option>
                            <option value="14">1st Year</option>
                            <option value="15">2nd Year</option>
                            <option value="16">3rd Year</option>
                            <option value="17">4th Year</option>
                            <option value="18">5th Year</option>
                        </select>
                    </x-table.filter-slot>
                    <x-table.filter-slot title="Semester">
                        <select wire:model="termId" wire:loading.attr="disabled" name="termId">
                            <option value="">All</option>
                            <option value="1">1st Semester</option>
                            <option value="2">2nd Semester</option>
                        </select>
                    </x-table.filter-slot>
                </x-table.filter>
            </x-slot>

            <x-slot name="paginationLink">{{ $registrations->links('partials.pagination-link') }}</x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-center">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox" title="Select Displayed Data" class="mx-5">
                    <x-table.sort-button event="sortFieldSelected('id')">reg. ID</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-2">Student</x-table.column-title>
                <x-table.column-title class="col-span-3">Program</x-table.column-title>
                <x-table.column-title class="col-span-2">section</x-table.column-title>
                <x-table.column-title class="col-span-2">status</x-table.column-title>
                <div class="col-span-1"><x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button></div>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div wire:key="table-row-{{$registration->id}}">
                        <x-table.row>
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$registration->id">
                                    <div class="hidden md:block mx-1 flex flex-col" title="classification: {{ $registration->classification ?? 'N/A' }}">
                                        @if (empty($registration->assessment))
                                            <div class="flex items-center">
                                                <div class="font-bold rounded-full bg-yellow-500 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                                                <div class="mx-1">{{ $registration->custom_id ?? 'N/A' }}</div>
                                            </div>
                                            <div class="font-bold text-gray-400 text-xs pt-0.5">pending assessment</div>
                                        @elseif (filled($registration->assessment) && $registration->assessment->grand_total == $registration->assessment->balance)
                                            <div class="flex items-center">
                                                <div class="font-bold rounded-full bg-blue-500 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                                                <div class="mx-1">{{ $registration->custom_id ?? 'N/A' }}</div>
                                            </div>
                                            <div class="font-bold text-gray-400 text-xs pt-0.5">finalized assessment</div>
                                        @elseif (filled($registration->assessment) && 1 > $registration->assessment->balance)
                                            <div class="flex items-center">
                                                <div class="font-bold rounded-full bg-green-500 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                                                <div class="mx-1">{{ $registration->custom_id ?? 'N/A' }}</div>
                                            </div>
                                            <div class="font-bold text-gray-400 text-xs pt-0.5">fully paid</div>
                                        @elseif (filled($registration->assessment) && $registration->assessment->grand_total > $registration->assessment->balance)
                                            <div class="flex items-center">
                                                <div class="font-bold rounded-full bg-indigo-600 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                                                <div class="mx-1">{{ $registration->custom_id ?? 'N/A' }}</div>
                                            </div>
                                            <div class="font-bold text-gray-400 text-xs pt-0.5">partially paid</div>
                                        @else
                                            <div>{{ $registration->custom_id ?? 'N/A' }}</div>
                                        @endif
                                    </div>
                                    <span class="block md:hidden">{{ $registration->custom_id ?? 'N/A' }}</span>
                                </x-table.cell-checkbox>
                                <x-table.cell headerLabel="Student" class="justify-start md:col-span-2">
                                    @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                        <div class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $registration->student->user->profile_photo_url ?? 'N/A' }}"/></div>
                                    @endif
                                    <div class="flex flex-col my-2 md:my-0">
                                        <div>{{ $registration->student->user->person->short_full_name ?? 'N/A'}}</div>
                                        <div class="font-bold text-gray-400 text-xs pt-0.5">ID: {{ $registration->student->custom_id ?? 'N/A' }}</div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell headerLabel="program" class="justify-start md:col-span-3">
                                    <div class="flex flex-col my-2 md:my-0">
                                        <div>{!! $registration->prospectus->program->program ?? '<span class="text-gray-400">N/A</span>' !!}</div>
                                        <div class="tracking-widest text-gray-500 text-xs pt-0.5">
                                            {!! $registration->prospectus->level->level ?? '<span class="text-gray-400">N/A</span>' !!} - {{ $registration->prospectus->term->term ?? '<span class="text-gray-400">N/A</span>' }}
                                        </div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell headerLabel="section" class="justify-start md:col-span-2">{!! $registration->section->name ?? '<span class="text-gray-400">N/A</span>' !!}</x-table.cell>
                                <x-table.cell headerLabel="status" class="justify-start md:col-span-2">{!! $registration->status->name_element ?? 'N/A' !!}</x-table.cell>
                                @if (is_null($registration->released_at))
                                    <x-table.cell-action>
                                        @if (!count($selected) > 0)
                                            <x-jet-dropdown align="right" width="60" dropdownClasses="z-10 shadow-2xl">
                                                <x-slot name="trigger"><x-table.cell-dropdown-trigger-btn/></x-slot>

                                                <x-slot name="content">
                                                    <div class="w-60">
                                                        <div class="block px-4 py-3 text-sm text-gray-500 font-bold">
                                                            {{ __('Actions') }}
                                                        </div>
                                                        @can ('view', $registration)
                                                            <a href="{{ route('pre.registration.view', $registration->id) }}">
                                                                <x-table.cell-button title="View">
                                                                    <x-icons.view-icon/>
                                                                </x-table.cell-button>
                                                            </a>
                                                        @endcan

                                                        @can ('viewGrade', $registration)
                                                            <a href="{{ route('admin.grades.view', ['search' => $registration->custom_id]) }}">
                                                                <x-table.cell-button title="Grading">
                                                                    <x-icons.grade-icon/>
                                                                </x-table.cell-button>
                                                            </a>
                                                        @endcan

                                                        @can ('view', $registration->assessment)
                                                            <a href="{{ route('admin.payments.view', ['search' => $registration->custom_id]) }}">
                                                                <x-table.cell-button title="Payments">
                                                                    <x-icons.fee-icon/>
                                                                </x-table.cell-button>
                                                            </a>
                                                        @endcan

                                                        <x-table.cell-button wire:click="archive('Registration', {{$registration}}, 'released_at')" wire:loading.attr="disabled" @click.stop title="Archive">
                                                            <x-icons.edit-icon/>
                                                        </x-table.cell-button>
                                                    </div>
                                                </x-slot>
                                            </x-jet-dropdown>
                                        @endif
                                    </x-table.cell-action>
                                @else
                                    @if (!count($selected) > 0)
                                        <x-table.cell-action x-data="{ open: true }" @click.stop>
                                            <a href="{{ route('pre.registration.view', $registration->id) }}">
                                                <x-icons.view-icon class="md:w-5 my-3 text-gray-400 hover:text-indigo-500 mx-1" stroke-width="2">View Details</x-icons.view-icon>
                                            </a>
                                            <x-icons.edit-icon
                                                wire:click.prevent="unarchive('Registration', {{$registration}}, 'released_at')"
                                                x-show="open"
                                                @click="open = ! open"
                                                class="md:w-5 text-gray-400 text-yellow-500 hover:text-yellow-600 mx-1">Unarchive</x-icons.edit-icon>
                                        </x-table.cell-action>
                                    @endif
                                @endif
                            </div>
                        </x-table.row>
                    </div>
                @empty
                    <x-table.no-result>No registrations found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @can('export', App\Models\Registration::class)
                <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>
            @endcan

            @if (isset($isArchived) && $isArchived !== '1')
                <x-table.bulk-action-button nameButton="Archive" event="archiveAll('Registration', 'released_at')">
                    <x-icons.edit-icon/>
                </x-table.bulk-action-button>
            @else
                <x-table.bulk-action-button nameButton="Unarchive" event="unarchiveAll('Registration', 'released_at')">
                    <x-icons.edit-icon/>
                </x-table.bulk-action-button>
            @endif
        </x-table.bulk-action-bar>
    </div>

    <div>@include('partials.loading')</div>

    <livewire:admin.pre-enrollment-component.pre-enrollment-destroy-component>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
