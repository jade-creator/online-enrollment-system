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
                <x-jet-label class="font-bold text-indigo-500 text-xs" for="subjects" value="{{ __('Subjects') }}" />
                <div class="col-span-6" id="subjects">
                    <div class="mb-4 pb-2 grid grid-cols-8 gap-2 col-span-6 border-b">
                        <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">code</div>
                        <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">title</div>
                        <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-center">description</div>
                        <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-center">unit</div>
                        <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-center">pre requisite</div>
                    </div>

                    @forelse ($prospectus->subjects as $index => $prospectus_subject)
                        <div class="mb-2 py-2 grid grid-cols-8 gap-2 col-span-6">
                            <div class="col-span-2 ">{{ $prospectus_subject->subject->code ?? 'N/A' }}</div>
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
                        <x-table.no-result>No subjects found. Sorry! Unable to register.🤔</x-table.no-result>
                    @endforelse
                </div>
            </x-slot>

            <x-slot name="actions">
                <a href="{{ route('student.registrations.create') }}">
                    <x-jet-secondary-button class="hover:bg-indigo-100" wire:loading.attr="disabled">
                        {{ __('Go Back') }}
                    </x-jet-secondary-button>
                </a>
                @can ('register', $prospectus)
                    <x-jet-button wire:click.prevent="save"  class="ml-2 bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
                        {{ __('Register') }}
                    </x-jet-button>
                @endcan
            </x-slot>
        </x-jet-form-section>
        <x-jet-section-border/>
    </div>
</div>
