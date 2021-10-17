<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Curricula" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            <a href="{{ route('admin.curricula.create') }}">
                @can('create', App\Models\Curriculum::class)
                    <x-table.nav-button>
                        Create New Curriculum
                    </x-table.nav-button>
                @endcan
            </a>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter/>
            </x-slot>

            <x-slot name="paginationLink">
                {{ $curricula->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-start">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox"  class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('id')">Code</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-2">program</x-table.column-title>
                <x-table.column-title class="col-span-3">description</x-table.column-title>
                <x-table.column-title class="col-span-2 mx-auto">state</x-table.column-title>
                <x-table.column-title class="col-span-2 mx-auto">school year</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($curricula as $curriculum)
                    <div wire:key="table-row-{{$curriculum->id}}">
                        <x-table.row :active="$this->isSelected($curriculum->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$curriculum->id">{{ $curriculum->code ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="Code" class="justify-start md:col-span-2">{{ $curriculum->program->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Description" class="justify-start md:col-span-3" title="{{$curriculum->description ?? 'N/A'}}">{{ $curriculum->description ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="state" class="md:justify-center md:col-span-2">{!! $curriculum->state_element !!}</x-table.cell>
                                <x-table.cell headerLabel="School Year" class="md:justify-center md:col-span-2">{{ $curriculum->school_year ?? 'N/A' }}</x-table.cell>
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
                                                    @can ('view', $curriculum)
                                                        <a href="{{ route('admin.curricula.update', $curriculum) }}">
                                                            <x-table.cell-button title="View">
                                                                <x-icons.view-icon/>
                                                            </x-table.cell-button>
                                                        </a>
                                                    @endcan

                                                    @can ('activate', $curriculum)
                                                        <x-table.cell-button wire:click.prevent="confirmActivateCurriculum({{$curriculum}})" title="Activate">
                                                            <x-icons.edit-icon/>
                                                        </x-table.cell-button>
                                                    @elsecan ('deactivate', $curriculum)
                                                        <x-table.cell-button wire:click.prevent="confirmActivateCurriculum({{$curriculum}})" title="Deactivate">
                                                            <x-icons.edit-icon/>
                                                        </x-table.cell-button>
                                                    @endcan

                                                    <a href="{{ route('admin.prospectuses.view', ['prospectusId' => $curriculum->program->prospectuses->first()->id, 'curriculumId' => $curriculum->id]) }}">
                                                        <x-table.cell-button title="Prospectus">
                                                            <x-icons.prospectus-icon/>
                                                        </x-table.cell-button>
                                                    </a>

                                                    @can ('destroy', $curriculum)
                                                        <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$curriculum}})" title="Delete" class="rounded-b-md hover:bg-red-500 hover:text-white transition-colors">
                                                            <x-icons.delete-icon/>
                                                        </x-table.cell-button>
                                                    @endcan

                                                    @can ('block', App\Models\Curriculum::class)
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
                    <x-table.no-result>No curriculum found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @can('export', App\Models\Curriculum::class)
                <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>
            @endcan
        </x-table.bulk-action-bar>
    </div>

    <div>@include('partials.loading')</div>

    <livewire:admin.curriculum-component.curriculum-destroy-component>
</div>
