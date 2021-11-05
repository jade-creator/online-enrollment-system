<div class="max-w-7xl mx-auto sm:px-6 px-4 md:px-8">
    @if (isset($registration))
        <div class="pt-10">
            <x-jet-label class="block md:hidden font-extrabold text-xl">{{ $registration->custom_id ?? 'N/A' }}</x-jet-label>

            <div class="mt-2">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex items-start">
                        <img class="border border-gray-200 mt-1 h-28 w-28 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="photo"/>
                        <div class="px-6 py-2 flex flex-col text-2xl w-full">
                            <div class="flex items-center justify-between w-full">
                                <div class="flex flex-col">
                                    <h2 class="font-extrabold">{{ auth()->user()->person->short_full_name }}</h2>
                                    <p class="text-xs mt-1 font-bold text-indigo-500">STUDENT ID: 1800408</p>
                                </div>
                                <div x-data="{ open: false }" class="relative text-center border border-dashed border-indigo-500 rounded-md p-2 hidden md:block">
                                    <p x-on:mouseover="open = true"
                                       x-on:mouseleave="open = false"
                                       class="text-gray-500 text-md font-bold cursor-pointer">
                                        @if (count($incompleteComputed) > 0 && $grade == 0)
                                            N/A <span class="text-blue-500">&#9432</span>
                                        @else
                                            {{ number_format((float)$grade, 2, '.', '') }}
                                        @endif
                                    </p>
                                    @if (count($incompleteComputed) > 0 && $grade == 0)
                                        <p x-show="open"
                                           class="text-xs absolute left-0 -bottom-16 p-2 rounded-md border border-red-500 bg-red-50 text-red-400"
                                           x-cloak>Not yet graded: (computed only)
                                            @foreach ($incompleteComputed as $subject)
                                                {{ $loop->first ? '' : ', '  }}
                                                <span>{{ $subject[0] ?? 'N/A' }}</span>
                                                {{ $loop->last ? '.' : ''  }}
                                            @endforeach
                                        </p>
                                    @endif
                                    <p class="text-xs">Cumulative Weighted Average (CWA)</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2 tracking-widest">{{ $registration->classification }}</p>

                            <p class="text-sm text-gray-600 mt-1 tracking-widest">{{ $registration->prospectus->program->program ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $registration->prospectus->level->level ?? 'N/A' }} - {{ $registration->prospectus->term->term ?? 'N/A' }}</p>

                            <div class="my-6 flex">
                                <a href="{{ route('pre.registration.view', $registration->id) }}">
                                    <p class="hover:text-indigo-500 underline text-sm text-gray-600">View Details</p>
                                </a>
                                <a href="{{ route('stream.grade.pdf', [
                                        'registration' => $registration,
                                        'professors' => http_build_query(array('professors' => $professors)),
                                        'computedGrade' => $grade,
                                        'grades' => http_build_query(array('grades' => $grades)),
                                        'notComputed' => http_build_query(array('notComputed' => $notComputed)),
                                    ]) }}"
                                    target="_blank">
                                    <p class="hover:text-indigo-500 underline text-sm text-gray-600 mx-4 cursor-pointer">Print Grade Report</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <x-jet-section-border/>
        </div>

        <div x-data="{ open: true }">
            <x-table.nested-row>
                <x-slot name="nestedTable">
                    <div class="md:hidden grid grid-cols-12 place-items-center py-4 bg-indigo-500">
                        <x-table.column-title class="col-span-12"><span class="text-white">Grade</span></x-table.column-title>
                    </div>
                    <div class="py-4 hidden md:grid grid-cols-12 gap-2 px-4 bg-indigo-500">
                        <x-table.column-title class="col-span-2"><span class="text-white">code</span></x-table.column-title>
                        <x-table.column-title class="col-span-2"><span class="text-white">title</span></x-table.column-title>
                        <x-table.column-title class="col-span-3"><span class="text-white">professor</span></x-table.column-title>
                        <x-table.column-title class="col-span-2"><span class="text-white">section</span></x-table.column-title>
                        <x-table.column-title class="col-span-2"><span class="text-white">grade</span></x-table.column-title>
                        <x-table.column-title class="col-span-1"><span class="text-white">remark</span></x-table.column-title>
                    </div>

                    <div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
                        @forelse ($registration->grades as $grade)
                            <x-table.cell headerLabel="code" class="md:col-span-2">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Title" class="md:col-span-2">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="Professor" class="md:col-span-3">{{ $professors[$grade->subject_id][0] ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="section" class="md:col-span-2">{{ $registration->section->name ?? 'N/A' }}</x-table.cell>
                            <x-table.cell headerLabel="grade" class="md:col-span-2">{!! $grade->value ?? '<span class="text-gray-400">N/A</span>' !!}</x-table.cell>
                            <x-table.cell headerLabel="Remark" class="md:col-span-1">{!! $grade->mark->name_element ?? 'N/A' !!}</x-table.cell>
                        @empty
                            <x-table.no-result>No added classes yet.🤔</x-table.no-result>
                        @endforelse

                        @if ($registration->extensions->isNotEmpty())
                            @foreach ($registration->extensions as $extension)
                                @foreach ($extension->registration->grades as $grade)
                                    <x-table.cell headerLabel="code" class="md:col-span-2">{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell headerLabel="Title" class="md:col-span-2">{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell headerLabel="Professor" class="md:col-span-3">{{ $professors[$grade->subject_id][0] ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell headerLabel="section" class="md:col-span-2">{{ $extension->registration->section->name ?? 'N/A' }}</x-table.cell>
                                    <x-table.cell headerLabel="grade" class="md:col-span-2">{!! $grade->value ?? '<span class="text-gray-400">N/A</span>' !!}</x-table.cell>
                                    <x-table.cell headerLabel="Remark" class="md:col-span-1">{!! $grade->mark->name_element ?? 'N/A' !!}</x-table.cell>
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                </x-slot>
            </x-table.nested-row>
        </div>

        @if (isset($notComputed) && is_array($notComputed) && count($notComputed) > 0)
            <p class="text-sm py-2"><span class="font-bold text-base">&#9432</span> Not Computed:
                @forelse ($notComputed as $subject)
                    {{ $loop->first ? '' : ', '  }}
                    <span>{{ $subject[0] ?? 'N/A' }}</span>
                    {{ $loop->last ? '.' : ''  }}
                @empty
                    <span class="text-gray-400">N/A</span>
                @endforelse
            </p>
        @endif
    @endisset
</div>
