<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Grading"/>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter/>
            </x-slot>

            <x-slot name="paginationLink">
                {{ $registrations->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2">
                    <x-table.sort-button event="sortFieldSelected('id')">reg. ID</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-2">student</x-table.column-title>
                <x-table.column-title class="col-span-3">program</x-table.column-title>
                <x-table.column-title class="col-span-2">section</x-table.column-title>
                <x-table.column-title class="col-span-2">classification</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div wire:key="table-row-{{$registration->id}}" x-data="{ open: false }">
                        <x-table.row>
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$registration->id">
                                    {{ $registration->custom_id ?? 'N/A' }}
                                </x-table.cell-checkbox>
                                <x-table.cell headerLabel="Student" class="justify-start md:col-span-2">
                                    @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                        <div class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $registration->student->user->profile_photo_url ?? 'N/A' }}"/></div>
                                    @endif
                                    <div class="flex flex-col my-2 md:my-0">
                                        <div>{{ $registration->student->user->person->short_full_name ?? 'N/A'}}</div>
                                        <div class="font-bold text-gray-400 text-xs pt-0.5">ID: {{ $registration->student->custom_id ?? 'N/A' }}</div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell headerLabel="program" class="justify-start md:col-span-3">
                                    <div class="flex flex-col my-2 md:my-0">
                                        <div>{!! $registration->prospectus->program->program ?? '<span class="text-gray-400">N/A</span>' !!}</div>
                                        <div class="tracking-widest text-gray-500 text-xs pt-0.5">
                                            {!! $registration->prospectus->level->level ?? '<span class="text-gray-400">N/A</span>' !!} - {{ $registration->prospectus->term->term ?? '<span class="text-gray-400">N/A</span>' }}
                                        </div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell headerLabel="section" class="justify-start md:col-span-2">{{ $registration->section->name ?? '<span class="text-gray-400">N/A</span>' }}</x-table.cell>
                                <x-table.cell headerLabel="classification" class="justify-start md:col-span-2">{{ $registration->classification ?? '<span class="text-gray-400">N/A</span>' }}</x-table.cell>
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

                                                <a href="{{ route('pre.registration.view', $registration->id) }}">
                                                    <x-table.cell-button title="View">
                                                        <x-icons.view-icon/>
                                                    </x-table.cell-button>
                                                </a>

                                                <a href="{{ route('admin.grade.report', $registration) }}">
                                                    <x-table.cell-button title="Grade Report">
                                                        <x-icons.grade-icon/>
                                                    </x-table.cell-button>
                                                </a>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </x-table.cell-action>
                            </div>
                        </x-table.row>

                        <livewire:admin.grade-component.grade-view-component :registration="$registration" key="'grade-view-component-'{{ $registration->id.now() }}">
                    </div>
                @empty
                    <x-table.no-result>No registrations found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>
    </div>

    <div>@include('partials.loading')</div>

    <livewire:admin.grade-component.grade-update-component key="'grade-update-component-'{{ now() }}">

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
