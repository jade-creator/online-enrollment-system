<div class="max-w-5xl mx-auto p-4 md:p-8">
    <div class="w-full pl-0 md:pl-8">
        <x-jet-form-section submit="">
            <x-slot name="title">
                <span>Pre Registration</span>
                <div class="inline px-2 text-green-600 font-bold text-sm">
                    @if ( count($this->selected) > 0 && !$this->selectAll )
                        <span>{{ __('[ ')}}</span>
                        <span>{{ count($this->selected) }}</span>
                        <span>{{ __('selected ]')}}</span>
                    @endif

                    @if ( $this->selectAll )
                        <span>{{ __('selected all [ ')}}</span>
                        <span>{{ count($this->selected) }}</span>
                        <span>{{ __(' records ]')}}</span>
                    @endif
                </div>
            </x-slot>

            <x-slot name="description">
                {{ 'Welcome to the Pre-Registration Page. Please fill out these form accordingly.' }}

                <div x-data="{ open: true }">
                    <div @click="open = ! open"
                         @close.stop="open = false"
                         :class="{'': ! open, 'bg-gray-200': open }"
                         class="w-full flex items-center mt-4 justify-between md:gap-2 p-4 border-b border-t border-gray-200 focus:bg-gray-200 cursor-pointer">

                        <div>View Selected Students</div>
                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 mx-2 transition-transform duration-200 transform">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-90"
                         x-cloak
                         class="w-full border-b border-gray-200 cursor-pointer">

                        @forelse ($students as $index => $student)
                            @if ($loop->first)
                                <div class="grid grid-cols-12 gap-2 w-full p-4 border-b border-gray-200 text-sm font-bold">
                                    <div class="col-span-2">Student ID</div>
                                    <div class="col-span-9">Fullname</div>
                                    <div class="col-span-1">
                                        <input @click.stop type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent rounded-sm" title="Select Displayed Data">
                                    </div>
                                </div>
                            @endif

                            <div class="grid grid-cols-12 gap-2 p-4 font-bold hover:bg-gray-100">
                                <div class="col-span-2">{{ $student->id ?? 'N/A' }}</div>
                                <div class="col-span-9">{{ $student->user->person->shortFullName ?? 'N/A' }}</div>
                                <div class="col-span-1">
                                    <input wire:model="selected" wire:loading.attr="disabled" value="{{ $student->id }}" @click.stop type="checkbox" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent rounded-sm">
                                </div>
                            </div>
                        @empty
                            <div class="w-full p-4 text-center text-sm">No students found. 🤔</div>
                        @endforelse

                        {{ $students->links('partials.pagination-link') }}
                    </div>
                </div>
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 flex items-center">
                    <x-jet-label class="font-bold text-indigo-500 text-xs" for="subjects" value="{{ $prospectus->program->code . ' Subjects for:' }}"/>
                    <h1 class="mx-2">{{ $prospectus->level->level ?? 'N/A' }} - <span>{{ $prospectus->term->term ?? 'N/A' }}</span></h1>
                </div>
                <div class="col-span-6 -mt-4" id="subjects">
                    <x-table.main>
                        <x-slot name="filter"></x-slot>
                        <x-slot name="paginationLink"></x-slot>

                        <x-slot name="head">
                            <x-table.column-title class="col-span-2">code</x-table.column-title>
                            <x-table.column-title class="col-span-3">title</x-table.column-title>
                            <x-table.column-title class="col-span-1">unit</x-table.column-title>
                            <x-table.column-title class="col-span-3">co requisite</x-table.column-title>
                            <x-table.column-title class="col-span-3">pre requisite</x-table.column-title>
                        </x-slot>

                        <x-slot name="body">
                            @forelse ($prospectus->subjects as $index => $prospectus_subject)
                                <div wire:key="table-row-{{$prospectus_subject->subject->code}}">
                                    <x-table.row>
                                        <div name="slot" class="grid grid-cols-12 md:gap-2">
                                            <x-table.cell headerLabel="Code" class="justify-start md:col-span-2">{{ $prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell headerLabel="title" class="justify-start md:col-span-3" title="{{ $prospectus_subject->subject->title ?? 'N/A' }}">{{ $prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell headerLabel="unit" class="justify-start md:col-span-1">{{ $prospectus_subject->unit ?? 'N/A' }}</x-table.cell>
                                            <x-table.cell headerLabel="co requisite" class="justify-start md:col-span-3">
                                                @forelse ($prospectus_subject->corequisites as $requisite)
                                                    {{ $loop->first ? '' : ', '  }}
                                                    <span>&nbsp;{{ $requisite->code }}</span>
                                                @empty
                                                    {!! '<span class="text-gray-400">N/A</span>' !!}
                                                @endforelse
                                            </x-table.cell>
                                            <x-table.cell headerLabel="pre requisite" class="justify-start md:col-span-3">
                                                @forelse ($prospectus_subject->prerequisites as $requisite)
                                                    {{ $loop->first ? '' : ', '  }}
                                                    <span>&nbsp;{{ $requisite->code }}</span>
                                                @empty
                                                    {!! '<span class="text-gray-400">N/A</span>' !!}
                                                @endforelse
                                            </x-table.cell>
                                        </div>
                                    </x-table.row>
                                </div>
                            @empty
                                <x-table.no-result>No subjects found.🤔</x-table.no-result>
                            @endforelse
                        </x-slot>
                    </x-table.main>
                </div>
            </x-slot>

            <x-slot name="actions">
                <a href="{{ $route }}">
                    <x-jet-secondary-button class="hover:bg-indigo-100" wire:loading.attr="disabled">
                        {{ __('Go Back') }}
                    </x-jet-secondary-button>
                </a>

                @can ('register', $prospectus)
                    @if (count($this->selected) > 0)
                        <x-jet-button wire:click.prevent="save" class="ml-2 bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
                            {{ __('Register') }}
                        </x-jet-button>
                    @endif
                @endcan
            </x-slot>
        </x-jet-form-section>
        <x-jet-section-border/>
    </div>

    <x-table.bulk-action-bar :count="count($selected)"/>

    <x-jet-dialog-modal wire:model="selectingSection" maxWidth="sm">
        <x-slot name="title">Section List</x-slot>

        <x-slot name="content">
            <form class="w-full px-6 mb-2">
                <div class="w-full">
                    <x-jet-label for="sectionId" value="{{ __('Section') }}" class="my-2"/>
                    <select wire:model="sectionId" wire:loading.attr="disabled" name="sectionId">
                        @forelse ($sections as $section)
                            @if ($loop->first)
                                <option value="">Select a section</option>
                            @endif
                            <option value="{{ $section->id }}">{{ $section->name ?? 'N/A' }}</option>
                        @empty
                            <option value="">No sections found.</option>
                        @endforelse
                    </select>
                    <x-jet-input-error for="sectionId" class="mt-2"/>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('selectingSection')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="proceed" wire:loading.attr="disabled">
                {{ __('Proceed') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
