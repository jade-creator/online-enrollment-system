<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Grading"/>

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
                <x-table.column-title class="col-span-1">stud. ID</x-table.column-title>
                <x-table.column-title class="col-span-2">full name</x-table.column-title>
                <x-table.column-title class="col-span-2">classification</x-table.column-title>
                <x-table.column-title class="col-span-1">program</x-table.column-title>
                <x-table.column-title class="col-span-1">level</x-table.column-title>
                <x-table.column-title class="col-span-1">sem</x-table.column-title>
                <x-table.column-title class="col-span-1">section</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div wire:key="table-row-{{$registration->id}}" x-data="{ open: false }">
                        <x-table.row>
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell headerLabel="reg. ID" class="justify-start md:col-span-2">{{ $registration->custom_id ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Stud. ID" class="justify-start md:col-span-1">{{ $registration->student->custom_id ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Full name" class="justify-start md:col-span-2">{{ $registration->student->user->person->full_name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="classification" class="justify-start md:col-span-2">{{ $registration->classification ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="program" class="justify-start md:col-span-1">{{ $registration->prospectus->program->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="level" class="justify-start md:col-span-1">{{ $registration->prospectus->level->level ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="sem" class="justify-start md:col-span-1">{{ $registration->prospectus->term->term ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="section" class="justify-start md:col-span-1">{{ $registration->section->name ?? 'N/A' }}</x-table.cell>
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

                                                <a href="{{ route('pre.registration.view', $registration->id) }}">
                                                    <x-table.cell-button title="View">
                                                        <x-icons.view-icon/>
                                                    </x-table.cell-button>
                                                </a>
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

    <livewire:admin.grade-component.grade-update-component key="'grade-update-component-'{{ now() }}">
</div>
