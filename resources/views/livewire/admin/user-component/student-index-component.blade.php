<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Students" :isSelectedAll="$this->selectAll" :count="count($this->selected)"></x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter></x-table.filter>
            </x-slot>

            <x-slot name="paginationLink">{{ $students->links('partials.pagination-link') }}</x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-center">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox" class="mx-3 cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('custom_id')">student id</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-4">user account</x-table.column-title>
                <x-table.column-title class="col-span-3">grand total</x-table.column-title>
                <x-table.column-title class="col-span-2">balance</x-table.column-title>
                <div class="col-span-1"><x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button></div>
            </x-slot>

            <x-slot name="body">
                @forelse ($students as $student)
                    <div wire:key="table-row-{{$student->id}}">
                        <x-table.row :active="$this->isSelected($student->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$student->id">{{ $student->custom_id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="user" class="justify-start md:col-span-4 md:flex items-center" title="username: {{ $student->user->name ?? 'N/A' }}">
                                    @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                        <div class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $student->user->profile_photo_url ?? 'N/A' }}"/></div>
                                    @endif
                                    <div class="flex flex-col my-2 md:my-0">
                                        <div>{{ $student->user->person->full_name ?? 'N/A'}}</div>
                                        <div class="font-bold text-gray-400 text-xs pt-0.5">{{ $student->user->email ?? 'N/A' }}</div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell headerLabel="Grand total" class="justify-start md:col-span-3">
                                    {{ $student->getFormattedPriceAttribute($student->grandTotal->sum('grand_total')) ?? 'N/A' }}
                                </x-table.cell>
                                <x-table.cell headerLabel="Balance" class="justify-start md:col-span-2">{{ $student->getFormattedPriceAttribute($student->grandTotal->sum('balance')) ?? 'N/A' }}</x-table.cell>
                                <x-table.cell-action>
                                    @if (!count($selected) > 0)
                                        <x-jet-dropdown align="right" width="60" dropdownClasses="z-10 shadow-2xl">
                                            <x-slot name="trigger"><x-table.cell-dropdown-trigger-btn/></x-slot>

                                            <x-slot name="content">
                                                <div class="w-60">
                                                    <div class="block px-4 py-3 text-sm text-gray-500 font-bold">
                                                        {{ __('Actions') }}
                                                    </div>
                                                    <a href="{{ route('admin.student.update', $student) }}">
                                                        <x-table.cell-button title="View">
                                                            <x-icons.view-icon/>
                                                        </x-table.cell-button>
                                                    </a>

                                                    <a href="{{ route('user.personal.profile.view', $student->user->id) }}">
                                                        <x-table.cell-button title="Personal Profile">
                                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="user" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                        </x-table.cell-button>
                                                    </a>

                                                    <a href="{{ route('admin.students.registration.create', ['student' => $student]) }}">
                                                        <x-table.cell-button title="Register">
                                                            <x-icons.pre-enrollment-icon/>
                                                        </x-table.cell-button>
                                                    </a>
                                                </div>
                                            </x-slot>
                                        </x-jet-dropdown>
                                    @endif
                                </x-table.cell-action>
                            </div>
                        </x-table.row>
                    </div>
                @empty
                    <x-table.no-result>No students found.????</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                <x-icons.export-icon/>
            </x-table.bulk-action-button>
        </x-table.bulk-action-bar>
    </div>

    <div>@include('partials.loading')</div>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @elseif (session()->has('student-index-alert'))
        <x-form.alert type="{{session('student-index-alert')['type']}}">{!!session()->pull('student-index-alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
