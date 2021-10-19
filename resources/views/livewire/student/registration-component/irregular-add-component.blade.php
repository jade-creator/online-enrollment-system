<div class="max-w-5xl mx-auto p-4 md:p-8">
    @include('partials.view-profile-button')

    <div class="w-full pl-0 md:pl-8">
        <x-jet-form-section submit="">
            <x-slot name="title">
                {{ __('Pre Registration') }}
            </x-slot>

            <x-slot name="description">
                {{ 'Hi Student! Welcome to the Pre-Registration Page. Please fill out these form accordingly.' }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6" id="program-subjects">
            
                    {{-- LOOP WHOLE TABLE --}}
                    @forelse ($selected as $index_S => $subjects)
                        <div class="mb-5">
                            {{-- LOOP TABLE TITLE --}}
                            <div class="space-y-2">
                                <x-jet-label class="font-bold text-indigo-500 text-xs" for="subjects" value="{{ $prospectus->program->code . ' Subjects for:' }}"/>
                                @foreach ($prospectuses as $index_P => $prospectus)
                                    @if ($index_S == $index_P)<h1>{{ $prospectus->level->level ?? 'N/A' }} - <span>{{ $prospectus->term->term ?? 'N/A' }}</span></h1>@endif
                                @endforeach
                            </div>

                            <x-table.main>
                                <x-slot name="filter"></x-slot>
                                <x-slot name="paginationLink"></x-slot>

                                <x-slot name="head">
                                    <x-table.column-title class="col-span-2">
                                        <input wire:model="selectAll.{{ $index_S }}" wire:loading.attr="disabled" type="checkbox" title="Select Displayed Subject/s">
                                        <div class="ml-3">code</div>
                                    </x-table.column-title>
                                    <x-table.column-title class="col-span-3">title</x-table.column-title>
                                    <x-table.column-title class="col-span-1">unit</x-table.column-title>
                                    <x-table.column-title class="col-span-3">co requisite</x-table.column-title>
                                    <x-table.column-title class="col-span-3">pre requisite</x-table.column-title>
                                </x-slot>

                                <x-slot name="body">
                                    @foreach ($prospectuses as $index_P => $prospectus_p)
                                        @if ($index_S == $index_P)
                                            @foreach ($prospectus_p->subjects as $index_s => $prospectus_subject)
                                                <div wire:key="table-row-{{$prospectus_subject->subject->code}}">
                                                    <x-table.row>
                                                        <div name="slot" class="grid grid-cols-12 md:gap-2">
                                                            <x-table.cell headerLabel="Code" class="justify-start md:col-span-2">
                                                                <div class="flex items-center">
                                                                    @if (in_array($prospectus_subject->subject_id, $origSelectedSubjects[$index_P]))
                                                                        <input wire:key="{{ $prospectus_subject->id.'-'.$loop->index }}" wire:model="selected.{{ $index_S }}.{{ $index_s }}" wire:loading.attr="disabled" type="checkbox" id="selected[{{ $index_S }}][{{ $index_s }}]" name="selected[{{ $index_S }}][{{ $index_s }}]" value="{{ $prospectus_subject->id }}">
                                                                    @else
                                                                        @if (array_key_exists($prospectus_subject->subject_id, $this->grades)
                                                                            && $this->grades[$prospectus_subject->subject_id]['is_passed'] == TRUE)
                                                                            <span class="text-green-500"><x-icons.check-icon/></span>
                                                                        @else
                                                                            <span class="text-red-500"><x-icons.reject-icon/></span>
                                                                        @endif
                                                                    @endif
                                                                    <div class="ml-3">{{ $prospectus_subject->subject->code ?? 'N/A' }}</div>
                                                                </div>
                                                            </x-table.cell>
                                                            <x-table.cell headerLabel="title" class="justify-start md:col-span-3">{{ $prospectus_subject->subject->title ?? 'N/A' }}</x-table.cell>
                                                            <x-table.cell headerLabel="unit" class="justify-start md:col-span-1">{{ $prospectus_subject->unit ?? 'N/A' }}</x-table.cell>
                                                            <x-table.cell headerLabel="co requisite" class="justify-start md:col-span-3">
                                                                @forelse ($prospectus_subject->corequisites as $requisite)
                                                                    {{ $loop->first ? '' : ', '  }}
                                                                    <span>&nbsp;{{ $requisite->code }}</span>
                                                                @empty
                                                                    N/A
                                                                @endforelse
                                                            </x-table.cell>
                                                            <x-table.cell headerLabel="pre requisite" class="justify-start md:col-span-3">
                                                                @forelse ($prospectus_subject->prerequisites as $requisite)
                                                                    {{ $loop->first ? '' : ', '  }}
                                                                    <span>&nbsp;{{ $requisite->code }}</span>
                                                                @empty
                                                                    N/A
                                                                @endforelse
                                                            </x-table.cell>
                                                        </div>
                                                    </x-table.row>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </x-slot>
                            </x-table.main>
                        </div>
                    @empty
                        <x-table.no-result>No subjects found.🤔</x-table.no-result>
                    @endforelse
                </div>
            </x-slot>

            <x-slot name="actions">
                <a href="{{ route('student.registrations.create') }}">
                    <x-jet-secondary-button class="hover:bg-indigo-100">
                        {{ __('Go Back') }}
                    </x-jet-secondary-button>
                </a>

                @if (empty($selected[0]))
                    <x-jet-button class="ml-2 bg-indigo-700 hover:bg-indigo-800 cursor-not-allowed" disabled="disabled">
                        {{ __('Register') }}
                    </x-jet-button>
                @else
                    @can ('register', $prospectus)
                        <x-jet-button wire:click.prevent="save" class="ml-2 bg-indigo-700 hover:bg-indigo-800">
                            {{ __('Register') }}
                        </x-jet-button>
                    @endcan
                @endif
            </x-slot>
        </x-jet-form-section>
        <x-jet-section-border/>
    </div>
</div>
