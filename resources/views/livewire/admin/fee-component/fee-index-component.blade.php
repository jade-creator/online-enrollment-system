<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Fees">
            @can('create', App\Models\Fee::class)
                <a href="{{ route('admin.fees.create') }}">
                    <x-table.nav-button>
                        Create New Fee
                    </x-table.nav-button>
                </a>
            @endcan
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter>
                    <x-table.filter-slot title="Program">
                        <select wire:model="programId" wire:loading.attr="disabled" name="program">
                            @forelse ($this->programs as $program)
                                @if ($loop->first)
                                    <option value="" selected>All</option>
                                @endif
                                <option value="{{ $program->id ?? 'N/A' }}">{{ $program->code ?? 'N/A' }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                    </x-table.filter-slot>

                    <x-table.filter-slot title="Category">
                        <select wire:model="categoryId" wire:loading.attr="disabled" name="category">
                            @forelse ($this->categories as $category)
                                @if ($loop->first)
                                    <option value="" selected>All</option>
                                @endif
                                <option value="{{ $category->id ?? 'N/A' }}">{{ $category->name ?? 'N/A' }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                    </x-table.filter-slot>
                </x-table.filter>
            </x-slot>

            <x-slot name="paginationLink">
                {{ $fees->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <x-table.column-title class="col-span-2">ID</x-table.column-title>
                <x-table.column-title class="col-span-2">Program</x-table.column-title>
                <x-table.column-title class="col-span-2">Category</x-table.column-title>
                <x-table.column-title class="col-span-3">Description</x-table.column-title>
                <x-table.column-title class="col-span-2">amount</x-table.column-title>
                <x-table.column-title class="col-span-1">latest</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($fees as $fee)
                    <div wire:key="table-row-{{$fee->id}}">
                        <x-table.row :active="$this->isSelected($fee->id)">
                            <div name="slot" class="grid grid-cols-12 gap-2">
                                <x-table.cell-checkbox :value="$fee->id">{{ $fee->id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell class="justify-start md:col-span-2">{{ $fee->program->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $fee->category->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-3">{{ $fee->description ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $fee->getFormattedPriceAttribute($fee->price) ?? 'N/A' }}</x-table.cell>
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
                                                    @can('update', $fee)
                                                        <a href="{{ route('admin.fees.update', ['fee' => $fee]) }}">
                                                            <x-table.cell-button title="Update">
                                                                <x-icons.view-icon/>
                                                            </x-table.cell-button>
                                                        </a>
                                                    @endcan
                                                    @can ('destroy', $fee)
                                                        <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$fee}})" title="Delete">
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
                    <x-table.no-result>No fees found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @can('export', App\Models\Fee::class)
                <x-table.bulk-action-button nameButton="Export" event="$emitSelf('fileExport')">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>
            @endcan
        </x-table.bulk-action-bar>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.fee-component.fee-destroy-component key="{{ 'admin-fee-destroy-component-'. now() }}"/>
</div>
