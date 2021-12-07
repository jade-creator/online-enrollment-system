<div>
    <div class="w-full p-4">
        <x-table.title tableTitle="{{ $section->name ?? 'N/A' }} Student List" :isSelectedAll="$this->selectAll" :count="count($this->selected)"/>
    </div>

    <div class="w-full max-w-7xl mx-auto p-4 sm:px-6 lg:px-8">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="mb-4 md:mb-2">
                <ul class="list-none flex flex-col md:flex-row font-semibold">
                    <li class="text-indigo-500 bg-white md:bg-transparent p-1 md:p-0 border md:border-0">
                        <span class="block md:hidden">{{ $section->prospectus->program->code ?? 'N/A' }}</span>
                        <span class="hidden md:block">{{ $section->prospectus->program->program ?? 'N/A' }}</span>
                    </li>
                    <li class="hidden md:block text-gray-400 mx-3.5">/</li>
                    <li class="text-indigo-500 bg-white md:bg-transparent p-1 md:p-0 border md:border-0">
                        <span class="">{{ $section->prospectus->level->level ?? 'N/A' }}</span>
                    </li>
                    <li class="hidden md:block text-gray-400 mx-3.5">/</li>
                    <li class="text-indigo-500 bg-white md:bg-transparent p-1 md:p-0 border md:border-0">
                        <span class="">{{ $section->prospectus->term->term ?? 'N/A' }}</span>
                    </li>
                    <li class="hidden md:block text-gray-400 mx-3.5">/</li>
                    <li class="text-indigo-500 bg-white md:bg-transparent p-1 md:p-0 border md:border-0">
                        <span class="">{{ $curriculum->code ?? 'N/A' }}</span>
                    </li>
                </ul>
            </div>

            <div class="grid grid-cols-12 md:gap-2 bg-transparent md:bg-indigo-500 border-2 border-indigo-500 p-4 font-bold text-indigo-500 md:text-white">
                <div class="col-span-1">
                    <input @click.stop type="checkbox" wire:model="selectPage" class="mx-3 cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent rounded-sm" title="Select Displayed Data">
                </div>
                <div class="col-span-2 hidden md:block">Student ID</div>
                <div class="col-span-6 hidden md:block">Fullname</div>
                <div class="col-span-2 hidden md:block">Registration ID</div>
                <div class="col-span-1 hidden md:block text-center">Action</div>
                <div class="col-span-11 block md:hidden">Select All</div>
            </div>
            @forelse ($registrations as $registration)
                <div wire:key="table-row-{{$registration->id}}" x-data="{ open: false }">
                    <div @click="open = ! open"
                         @close.stop="open = false"
                         class="grid grid-cols-12 md:gap-2 my-2 border-b border-gray-500 md:border-gray-200 hover:bg-gray-200 cursor-pointer">
                        <div class="col-span-12 md:col-span-1 flex items-center p-4 bg-indigo-500 md:bg-transparent text-white md:text-black">
                            <input wire:model="selected" wire:loading.attr="disabled" value="{{ $registration->id }}" @click.stop type="checkbox" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
                            <span class="block md:hidden">{{ $registration->student->custom_id ?? '' }}</span>
                        </div>
                        <div class="hidden md:flex col-span-12 md:col-span-2 p-4 items-center">{{ $registration->student->custom_id ?? '' }}</div>
                        <div class="col-span-12 md:col-span-6 flex items-center">
                            <span class="block md:hidden text-indigo-500 w-1/2 border-l border-b border-gray-500 p-4">Fullname:</span>
                            <span class="w-1/2 flex items-center border-l border-r border-b md:border-0 border-gray-500 p-4">
                                @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                    <img class="h-6 md:h-8 w-6 md:w-8 rounded-full object-cover mr-2 md:mr-4" src="{{ $registration->student->user->profile_photo_url ?? 'N/A' }}"/>
                                @endif
                                <span>{{ $registration->student->user->person->shortFullName ?? '' }}</span>
                            </span>
                        </div>
                        <div class="col-span-12 md:col-span-2 flex items-center">
                            <span class="block md:hidden text-indigo-500 w-1/2 border-l border-b border-gray-500 p-4">Registration ID:</span>
                            <span class="w-1/2 border-l border-r border-b md:border-0 border-gray-500 p-4">
                                <a @click.stop href="{{ route('pre.registration.view', $registration->id) }}" target="_blank" class="underline text-indigo-500">{{ $registration->custom_id ?? '' }}</a>
                            </span>
                        </div>
                        <div class="col-span-12 md:col-span-1 text-center p-4 border-l border-r md:border-0 border-gray-500">
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 mx-2 transition-transform duration-200 transform">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>

                    <x-table.nested-row>
                        <x-slot name="nestedTable">
                            <livewire:admin.grade-component.grade-view-component :registration="$registration" key="'grade-view-component-'{{ $registration->id.now() }}">
                        </x-slot>
                    </x-table.nested-row>
                </div>
            @empty
                <x-table.no-result>No students found. 🤔</x-table.no-result>
                <x-jet-section-border/>
            @endforelse

            {{ $registrations->links('partials.pagination-link') }}
        </div>
    </div>

    <x-table.bulk-action-bar :count="count($selected)">
        @can ('enroll', App\Models\User::class)
            <x-table.bulk-action-button nameButton="Register" event="confirmBulkStudentsRegistration">
                <x-icons.pre-enrollment-icon/>
            </x-table.bulk-action-button>
        @endcan

        <button wire:click.prevent="$emit('modalViewingBulkGrade')" class="w-20 py-4 border-t-4 border-indigo-500 border-opacity-0 hover:border-opacity-100 flex flex-col items-center outline-none focus:outline-none transition-all duration-300 ease-in-out" type="button">
            <x-icons.grade-icon/>
            <p class="pt-1 text-xs font-semibold">Grade</p>
        </button>
    </x-table.bulk-action-bar>

    <livewire:admin.grade-component.grade-update-component key="'grade-update-component-'{{ now() }}">

    <livewire:admin.grade-component.bulk-grade-update-component key="'bulk-grade-update-component-'{{ now() }}" :section="$section" :selected="$selected">

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
