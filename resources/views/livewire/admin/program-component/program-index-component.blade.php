<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Programs" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            <a href="{{ route('admin.programs.create') }}">
                @can('create', App\Models\Program::class)
                    <x-table.nav-button>
                        Create New Program
                    </x-table.nav-button>
                @endcan
            </a>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter/>
            </x-slot>

            <x-slot name="paginationLink">
                {{ $programs->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-start">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox"  class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('id')">ID</x-table.sort-button>
                </div>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('code')">code</x-table.sort-button>
                </div>
                <div class="col-span-3">
                    <x-table.sort-button event="sortFieldSelected('program')">program</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-3">description</x-table.column-title>
                <x-table.column-title class="col-span-2 mx-auto">No. of Years</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($programs as $program)
                    <div wire:key="table-row-{{$program->id}}" x-data="{ open: false }">
                        <x-table.row :active="$this->isSelected($program->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$program->id">{{ $program->id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="Code" class="justify-start md:col-span-1">{{ $program->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Program" class="justify-start md:col-span-3">{{ $program->program ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Description" class="justify-start md:col-span-3">{{ $program->description ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="No. of years" class="md:justify-center md:col-span-2">{{ $program->year ?? 'N/A' }}</x-table.cell>
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
                                                    @can ('update', $program)
                                                        <a href="{{ route('admin.programs.update', $program) }}">
                                                            <x-table.cell-button title="View">
                                                                <x-icons.view-icon/>
                                                            </x-table.cell-button>
                                                        </a>
                                                    @endcan

                                                    @can ('destroy', $program)
                                                        <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$program}})" title="Delete" class="rounded-b-md hover:bg-red-500 hover:text-white transition-colors">
                                                            <x-icons.delete-icon/>
                                                        </x-table.cell-button>
                                                    @elsecan ('view', App\Models\Program::class)
                                                        <x-table.cell-button title="Administrative Access">
                                                            <x-icons.lock-icon/>
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
                    <x-table.no-result>No programs found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @can('export', App\Models\Program::class)
                <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>
            @endcan
        </x-table.bulk-action-bar>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.program-component.program-destroy-component>
</div>
