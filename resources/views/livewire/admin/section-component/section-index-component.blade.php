<div class="w-full flex flex-1 scrolling-touch">
    <x-table.filter>
        <livewire:partials.prospectus-filter>
    </x-table.filter>

    <div class="min-h-screen w-full py-8 px-8">
        <div>
            @forelse ($sections as $section)
                @if ($loop->first && filled($this->prospectusId))
                    <h1 class="mb-4 text-gray-500 font-bold text-sm"> <!--TODO: make it a separate component-->
                        <span>{{ $section->prospectus->program->program }}</span>
                        <x-icons.right-arrow-icon/>
                        <span>{{ $section->prospectus->level->level }}</span>
                        <x-icons.right-arrow-icon/>
                        <span>{{ $section->prospectus->term->term }}</span>
                    </h1>
                @endif
            @empty
            @endforelse
        </div>
        <x-table.title tableTitle="Sections" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            @can('create', App\Models\Section::class)
                <x-table.nav-button wire:click.prevent="$emit('modalAddingSection', {{ $prospectusId }})" :disabled="empty($prospectusId)">
                    Add Section
                </x-table.nav-button>
            @endcan
        </x-table.title>

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
                <x-table.column-title class="col-span-2">term</x-table.column-title>
                <x-table.column-title class="col-span-2">room</x-table.column-title>
                <x-table.column-title class="col-span-1">seats</x-table.column-title>
                <x-table.column-title class="col-span-2 text-center">current no. of students</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($sections as $section)
                    <div x-data="{ open: false }">
                        <x-table.row wire:key="'table-row-'.{{$section->id}}" :active="$this->isSelected($section->id)">
                            <div name="slot" class="grid grid-cols-12 gap-2">
                                <x-table.cell-checkbox :value="$section->id"/>
                                <x-table.cell class="justify-start md:col-span-2">{{ $section->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $section->prospectus->term->term ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $section->room->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-1">{{ $section->seat ?? 'N/A' }}</x-table.cell>
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
                                                        <x-table.cell-button wire:click.prevent="$emitSelf('viewSection', {{$section}})" title="Release Students">
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

                        @include('livewire.admin.section-component.section-view-schedule')
                    </div>
                @empty
                    <x-table.no-result title="No sections found.🤔"/>
                @endforelse
            </x-slot>
        </x-table.main>

        @include('livewire.admin.section-component.section-bulk-action')
    </div>

    <div wire:loading wire:target="paginateValue, search, selectPage, selectAll, previousPage, nextPage, confirmingExport, releaseConfirm, releaseAll">
        @include('partials.loading')
    </div>

    <livewire:admin.section-component.section-add-component :rooms="$this->rooms">

    <livewire:admin.section-component.section-update-component :rooms="$this->rooms">

    <livewire:admin.section-component.section-destroy-component>
</div>
