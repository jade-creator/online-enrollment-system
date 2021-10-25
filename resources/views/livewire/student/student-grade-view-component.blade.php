<div class="w-full">
    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Prospectus"></x-table.title>

        <x-table.main>
            <x-slot name="filter"></x-slot>

            <x-slot name="paginationLink"></x-slot>

            <x-slot name="head"></x-slot>

            <x-slot name="body">
                <ul class="list-none flex font-semibold">
                    <li class="text-indigo-500">
                        <span class="block md:hidden">{{ auth()->user()->student->program->code ?? 'N/A' }}</span>
                        <span class="hidden md:block">{{ auth()->user()->student->program->program ?? 'N/A' }}</span>
                    </li>
                    <li class="text-gray-400 mx-3.5">/</li>
                    @isset ($level)
                        <li class="hover:underline cursor-pointer">
                            <x-jet-dropdown align="left" width="40" dropdownClasses="z-10 shadow-2xl">
                                <x-slot name="trigger">
                                    <div>
                                        {{ $level->level }}
                                        <div class="w-3 overflow-hidden inline-block mx-1">
                                            <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                        </div>
                                    </div>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-40">
                                        <ul class="font-normal text-indigo-500">
                                            @foreach ($this->levels as $level)
                                                <li class="p-2 hover:bg-gray-200 {{ $level->level->id == $levelId ? 'bg-gray-200' : ''}}">
                                                    <a href="{{ route('student.grades.view', ['levelId' => $level->level->id, 'semesterId' => $semesterId]) }}" class="block w-full h-full">
                                                        {{ $level->level->level }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </li>
                    @else
                        <li class="hover:underline cursor-not-allowed">N/A</li>
                    @endisset

                    <li class="text-gray-400 mx-3.5">/</li>
                    @isset ($semester)
                        <li class="hover:underline cursor-pointer">
                            <x-jet-dropdown align="left" width="40" dropdownClasses="z-10 shadow-2xl">
                                <x-slot name="trigger">
                                    <div>
                                        {{ $semester->term }}
                                        <div class="w-3 overflow-hidden inline-block mx-1">
                                            <div class="h-2 w-2 bg-gray-400 -rotate-45 transform origin-top-left"></div>
                                        </div>
                                    </div>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-40">
                                        <ul class="font-normal text-indigo-500">
                                            @foreach ($this->terms as $semester)
                                                <li class="p-2 hover:bg-gray-200 {{ $semester->id == $semesterId ? 'bg-gray-200' : ''}}">
                                                    <a href="{{ route('student.grades.view', ['levelId' => $levelId, 'semesterId' => $semester->id]) }}"  class="block w-full h-full">
                                                        {{ $semester->term }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </li>
                    @else
                        <li class="hover:underline cursor-not-allowed">N/A</li>
                    @endisset
                </ul>

                <div class="mt-6">
                    <div class="py-4 hidden md:grid grid-cols-12 gap-2 px-4 bg-indigo-500">
                        <x-table.column-title class="col-span-1 justify-center"><span class="text-white">code</span></x-table.column-title>
                        <x-table.column-title class="col-span-2 justify-center"><span class="text-white">title</span></x-table.column-title>
                        <x-table.column-title class="col-span-2 justify-center"><span class="text-white">description</span></x-table.column-title>
                        <x-table.column-title class="col-span-1 justify-center"><span class="text-white">unit</span></x-table.column-title>
                        <x-table.column-title class="col-span-2 justify-center"><span class="text-white">co-requisite</span></x-table.column-title>
                        <x-table.column-title class="col-span-2 justify-center"><span class="text-white">pre-requisite</span></x-table.column-title>
                        <x-table.column-title class="col-span-1 justify-center"><span class="text-white">remark</span></x-table.column-title>
                        <x-table.column-title class="col-span-1 justify-center"><span class="text-white">grade</span></x-table.column-title>
                    </div>

                    @forelse ($this->prospectus->subjects as $prospectus_subject)
                        <div class="grid grid-cols-12 md:my-0 my-4 bg-white">
                            <div class="flex items-center col-span-12 md:col-span-1 font-bold text-xs border border-indigo-500 md:border-gray-200 bg-indigo-500 md:bg-transparent">
                                <p class="md:hidden w-1/2 h-full uppercase px-2 text-white md:text-indigo-500 border-r flex items-center">code</p>
                                <p class="break-words w-1/2 md:w-full py-4 px-2 text-white md:text-black">{{ $prospectus_subject->subject->code ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center col-span-12 md:col-span-2 font-bold text-xs border">
                                <p class="md:hidden w-1/2 h-full uppercase px-2 text-indigo-500 border-r flex items-center">Title</p>
                                <p class="break-words w-1/2 md:w-full py-4 px-2">{{ $prospectus_subject->subject->title ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center col-span-12 md:col-span-2 font-bold text-xs border">
                                <p class="md:hidden w-1/2 h-full uppercase px-2 text-indigo-500 border-r flex items-center">description</p>
                                <p class="break-words w-1/2 md:w-full py-4 px-2">{{ $prospectus_subject->subject->description ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center col-span-12 md:col-span-1 font-bold text-xs border">
                                <p class="md:hidden w-1/2 h-full uppercase px-2 text-indigo-500 border-r flex items-center">unit</p>
                                <p class="break-words w-1/2 md:w-full py-4 px-2 md:text-center">{{ $prospectus_subject->unit ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center col-span-12 md:col-span-2 font-bold text-xs border">
                                <p class="md:hidden w-1/2 h-full uppercase px-2 text-indigo-500 border-r flex items-center">co-requisite</p>
                                <p class="break-words w-1/2 md:w-full py-4 px-2">
                                    @forelse ($prospectus_subject->corequisites as $requisite)
                                        {{ $loop->first ? '' : ', '  }}
                                        <span>&nbsp;{{ $requisite->code }}</span>
                                    @empty
                                        N/A
                                    @endforelse
                                </p>
                            </div>
                            <div class="flex items-center col-span-12 md:col-span-2 font-bold text-xs border">
                                <p class="md:hidden w-1/2 h-full uppercase px-2 text-indigo-500 border-r flex items-center">pre-requisite</p>
                                <p class="break-words w-1/2 md:w-full py-4 px-2">
                                    @forelse ($prospectus_subject->prerequisites as $requisite)
                                        {{ $loop->first ? '' : ', '  }}
                                        <span>&nbsp;{{ $requisite->code }}</span>
                                    @empty
                                        N/A
                                    @endforelse
                                </p>
                            </div>
                            <div class="flex items-center col-span-12 md:col-span-1 font-bold text-xs border">
                                <p class="md:hidden w-1/2 h-full uppercase px-2 text-indigo-500 border-r flex items-center">remark</p>
                                <p class="break-words w-1/2 md:w-full py-4 px-2 md:text-center">
                                    @if (is_array($grades) && array_key_exists($prospectus_subject->subject->id, $grades))
                                        {!! $grades[$prospectus_subject->subject->id]['mark'] ?? 'N/A' !!}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center col-span-12 md:col-span-1 font-bold text-xs border">
                                <p class="md:hidden w-1/2 h-full uppercase px-2 text-indigo-500 border-r flex items-center">grade</p>
                                <p class="break-words w-1/2 md:w-full py-4 px-2 md:text-center">
                                    @if (is_array($grades) && array_key_exists($prospectus_subject->subject->id, $grades))
                                        {{ $grades[$prospectus_subject->subject->id]['value'] ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <x-table.no-result>No subjects found.🤔</x-table.no-result>
                    @endforelse
                </div>
            </x-slot>
        </x-table.main>
    </div>

    <div>@include('partials.loading')</div>
</div>
