<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Fees">
            @can('create', App\Models\Fee::class)
                <button wire:click.prevent="$emit('modalAddingCategory')" class="py-2.5 px-4 text-xs text-indigo-500 hover:text-indigo-700 font-bold hover:underline focus:outline-none">
                    View Categories
                </button>

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
                <x-table.column-title class="col-span-3">Program</x-table.column-title>
                <x-table.column-title class="col-span-3">Category</x-table.column-title>
                <x-table.column-title class="col-span-3">amount</x-table.column-title>
                <x-table.column-title class="col-span-1">latest</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($fees as $fee)
                    <div wire:key="table-row-{{$fee->id}}">
                        <x-table.row :active="$this->isSelected($fee->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$fee->id">{{ $fee->custom_id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="Program" class="justify-start md:col-span-3">{{ $fee->program->program ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Category" class="justify-start md:col-span-3">{{ $fee->category->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Amount" class="justify-start md:col-span-3">{{ $fee->getFormattedPriceAttribute($fee->price) ?? 'N/A' }}</x-table.cell>
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
                                                        <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$fee}})" title="Delete" class="rounded-b-md hover:bg-red-500 hover:text-white transition-colors">
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
                <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>
            @endcan
        </x-table.bulk-action-bar>
    </div>

    <div>@include('partials.loading')</div>

    <livewire:admin.fee-component.fee-category-add-component>

    <livewire:admin.fee-component.fee-destroy-component key="{{ 'admin-fee-destroy-component-'. now() }}"/>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
