<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Prospectus">
            <x-table.nav-button wire:click.prevent="add">
                Add Subject
            </x-table.nav-button>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <div class="flex items-center justify-between pt-4 py-6">
                    {{-- MOBILE SCREENS --}}
                    <ul class="block sm:hidden list-none w-full font-semibold text-sm">
                        @isset ($program)
                            @if ($this->programs->count() == 1)
                                <li class="text-indigo-500">{{ $program->program ?? 'N/A' }}</li>
                            @else
                                <li class="w-full cursor-pointer">
                                    <x-jet-dropdown align="left" width="w-full" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <div :class="{'border-indigo-500': open, '': ! open}"
                                                 class="w-full h-full p-2 border flex items-center justify-between">
                                                {{ $program->program ?? 'N/A' }}
                                                <div class="w-3 overflow-hidden inline-block mx-1">
                                                    <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-full">
                                                <ul class="font-normal text-indigo-500">
                                                    @foreach ($this->programs as $program_m)
                                                        <li class="hover:bg-gray-200 {{ $program_m->id == $programId ? 'bg-gray-200' : ''}}" title="{{ $program_m->program ?? 'N/A' }}">
                                                            <a href="{{ route('admin.prospectuses.view', ['programId' => $program_m->id, 'levelId' => $levelId, 'semesterId' => $semesterId, 'curriculumId' => $curriculumId]) }}" class="block w-full h-full relative p-2">
                                                                <span class="text-sm truncate">{{ $program_m->program ?? 'N/A' }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </li>
                            @endif
                        @else
                            <li class="hover:underline cursor-not-allowed text-gray-400">No programs</li>
                        @endisset

                        @isset ($level)
                            @if ($this->levels->count() == 1)
                                <li class="text-indigo-500">{{ $level->level ?? 'N/A' }}</li>
                            @else
                                <li class="w-full cursor-pointer">
                                    <x-jet-dropdown align="left" width="w-full" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <div :class="{'border-indigo-500': open, '': ! open}"
                                                 class="w-full h-full p-2 border flex items-center justify-between">
                                                {{ $level->level ?? 'N/A' }}
                                                <div class="w-3 overflow-hidden inline-block mx-1">
                                                    <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-full">
                                                <ul class="font-normal text-indigo-500">
                                                    @foreach ($this->getProgramLevels() as $level_m)
                                                        <li class="hover:bg-gray-200 {{  $level_m->level->id == $levelId ? 'bg-gray-200' : ''}}">
                                                            <a href="{{ route('admin.prospectuses.view', ['programId' => $programId, 'levelId' => $level_m->level->id, 'semesterId' => $semesterId, 'curriculumId' => $curriculumId]) }}" class="block w-full h-full relative p-2">
                                                                <span class="text-sm truncate">{{ $level_m->level->level ?? 'N/A' }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </li>
                            @endif
                        @else
                            <li class="hover:underline cursor-not-allowed text-gray-400">No levels</li>
                        @endisset

                        @isset ($semester)
                            @if ($this->terms->count() == 1)
                                <li class="text-indigo-500">{{ $semester->term ?? 'N/A' }}</li>
                            @else
                                <li class="w-full cursor-pointer">
                                    <x-jet-dropdown align="left" width="w-full" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <div :class="{'border-indigo-500': open, '': ! open}"
                                                 class="w-full h-full p-2 border flex items-center justify-between">
                                                {{ $semester->term ?? 'N/A' }}
                                                <div class="w-3 overflow-hidden inline-block mx-1">
                                                    <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-full">
                                                <ul class="font-normal text-indigo-500">
                                                    @foreach ($this->terms as $semester_m)
                                                        <li class="hover:bg-gray-200 {{ $semester_m->id == $semesterId ? 'bg-gray-200' : ''}}">
                                                            <a href="{{ route('admin.prospectuses.view', ['programId' => $programId, 'levelId' => $levelId, 'semesterId' => $semester_m->id, 'curriculumId' => $curriculumId]) }}" class="block w-full h-full relative p-2">
                                                                <span class="text-sm truncate">{{ $semester_m->term ?? 'N/A' }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </li>
                            @endif
                        @else
                            <li class="hover:underline cursor-not-allowed text-gray-400">No semesters</li>
                        @endisset

                        @isset ($curriculum)
                            @if ($curriculums->count() == 1)
                                <li class="text-indigo-500 w-full h-full p-2 border">{{ $curriculum->code ?? 'N/A' }}</li>
                            @else
                                <li class="w-full cursor-pointer">
                                    <x-jet-dropdown align="left" width="w-full" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <div :class="{'border-indigo-500': open, '': ! open}"
                                                 class="w-full h-full p-2 border flex items-center justify-between">
                                                {{ $curriculum->code ?? 'N/A' }}
                                                <div class="w-3 overflow-hidden inline-block mx-1">
                                                    <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-full">
                                                <ul class="font-normal text-indigo-500">
                                                    @foreach ($this->curriculums as $curriculum_m)
                                                        <li class="hover:bg-gray-200 {{ $curriculum_m->id == $curriculumId ? 'bg-gray-200' : ''}}">
                                                            <a href="{{ route('admin.prospectuses.view', ['programId' => $programId, 'levelId' => $levelId, 'semesterId' => $semesterId, 'curriculumId' => $curriculum_m->id]) }}" class="block w-full h-full relative p-2">
                                                             <span class="md:text-sm flex items-center">
                                                                @if ($curriculum_m->isActive)
                                                                    <div class="mr-2 font-bold rounded-full bg-green-400 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                                                                @endif
                                                                {{ $curriculum_m->code ?? 'N/A' }}
                                                             </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </li>
                            @endif
                        @else
                            <li class="hover:underline cursor-not-allowed text-gray-400">No curriculum</li>
                        @endisset
                    </ul>

                    {{-- WIDE SCREENS --}}
                    <ul class="hidden sm:flex list-none w-full font-semibold">
                        @isset ($program)
                            @if ($this->programs->count() == 1)
                                <li class="text-indigo-500">
                                    <span class="block md:hidden">{{ $program->code ?? 'N/A' }}</span>
                                    <span class="hidden md:block">{{ $program->program ?? 'N/A' }}</span>
                                </li>
                            @else
                                <li class="hover:underline cursor-pointer">
                                    <x-jet-dropdown align="left" width="60" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <div class="flex items-end">
                                                <span class="block md:hidden">{{ $program->code ?? 'N/A' }}</span>
                                                <span class="hidden md:block">{{ $program->program ?? 'N/A' }}</span>
                                                <div class="w-3 overflow-hidden inline-block mx-1 mb-1.5">
                                                    <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-60">
                                                <ul class="font-normal text-indigo-500">
                                                    @foreach ($this->programs as $program)
                                                        <li class="hover:bg-gray-200 {{ $program->id == $programId ? 'bg-gray-200' : ''}}" title="{{ $program->program ?? 'N/A' }}">
                                                            <a href="{{ route('admin.prospectuses.view', ['programId' => $program->id, 'levelId' => $levelId, 'semesterId' => $semesterId, 'curriculumId' => $curriculumId]) }}" class="block w-full h-full relative p-2">
                                                                <span class="block md:hidden">{{ $program->code ?? 'N/A' }}</span>
                                                                <span class="hidden md:block text-sm truncate">{{ $program->program ?? 'N/A' }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </li>
                            @endif
                        @else
                            <li class="hover:underline cursor-not-allowed text-gray-400">No programs</li>
                        @endisset
                        <li class="text-gray-400 mx-3.5">/</li>

                        @isset ($level)
                            @if ($this->levels->count() == 1)
                                <li class="text-indigo-500">{{ $level->level ?? 'N/A' }}</li>
                            @else
                                <li class="hover:underline cursor-pointer">
                                    <x-jet-dropdown align="left" width="40" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <div class="flex items-end">
                                                {{ $level->level ?? 'N/A' }}
                                                <div class="w-3 overflow-hidden inline-block mx-1 mb-1.5">
                                                    <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-40">
                                                <ul class="font-normal text-indigo-500">
                                                    @foreach ($this->getProgramLevels() as $level)
                                                        <li class="hover:bg-gray-200 {{ $level->level->id == $levelId ? 'bg-gray-200' : ''}}">
                                                            <a href="{{ route('admin.prospectuses.view', ['programId' => $programId, 'levelId' => $level->level->id, 'semesterId' => $semesterId, 'curriculumId' => $curriculumId]) }}" class="block w-full h-full relative p-2">
                                                                <span class="md:text-sm">{{ $level->level->level ?? 'N/A' }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </li>
                            @endif
                        @else
                            <li class="hover:underline cursor-not-allowed text-gray-400">No levels</li>
                        @endisset
                        <li class="text-gray-400 mx-3.5">/</li>

                        @isset ($semester)
                            @if ($this->terms->count() == 1)
                                <li class="text-indigo-500">{{ $semester->term ?? 'N/A' }}</li>
                            @else
                                <li class="hover:underline cursor-pointer">
                                    <x-jet-dropdown align="left" width="48" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <div class="flex items-end">
                                                {{ $semester->term ?? 'N/A' }}
                                                <div class="w-3 overflow-hidden inline-block mx-1 mb-1.5">
                                                    <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-48">
                                                <ul class="font-normal text-indigo-500">
                                                    @foreach ($this->terms as $semester)
                                                        <li class="hover:bg-gray-200 {{ $semester->id == $semesterId ? 'bg-gray-200' : ''}}">
                                                            <a href="{{ route('admin.prospectuses.view', ['programId' => $programId, 'levelId' => $levelId, 'semesterId' => $semester->id, 'curriculumId' => $curriculumId]) }}" class="block w-full h-full relative p-2">
                                                                <span class="md:text-sm">{{ $semester->term ?? 'N/A' }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </li>
                            @endif
                        @else
                            <li class="hover:underline cursor-not-allowed text-gray-400">No terms</li>
                        @endisset
                        <li class="text-gray-400 mx-3.5">/</li>

                        @isset ($curriculum)
                            @if ($curriculums->count() == 1)
                                <li class="text-indigo-500">{{ $curriculum->code ?? 'N/A' }}</li>
                            @else
                                <li class="hover:underline cursor-pointer">
                                    <x-jet-dropdown align="left" width="48" dropdownClasses="z-10 shadow-2xl">
                                        <x-slot name="trigger">
                                            <div class="flex items-end">
                                                {{ $curriculum->code ?? 'N/A' }}
                                                <div class="w-3 overflow-hidden inline-block mx-1 mb-1.5">
                                                    <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-48">
                                                <ul class="font-normal text-indigo-500">
                                                    @foreach ($curriculums as $curriculum)
                                                        <li class="hover:bg-gray-200 {{ $curriculum->id == $curriculumId ? 'bg-gray-200' : ''}}">
                                                            <a href="{{ route('admin.prospectuses.view', ['programId' => $programId, 'levelId' => $levelId, 'semesterId' => $semesterId, 'curriculumId' => $curriculum->id]) }}" class="block w-full h-full relative p-2">
                                                                <span class="md:text-sm flex items-center">
                                                                    @if ($curriculum->isActive)
                                                                        <div class="mr-2 font-bold rounded-full bg-green-400 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                                                                    @endif
                                                                    {{ $curriculum->code ?? 'N/A' }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </li>
                            @endif
                        @else
                            <li class="hover:underline cursor-not-allowed text-gray-400">No curriculum</li>
                        @endisset
                    </ul>
                </div>
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
                        <div name="slot" class="grid grid-cols-12 md:gap-2">
                            <x-table.cell headerLabel="Code" class="justify-start md:col-span-2 flex items-center" title="{{ $prospectus_subject->computed_element ?? 'N/A' }}">
                                @if ($prospectus_subject->isComputed)
                                     <div class="mx-2 font-bold rounded-full bg-green-400 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                                @else
                                    <div class="mx-2 font-bold rounded-full bg-red-400 flex items-center justify-center" style="height: 8px; width: 8px; font-size: 5px;">&nbsp;</div>
                                @endif
                                {!! $prospectus_subject->subject->code ?? '<span class="text-gray-400">N/A</span>' !!}
                            </x-table.cell>
                            <x-table.cell headerLabel="Title" class="justify-start md:col-span-3">{!! $prospectus_subject->subject->title ?? '<span class="text-gray-400">N/A</span>' !!}</x-table.cell>
                            <x-table.cell headerLabel="Unit" class="justify-start md:col-span-2">{!! $prospectus_subject->unit ?? '<span class="text-gray-400">N/A</span>' !!}</x-table.cell>
                            <x-table.cell headerLabel="Co-requisite" class="justify-start md:col-span-2">
                                @forelse ($prospectus_subject->corequisites as $subject)
                                    {{ $loop->first ? '' : ', '  }}
                                    <a href="{{ route('admin.subjects.view', ['search' => $subject->title]) }}" class="text-indigo-500 underline">{{ $subject->code }}</a>
                                @empty
                                    <span class="text-gray-400">N/A</span>
                                @endforelse
                            </x-table.cell>
                            <x-table.cell headerLabel="Pre-requisite" class="justify-start md:col-span-2">
                                @forelse ($prospectus_subject->prerequisites as $subject)
                                    {{ $loop->first ? '' : ', '  }}
                                    <a href="{{ route('admin.subjects.view', ['search' => $subject->title]) }}" class="text-indigo-500 underline">{{ $subject->code }}</a>
                                @empty
                                    <span class="text-gray-400">N/A</span>
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

                                            <x-table.cell-button wire:click.prevent="$emit('modalViewingSubject', {{ $prospectus_subject }})" title="View">
                                                <x-icons.view-icon/>
                                            </x-table.cell-button>

                                            <x-table.cell-button wire:click.prevent="$emit('removeConfirm', {{$prospectus_subject}})" title="Delete" class="rounded-b-md hover:bg-red-500 hover:text-white transition-colors">
                                                <x-icons.delete-icon/>
                                            </x-table.cell-button>
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

    <div>@include('partials.loading')</div>

    <livewire:admin.prospectus-component.prospectus-add-component :prospectusId="$prospectus->id" :coRequisites="$coRequisites" :preRequisites="$preRequisites" :subjects="$allSubjects"
                                                                 :curriculumId="$curriculumId" key="{{ 'prospectus-add-component-'.now() }}">

    <livewire:admin.prospectus-component.prospectus-update-component :coRequisites="$coRequisites" :preRequisites="$preRequisites" :subjects="$allSubjects"
                                                                 :curriculumId="$curriculumId" key="{{ 'prospectus-update-component-'.now() }}">

    <livewire:admin.prospectus-component.prospectus-destroy-component :curriculumId="$curriculumId" key="{{ 'prospectus-destroy-component-'.now() }}">

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
