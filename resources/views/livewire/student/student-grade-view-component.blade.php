<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Prospectus">
            <a href="{{ route('student.registrations.create') }}">
                <x-table.nav-button>
                    Create New Registration
                </x-table.nav-button>
            </a>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <div class="flex items-center justify-between">
                    @isset ($prospectus)
                        <p class="flex items-center justify-between text-indigo-500">
                            <span>{{ $prospectus->program->code ?? 'N/A' }}</span>
                            <x-icons.right-arrow-icon/>
                            <span>{{ $prospectus->level->level ?? 'N/A' }}</span>
                            <x-icons.right-arrow-icon/>
                            <span>{{ $prospectus->term->term ?? 'N/A' }}</span>
                        </p>
                    @endisset
                    <x-table.filter :isSearchable="false" :isFilterable="false">
                        <livewire:partials.prospectus-dropdown/>
                    </x-table.filter>
                </div>
            </x-slot>

            <x-slot name="paginationLink"></x-slot>

            <x-slot name="head">
                <x-table.column-title class="col-span-3">Registration ID</x-table.column-title>
                <x-table.column-title class="col-span-2">status</x-table.column-title>
                <x-table.column-title class="col-span-2">section</x-table.column-title>
                <x-table.column-title class="col-span-2">total unit</x-table.column-title>
                <x-table.column-title class="col-span-2">classification</x-table.column-title>
                <x-table.column-title class="col-span-1">option</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div wire:key="table-row-{{$registration->id}}" x-data="{ open: false }">
                        <x-table.row>
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell headerLabel="Reg. ID" class="justify-start md:col-span-3">{{ $registration->custom_id ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="status" class="justify-start md:col-span-2">{{ $registration->status->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="section" class="justify-start md:col-span-2">{{ $registration->section->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $registration->total_unit ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $registration->classification ?? 'N/A' }}</x-table.cell>
                                <x-table.cell-action>
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
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </x-table.cell-action>
                            </div>
                        </x-table.row>

                        <livewire:admin.grade-component.grade-view-component :registration="$registration" key="'grade-view-component-'{{ $registration->id.now() }}">
                    </div>
                @empty
                    <x-table.no-result>No registrations found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>
    </div>

    <div>@include('partials.loading')</div>
</div>
