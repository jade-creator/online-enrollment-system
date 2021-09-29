<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Prospectus">
            @can('create', App\Models\ProspectusSubject::class)
                <x-table.nav-button wire:click.prevent="$emit('modalAddingSubject')">
                    Add Subject
                </x-table.nav-button>
            @endcan
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter :isSearchable="false" :isFilterable="false">
                    <livewire:partials.prospectus-dropdown/>
                </x-table.filter>
            </x-slot>

            <x-slot name="paginationLink"></x-slot>

            <x-slot name="head">
                <x-table.column-title class="col-span-2">code</x-table.column-title>
                <x-table.column-title class="col-span-3">title</x-table.column-title>
                <x-table.column-title class="col-span-2">unit</x-table.column-title>
                <x-table.column-title class="col-span-2">co-requisite</x-table.column-title>
                <x-table.column-title class="col-span-2">pre-requisite</x-table.column-title>
                <x-table.column-title class="col-span-1">option</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($coRequisites as $prospectus_subject)
                    <x-table.row>
                        <div name="slot" class="grid grid-cols-12 gap-2">
                            <x-table.cell class="h-10 justify-start md:col-span-2">{{ $prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
                            <x-table.cell class="justify-start md:col-span-3">{{ $prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                            <x-table.cell class="justify-start md:col-span-2">{{ $prospectus_subject->unit ?? 'N/A' }}</x-table.cell>
                            <x-table.cell class="justify-start md:col-span-2">
                                @forelse ($prospectus_subject->corequisites as $subject)
                                    {{ $loop->first ? '' : ', '  }}
                                    <a href="{{ route('admin.subjects.view', ['search' => $subject->title]) }}" class="text-indigo-500 underline">{{ $subject->code }}</a>
                                @empty
                                    N/A
                                @endforelse
                            </x-table.cell>
                            <x-table.cell class="justify-start md:col-span-2">
                                @forelse ($prospectus_subject->prerequisites as $subject)
                                    {{ $loop->first ? '' : ', '  }}
                                    <a href="{{ route('admin.subjects.view', ['search' => $subject->title]) }}" class="text-indigo-500 underline">{{ $subject->code }}</a>
                                @empty
                                    N/A
                                @endforelse
                            </x-table.cell>
                            <x-table.cell-action>
                                <x-jet-dropdown align="right" width="60" dropdownClasses="z-10 shadow-2xl">
                                    <x-slot name="trigger">
                                        <x-table.cell-dropdown-trigger-btn/>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="w-60">
                                            <div class="block px-4 py-3 text-sm text-gray-500 font-bold">
                                                {{ __('Actions') }}
                                            </div>
                                            @can ('update', $prospectus_subject)
                                                <x-table.cell-button wire:click.prevent="$emit('modalViewingSubject', {{ $prospectus_subject }})" title="View">
                                                    <x-icons.view-icon/>
                                                </x-table.cell-button>
                                            @endcan

                                            @can ('destroy', $prospectus_subject)
                                                <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$prospectus_subject}})" title="Delete">
                                                    <x-icons.delete-icon/>
                                                </x-table.cell-button>
                                            @endcan
                                        </div>
                                    </x-slot>
                                </x-jet-dropdown>
                            </x-table.cell-action>
                        </div>
                    </x-table.row>
                @empty
                    <x-table.no-result>No subjects found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>

    <livewire:admin.prospectus-component.prospectus-add-component :prospectusId="$prospectusId" :coRequisites="$coRequisites" :preRequisites="$preRequisites" :subjects="$allSubjects"
                                                                  key="{{ 'prospectus-add-component-'.now() }}">

    <livewire:admin.prospectus-component.prospectus-update-component :coRequisites="$coRequisites" :preRequisites="$preRequisites" :subjects="$allSubjects" key="{{ 'prospectus-update-component-'.now() }}">

    <livewire:admin.prospectus-component.prospectus-destroy-component>
</div>
