<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
<<<<<<< HEAD

=======
        <div>
            @forelse ($sections as $section)
                @if ($loop->first && filled($this->prospectusId))
                    <h1 class="border-l-4 mb-4 px-2 border-indigo-500"> <!--TODO: make it a separate component-->
                        <span>{{ $section->prospectus->program->program }}</span><span class="px-2 font-bold text-lg">></span>
                        <span>{{ $section->prospectus->level->level }}</span><span class="px-2 font-bold text-lg">></span>
                        <span>{{ $section->prospectus->term->term }}</span>
                    </h1>
                @endif
            @empty
            @endforelse
        </div>
        
>>>>>>> main
        <x-table.title tableTitle="Sections" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            @can('create', App\Models\Section::class)
                <x-table.nav-button wire:click.prevent="$emit('modalAddingSection')">
                    Add Section
                </x-table.nav-button>
            @endcan
        </x-table.title>

        <x-table.filter>
<<<<<<< HEAD
            <x-table.filter-slot title="Program">
                <select wire:model="programId" wire:loading.attr="disabled" name="program" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
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
        </x-table.filter>
=======
            <div name='slot'>
                <livewire:partials.prospectus-filter>
            </div>
         </x-table.filter>
>>>>>>> main

        <x-table.main>

            <x-slot name="paginationLink">
                {{ $sections->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-start" id="columnTitle">
                    <input @click.stop type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('id')">ID</x-table.sort-button>
                </div>
                <div class="col-span-2" id="name">
                    <x-table.sort-button event="sortFieldSelected('name')">name</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-1">program</x-table.column-title>
                <x-table.column-title class="col-span-1">level</x-table.column-title>
                <x-table.column-title class="col-span-1">term</x-table.column-title>
                <x-table.column-title class="col-span-1">room</x-table.column-title>
                <x-table.column-title class="col-span-1 text-center">seats</x-table.column-title>
                <x-table.column-title class="col-span-2 text-center">current no. of students</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($sections as $section)
                    <div wire:key="table-row-{{$section->id}}" x-data="{ open: false }">
                        <x-table.row :active="$this->isSelected($section->id)">
                            <div name="slot" class="grid grid-cols-12 gap-2">
                                <x-table.cell-checkbox :value="$section->id"/>
                                <x-table.cell class="justify-start md:col-span-2">{{ $section->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-1">{{ $section->prospectus->program->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-1">{{ $section->prospectus->level->level ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-1">{{ $section->prospectus->term->term ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-1">{{ $section->room->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-center md:col-span-1">{{ $section->seat ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-center md:col-span-2">{{ $section->registrations->count() }}</x-table.cell>
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
                                                    @can ('update', $section)
                                                        <x-table.cell-button wire:click.prevent="$emit('modalViewingSection', {{ $section }})" title="View">
                                                            <x-icons.view-icon/>
                                                        </x-table.cell-button>
                                                    @endcan

                                                    @can ('release', $section)
                                                        <x-table.cell-button wire:click.prevent="$emitSelf('releaseConfirm', {{$section}})" title="Release Students">
                                                            <x-icons.release-icon/>
                                                        </x-table.cell-button>
                                                    @endcan

                                                    @can ('destroy', $section)
                                                        <x-table.cell-button wire:click.prevent="$emitSelf('removeConfirm', {{$section}})" title="Delete">
                                                            <x-icons.delete-icon/>
                                                        </x-table.cell-button>
                                                    @elsecan ('view', App\Models\Section::class)
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
                        <livewire:admin.schedule-component.schedule-view-component :section="$section" :wire:key="'schedule-view-component-'.$section->id">
                    </div>
                @empty
                    <x-table.no-result>No sections found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
<<<<<<< HEAD

=======
            
>>>>>>> main
        </x-table.main>

        @include('livewire.admin.section-component.section-bulk-action')
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.section-component.section-add-component :rooms="$this->rooms" :programs="$this->programs">

    <livewire:admin.section-component.section-update-component :rooms="$this->rooms">

    <livewire:admin.section-component.section-destroy-component>

    <livewire:admin.schedule-component.schedule-update-component>
</div>
