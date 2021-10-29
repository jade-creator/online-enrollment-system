<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Advising Schedule" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            <a href="{{ route('admin.advising.create') }}">
                @can('create', App\Models\Advice::class)
                    <x-table.nav-button>
                        Create New Advising Schedule
                    </x-table.nav-button>
                @endcan
            </a>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter>
                    <x-table.filter-slot title="Program">
                        <select wire:model="programId" wire:loading.attr="disabled" name="programId">
                            <option value="" selected>All</option>
                            @forelse ($this->programs as $program)
                                <option value="{{ $program->id ?? 'N/A' }}">{{ $program->code ?? 'N/A' }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                    </x-table.filter-slot>
                    <x-table.filter-slot title="Level">
                        <select wire:model="levelId" wire:loading.attr="disabled" name="levelId">
                            <option value="" selected>All</option>
                            <option value="14" selected>1st Year</option>
                            <option value="15" selected>2nd Year</option>
                            <option value="16" selected>3rd Year</option>
                            <option value="17" selected>4th Year</option>
                            <option value="18" selected>5th Year</option>
                        </select>
                    </x-table.filter-slot>
                </x-table.filter>
            </x-slot>

            <x-slot name="paginationLink">
                {{ $advice->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-3 flex items-start">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox"  class="cursor-pointer mx-5" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('id')">Program</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-3">Date/s</x-table.column-title>
                <x-table.column-title class="col-span-2">Time</x-table.column-title>
                <x-table.column-title class="col-span-3">Link</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($advice as $adviceItem)
                    <div wire:key="table-row-{{$adviceItem->id}}">
                        <x-table.row :active="$this->isSelected($adviceItem->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <div class="col-span-12 md:col-span-3 truncate font-bold text-xs self-center rounded-t-md bg-indigo-500 md:bg-transparent">
                                    <div class="flex items-center">
                                        <input wire:model="selected" wire:loading.attr="disabled" value="{{ $adviceItem->id }}" @click.stop type="checkbox" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
{{--                                        <div class="h-10 flex items-center text-white md:text-black">--}}
{{--                                            {{ $adviceItem->program->code ?? 'N/A' }}--}}
{{--                                        </div>--}}
                                        <div class="h-10 flex flex-col my-2 md:my-0">
                                            <div>{{ $adviceItem->program->code ?? 'All Programs' }}</div>
                                            <div class="tracking-widest text-gray-500 text-xs pt-0.5">
                                                {{ $adviceItem->level->level ?? 'All Levels' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <x-table.cell headerLabel="Date/s" class="justify-start md:col-span-3">{{ $adviceItem->date ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Time" class="justify-start md:col-span-2">{{ $adviceItem->time ?? 'N/A' }}</x-table.cell>
{{--                                <x-table.cell headerLabel="Program" class="justify-start md:col-span-1">{{ $adviceItem->program->code ?? 'All' }}</x-table.cell>--}}
{{--                                <x-table.cell headerLabel="Level" class="justify-start md:col-span-1">{{ $adviceItem->level->level ?? 'All' }}</x-table.cell>--}}
                                <x-table.cell headerLabel="Link" class="justify-start md:col-span-3">
                                    @isset ($adviceItem->link)
                                        <a href="{{ $adviceItem->link }}" class="underline text-blue-500" target="_blank">{{ $adviceItem->link }}</a>
                                    @else
                                        N/A
                                    @endisset
                                </x-table.cell>
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
                                                    @can ('update', $adviceItem)
                                                        <a href="{{ route('admin.advising.update', $adviceItem) }}">
                                                            <x-table.cell-button title="View">
                                                                <x-icons.view-icon/>
                                                            </x-table.cell-button>
                                                        </a>
                                                    @endcan

                                                    @can ('destroy', $adviceItem)
                                                        <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$adviceItem}})" title="Delete" class="rounded-b-md hover:bg-red-500 hover:text-white transition-colors">
                                                            <x-icons.delete-icon/>
                                                        </x-table.cell-button>
                                                    @elsecan ('view', App\Models\Advice::class)
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
                    <x-table.no-result>No advising schedule found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @can('export', App\Models\Advice::class)
                <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>
            @endcan
        </x-table.bulk-action-bar>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.advising-component.advising-destroy-component>
</div>
