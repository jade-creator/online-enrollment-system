<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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
                    <x-jet-label class="font-bold text-indigo-500 text-xs" for="subjects" value="{{ $prospectus->program->code . ' Subjects for:' }}"/>
                    @forelse ($selected as $index_S => $subjects)
                        @forelse ($prospectuses as $index_P => $prospectus)
                            @if ($index_S == $index_P)
                                <h1>{{ $prospectus->level->level ?? 'N/A' }}<span>{{ $prospectus->term->term ?? 'N/A' }}</span></h1>
                            @endif
                        @empty
                        @endforelse

                        <div class="mb-4 grid grid-cols-8 gap-2 col-span-6">
                            <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-left flex">
                                <input wire:model="selectAll.{{ $index_S }}" wire:loading.attr="disabled" type="checkbox" title="Select Displayed Subject/s">
                                <div class="ml-3">code</div>
                            </div>
                            <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">title</div>
                            <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-center">description</div>
                            <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-center">unit</div>
                            <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-center">pre requisite</div>
                        </div>

                        @forelse ($prospectuses as $index_P => $prospectus_p)
                            @if ($index_S == $index_P)
                                @forelse ($prospectus_p->subjects as $index_s => $prospectus_subject)
                                    <div class="mb-2 py-2 grid grid-cols-8 gap-2 col-span-6 border-b-2 border-gray-200">
                                        <div class="col-span-2">
                                            <div class="flex items-center">
                                                <input wire:key="{{ $loop->index }}" wire:model="selected.{{ $index_S }}.{{ $index_s }}" wire:loading.attr="disabled" type="checkbox" id="selected[{{ $index_S }}][{{ $index_s }}]" name="selected[{{ $index_S }}][{{ $index_s }}]" value="{{ $prospectus_subject->id }}">
                                                <div class="ml-3">
                                                    {{ $prospectus_subject->subject->code ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1"><p class="truncate">{{ $prospectus_subject->subject->title ?? 'N/A' }}</p></div>
                                        <div class="col-span-2 text-center">{{ $prospectus_subject->subject->description ?? 'N/A' }}</div>
                                        <div class="col-span-1 text-center">{{ $prospectus_subject->unit ?? 'N/A' }}</div>
                                        <div class="col-span-2 text-center">
                                            @forelse ($prospectus_subject->prerequisites as $requisite)
                                                {{ $loop->first ? '' : ', '  }}
                                                <span>&nbsp;{{ $requisite->code }}</span>
                                            @empty
                                                N/A
                                            @endforelse
                                        </div>
                                    </div>
                                @empty
{{--                                    subjects--}}
                                @endforelse
                            @endif
                        @empty
{{--                            prospectus--}}
                        @endforelse
                    @empty
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
