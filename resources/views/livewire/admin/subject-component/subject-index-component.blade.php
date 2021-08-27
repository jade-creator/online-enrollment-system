<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Subjects" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            @can('create', App\Models\Subject::class)
                <x-table.nav-button wire:click.prevent="$emit('modalAddingSubject')">
                    Add Subject
                </x-table.nav-button>
            @endcan
        </x-table.title>

        <x-table.filter/>

        <x-table.main>

            <x-slot name="paginationLink">
                {{ $subjects->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-start">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox"  class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('id')">ID</x-table.sort-button>
                </div>
                <div class="col-span-2">
                    <x-table.sort-button event="sortFieldSelected('code')">code</x-table.sort-button>
                </div>
                <div class="col-span-3">
                    <x-table.sort-button event="sortFieldSelected('title')">title</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-4">description</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($subjects as $subject)
                    <div wire:key="table-row-{{$subject->id}}" x-data="{ open: false }">
                        <x-table.row :active="$this->isSelected($subject->id)">
                            <div name="slot" class="grid grid-cols-12 gap-2">
                                <x-table.cell-checkbox :value="$subject->id"/>
                                <x-table.cell class="justify-start md:col-span-2">{{ $subject->code ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-3">{{ $subject->title ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-4">{{ $subject->description ?? 'N/A' }}</x-table.cell>
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
                                                    @can ('update', $subject)
                                                        <x-table.cell-button wire:click.prevent="$emit('modalViewingSubject', {{ $subject }})" title="View">
                                                            <x-icons.view-icon/>
                                                        </x-table.cell-button>
                                                    @endcan

{{--                                                    @can ('destroy', $section)--}}
                                                        <x-table.cell-button wire:click.prevent="$emitSelf('removeConfirm', {{$subject}})" title="Delete">
                                                            <x-icons.delete-icon/>
                                                        </x-table.cell-button>
{{--                                                    @elsecan ('view', App\Models\Section::class)--}}
{{--                                                        <x-table.cell-button title="Administrative Access">--}}
{{--                                                            <x-icons.lock-icon/>--}}
{{--                                                        </x-table.cell-button>--}}
{{--                                                    @endcan--}}
                                                </div>
                                            </x-slot>
                                        </x-jet-dropdown>
                                    @endif
                                </x-table.cell-action>
                            </div>
                        </x-table.row>
                    </div>
                @empty
                    <x-table.no-result>No subjects found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.subject-component.subject-add-component>

    <livewire:admin.subject-component.subject-update-component>

    <livewire:admin.subject-component.subject-destroy-component>
</div>
