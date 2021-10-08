<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Faculties" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            <a href="{{ route('admin.faculties.create') }}">
                @can('create', App\Models\Faculty::class)
                    <x-table.nav-button>
                        Create New Faculty
                    </x-table.nav-button>
                @endcan
            </a>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter/>
            </x-slot>

            <x-slot name="paginationLink">
                {{ $faculties->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-center">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox" class="cursor-pointer mx-5" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('id')">ID</x-table.sort-button>
                </div>
                <div class="col-span-2">
                    <x-table.sort-button event="sortFieldSelected('code')">name</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-1">Program</x-table.column-title>
                <x-table.column-title class="col-span-2">description</x-table.column-title>
                <x-table.column-title class="col-span-2">Mission</x-table.column-title>
                <x-table.column-title class="col-span-2">Vision</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($faculties as $faculty)
                    <div wire:key="table-row-{{$faculty->id}}" x-data="{ open: false }">
                        <x-table.row :active="$this->isSelected($faculty->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$faculty->id">{{ $faculty->id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="Name" class="justify-start md:col-span-2">{{ $faculty->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="program" class="justify-start md:col-span-1">{{ $faculty->program->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Description" class="justify-start md:col-span-2">{{ $faculty->description ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Mission" class="justify-start md:col-span-2">{{ $faculty->mission ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Vision" class="justify-start md:col-span-2">{{ $faculty->vision ?? 'N/A' }}</x-table.cell>
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
                                                    @can ('update', $faculty)
                                                        <a href="{{ route('admin.faculties.update', $faculty) }}">
                                                            <x-table.cell-button title="View">
                                                                <x-icons.view-icon/>
                                                            </x-table.cell-button>
                                                        </a>
                                                    @endcan

                                                    @can ('addMember', $faculty)
                                                        <x-table.cell-button wire:click.prevent="$emit('modalAddingMembers', {{$faculty}})" title="Add Member">
                                                            <x-icons.edit-icon/>
                                                        </x-table.cell-button>
                                                    @endcan

                                                    @can ('destroy', $faculty)
                                                        <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$faculty}})" title="Delete" class="rounded-b-md hover:bg-red-500 hover:text-white transition-colors">
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

                        <livewire:admin.faculty-component.faculty-view-component :faculty="$faculty" key="'faculty-view-component-'{{ $faculty->id.now() }}">
                    </div>
                @empty
                    <x-table.no-result>No faculties found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @can('export', App\Models\Faculty::class)
                <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>
            @endcan
        </x-table.bulk-action-bar>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.faculty-component.faculty-add-member-component>

    <livewire:admin.faculty-component.faculty-destroy-component>
<div>
