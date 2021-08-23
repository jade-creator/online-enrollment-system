<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
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
        
        <x-table.title tableTitle="Sections" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            @can('create', App\Models\Section::class)
                <x-table.nav-button action="addingSection" buttonName="Add Section"/>
            @endcan
        </x-table.title>

        <x-table.filter>
            <div name='slot'>
                <livewire:partials.prospectus-filter>
            </div>
         </x-table.filter>

        <x-table.main>

            <x-slot name="paginationLink">
                {{ $sections->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-start" id="columnTitle">
                    <input @click.stop type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button nameButton="ID" event="sortFieldSelected('id')"/>
                </div>
                <div class="col-span-2" id="name">
                    <x-table.sort-button nameButton="name" event="sortFieldSelected('name')"/>
                </div>
                <x-table.column-title columnTitle="term" class="col-span-2"/>
                <x-table.column-title columnTitle="room" class="col-span-2"/>
                <x-table.column-title columnTitle="seats" class="col-span-1"/>
                <x-table.column-title columnTitle="current no. of students" class="col-span-2 text-center"/>
                <div class="col-span-1">
                    <x-table.sort-button nameButton="latest" event="sortFieldSelected('created_at')"/>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($sections as $section)
                    <div id="{{ $section->id }}" x-data="{ open: false }">
                        <x-table.row :active="$this->isSelected($section->id)">
                            <div name="slot" class="grid grid-cols-12 gap-2">
                                <x-table.cell-checkbox :value="$section->id"/>
                                <x-table.cell :value="$section->name" classes="justify-start md:col-span-2"/>
                                <x-table.cell :value="$section->prospectus->term->term" classes="justify-start md:col-span-2"/>
                                <x-table.cell :value="$section->room->name" classes="justify-start md:col-span-2"/>
                                <x-table.cell :value="$section->seat" classes="justify-start md:col-span-1"/>
                                <x-table.cell :value="$section->registrations->count()" classes="justify-center md:col-span-2"/>
                                <x-table.cell-action>
                                    <x-slot name="container">
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
                                                        @if (auth()->user()->role->name == 'admin')
                                                            <x-table.cell-button wire:click.prevent="$emitSelf('viewSection', {{$section}})" title="View">
                                                                <x-slot name="icon">
                                                                    <x-icons.view-icon/>
                                                                </x-slot>
                                                            </x-table.cell-button>

                                                            @can('release', $section)
                                                                <x-table.cell-button wire:click.prevent="$emitSelf('viewSection', {{$section}})" title="Release Students">
                                                                    <x-slot name="icon">
                                                                        <x-icons.release-icon/>
                                                                    </x-slot>
                                                                </x-table.cell-button>
                                                            @endcan

                                                            <x-table.cell-button wire:click.prevent="$emitSelf('viewSection', {{$section}})" title="Delete">
                                                                <x-slot name="icon">
                                                                    <x-icons.delete-icon/>
                                                                </x-slot>
                                                            </x-table.cell-button>
                                                        @else
                                                            <x-table.cell-button title="Administrative Access">
                                                                <x-slot name="icon">
                                                                    <x-icons.lock-icon/>
                                                                </x-slot>
                                                            </x-table.cell-button>
                                                        @endif
                                                    </div>
                                                </x-slot>
                                            </x-jet-dropdown>
                                        @endif
                                    </x-slot>
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
</div>
