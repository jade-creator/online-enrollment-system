<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Sections" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            @can('create', App\Models\Section::class)
                <button wire:click.prevent="$emit('modalAddingRoom')" class="py-2.5 px-4 text-xs text-indigo-500 hover:text-indigo-700 font-bold hover:underline focus:outline-none">
                    View Rooms
                </button>

                <a href="{{ route('admin.sections.create') }}">
                    <x-table.nav-button>
                        Create New Section
                    </x-table.nav-button>
                </a>
            @endcan
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter>
                    <x-table.filter-slot title="Program">
                        <select wire:model="programId" wire:loading.attr="disabled" name="program" class="w-full flex-1">
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
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-center" id="columnTitle">
                    <input @click.stop type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('name')">Name</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-3">program</x-table.column-title>
                <x-table.column-title class="col-span-3">room</x-table.column-title>
                <div class="col-span-3 text-center" id="seats-col">
                    <x-table.sort-button event="sortFieldSelected('seat')">seats</x-table.sort-button>
                </div>
                <div>
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($sections as $section)
                    <div wire:key="table-row-{{$section->id}}" x-data="{ open: false }">
                        <x-table.row :active="$this->isSelected($section->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$section->id">{{ $section->name ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="program" class="justify-start md:col-span-3">
                                    <div class="flex flex-col my-2 md:my-0">
                                        <div>{!! $section->prospectus->program->program ?? '<span class="text-gray-400">N/A</span>' !!}</div>
                                        <div class="tracking-widest text-gray-500 text-xs pt-0.5">
                                            {!! $section->prospectus->level->level ?? '<span class="text-gray-400">N/A</span>' !!} - {{ $section->prospectus->term->term ?? '<span class="text-gray-400">N/A</span>' }}
                                        </div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell headerLabel="room" class="justify-start md:col-span-3">{!! $section->room->name ?? '<span class="text-gray-400">N/A</span>' !!}</x-table.cell>
                                <x-table.cell headerLabel="seats" class="md:justify-start md:col-span-3">
                                    <div class="flex flex-col">
                                        <div class="tracking-widest text-green-500">{{ $section->registrations->count() }}<span class="text-gray-500">/{{ $section->seat ?? 'N/A' }}</span></div>
                                        <progress id="bar" value="{{ $section->registrations->count() }}" max="{{ $section->seat ?? 'N/A' }}"></progress>
                                    </div>
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
                                                    @can ('update', $section)
                                                        <a href="{{ route('admin.sections.update', $section) }}">
                                                            <x-table.cell-button title="View">
                                                                <x-icons.view-icon/>
                                                            </x-table.cell-button>
                                                        </a>
                                                    @endcan

                                                    @can ('release', $section)
                                                        <x-table.cell-button wire:click.prevent="$emitSelf('releaseConfirm', {{$section}})" title="Release Students">
                                                            <x-icons.release-icon/>
                                                        </x-table.cell-button>
                                                    @endcan

                                                    @can ('createClass', $section)
                                                        <x-table.cell-button wire:click.prevent="$emit('modalAddingSchedule', {{$section}})" title="Add Class">
                                                            <x-icons.section-icon/>
                                                        </x-table.cell-button>
                                                    @endcan

                                                    @can ('destroy', $section)
                                                        <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$section}})" title="Delete" class="rounded-b-md hover:bg-red-500 hover:text-white transition-colors">
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
                        <livewire:admin.schedule-component.schedule-view-component :section="$section" key="'schedule-view-component-'{{ $section->id.now() }}">
                    </div>
                @empty
                    <x-table.no-result>No sections found.🤔</x-table.no-result>
                @endforelse
            </x-slot>

            <x-slot name="paginationLink">
                {{ $sections->links('partials.pagination-link') }}
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @can('create', App\Models\Section::class)
                <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>

                <x-table.bulk-action-button nameButton="Release" event="releaseAll">
                    <x-icons.release-icon/>
                </x-table.bulk-action-button>
            @endcan
        </x-table.bulk-action-bar>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.section-component.section-destroy-component>

    <livewire:admin.schedule-component.schedule-add-component key="{{ 'schedule-add-component-'.now() }}" :days="$this->days">

    <livewire:admin.schedule-component.schedule-update-component key="{{ 'schedule-update-component-'.now() }}" :days="$this->days" :professors="$this->professors">

    <livewire:admin.section-component.section-room-add-component>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
