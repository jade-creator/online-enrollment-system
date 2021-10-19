<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Pre Registrations">
            <x-jet-secondary-button class="flex items-center">
                <x-icons.release-icon/>
                <p class="pl-2">{{ __('Archives')}}</p>
            </x-jet-secondary-button>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter>
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

            <x-slot name="paginationLink">
                {{ $registrations->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-center">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox" title="Select Displayed Data" class="mx-5">
                    <x-table.sort-button event="sortFieldSelected('id')">reg. ID</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-1">Stud. ID</x-table.column-title>
                <x-table.column-title class="col-span-3">full Name</x-table.column-title>
                <x-table.column-title class="col-span-1">status</x-table.column-title>
                <x-table.column-title class="col-span-1">Program</x-table.column-title>
                <x-table.column-title class="col-span-1">level</x-table.column-title>
                <x-table.column-title class="col-span-1">sem</x-table.column-title>
                <x-table.column-title class="col-span-1">section</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div wire:key="table-row-{{$registration->id}}">
                        <x-table.row>
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$registration->id">{{ $registration->custom_id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="Stud. ID" class="justify-start md:col-span-1">{{ $registration->student->custom_id ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Full name" class="justify-start md:col-span-3">{{ $registration->student->user->person->full_name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="status" class="justify-start md:col-span-1">{!! $registration->status->name_element ?? 'N/A' !!}</x-table.cell>
                                <x-table.cell headerLabel="program" class="justify-start md:col-span-1">{{ $registration->prospectus->program->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="level" class="justify-start md:col-span-1">{{ $registration->prospectus->level->level ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="sem" class="justify-start md:col-span-1">{{ $registration->prospectus->term->term ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="section" class="justify-start md:col-span-1">{{ $registration->section->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell-action>
                                    @if (!count($selected) > 0)
                                        <x-jet-dropdown align="right" width="60" dropdownClasses="z-10 shadow-2xl">
                                            <x-slot name="trigger">
                                                <x-table.cell-dropdown-trigger-btn/>
                                            </x-slot>

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
                                                        <a href="{{ route(auth()->user()->role->name.'.grades.view', ['search' => $registration->custom_id]) }}">
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

                                                    @can ('destroy', $registration)
                                                        <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$registration}})" title="Delete" class="rounded-b-md hover:bg-red-500 hover:text-white transition-colors">
                                                            <x-icons.delete-icon/>
                                                        </x-table.cell-button>
                                                    @endcan
                                                </div>
                                            </x-slot>
                                        </x-jet-dropdown>
                                    @endif
                                </x-table.cell-action>
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
        </x-table.bulk-action-bar>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.pre-enrollment-component.pre-enrollment-destroy-component>
</div>
