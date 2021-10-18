<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Registrations">
            <a href="{{ route('student.registrations.create') }}">
                <x-table.nav-button>
                    Create New Registration
                </x-table.nav-button>
            </a>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter/>
            </x-slot>

            <x-slot name="paginationLink">
                {{ $registrations->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2">
                    <x-table.sort-button event="sortFieldSelected('id')">reg. ID</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-2">program</x-table.column-title>
                <x-table.column-title class="col-span-2">level</x-table.column-title>
                <x-table.column-title class="col-span-2">term</x-table.column-title>
                <x-table.column-title class="col-span-2">section</x-table.column-title>
                <x-table.column-title class="col-span-1">status</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div wire:key="table-row-{{$registration->id}}">
                        <x-table.row>
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell headerLabel="Reg. ID" class="justify-start md:col-span-2">{{ $registration->custom_id ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="program" class="justify-start md:col-span-2">{{ $registration->prospectus->program->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="level" class="justify-start md:col-span-2">{{ $registration->prospectus->level->level ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="term" class="justify-start md:col-span-2">{{ $registration->prospectus->term->term ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="section" class="justify-start md:col-span-2">{{ $registration->section->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="status" class="justify-start md:col-span-1">{!! $registration->status->name_element ?? 'N/A' !!}</x-table.cell>
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
                                                            <x-table.cell-button title="View Registration">
                                                                <x-icons.pre-enrollment-icon/>
                                                            </x-table.cell-button>
                                                        </a>
                                                    @endcan

                                                    <a href="{{ route('student.grades.view', ['levelId' => $registration->prospectus->level_id, 'semesterId' => $registration->prospectus->term_id]) }}">
                                                        <x-table.cell-button title="View Prospectus">
                                                            <x-icons.prospectus-icon/>
                                                        </x-table.cell-button>
                                                    </a>

                                                    @can ('pay', $registration)
                                                        <a href="{{ route('student.paywithpaypal', $registration->custom_id) }}">
                                                            <x-table.cell-button title="Pay">
                                                                <x-icons.fee-icon/>
                                                            </x-table.cell-button>
                                                        </a>
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
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>
</div>
