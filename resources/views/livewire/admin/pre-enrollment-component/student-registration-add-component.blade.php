<div class="max-w-5xl mx-auto p-4 md:p-8 ">
    <div class="pt-10 pb-5 flex items-center justify-between">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="flex items-start">
                <img class="border border-gray-200 mt-1 h-16 w-16 rounded-full object-cover" src="{{ $student->user->profile_photo_url }}" alt="photo"/>
                <div class="px-6 py-2 flex flex-col text-2xl">
                    <h2>{{ $student->user->person->full_name ?? 'N/A' }}</h2>
                    <a href="{{ route('users.students.index', ['search' => $student->custom_id]) }}">
                        <p class="text-indigo-500 font-bold text-sm hover:underline">Student ID: {{ $student->custom_id ?? 'N/A' }}</p>
                    </a>
                </div>
            </div>
        @endif

        <a href="{{ route('user.personal.profile.view', ['userId' => $student->user->id]) }}">
            <x-jet-secondary-button class="">
                {{ __('View profile')}}
            </x-jet-secondary-button>
        </a>
    </div>
    <x-jet-section-border/>

    @if (session()->has('alert'))
        <div class="mb-4">
            <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
        </div>
    @endif

    <div class="flex flex-col md:flex-row">
        <div class="flex flex-col h-auto mb-3 md:h-0">
            <div class="w-full lg:w-64 md:w-60">
                <div class="flex items-start justify-between pb-4">
                    <p class="font-bold text-sm">Terms & Policy</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5"></path>
                        <line x1="10" y1="14" x2="20" y2="4"></line>
                        <polyline points="15 4 20 4 20 9"></polyline>
                    </svg>
                </div>
                <div class="flex items-start justify-between mt-4 pb-4">
                    <p class="font-bold text-sm">Requirements</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5"></path>
                        <line x1="10" y1="14" x2="20" y2="4"></line>
                        <polyline points="15 4 20 4 20 9"></polyline>
                    </svg>
                </div>
                <div class="flex items-start justify-between mt-4 pb-4">
                    <p class="font-bold text-sm">Fees</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5"></path>
                        <line x1="10" y1="14" x2="20" y2="4"></line>
                        <polyline points="15 4 20 4 20 9"></polyline>
                    </svg>
                </div>
                <div class="flex items-start justify-between mt-4 pb-4">
                    <p class="font-bold text-sm">FAQS</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="18" height="18" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M11 7h-5a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-5"></path>
                        <line x1="10" y1="14" x2="20" y2="4"></line>
                        <polyline points="15 4 20 4 20 9"></polyline>
                    </svg>
                </div>
            </div>
        </div>

        <div class="w-full pl-0 md:pl-8">
            <div>
                <x-jet-form-section submit="">
                    <x-slot name="title">
                        <span>Pre Registration @if (filled($registration)) - {{ $registration->custom_id }} @endif</span>
                    </x-slot>

                    <x-slot name="description">
                        {{ 'Hi Student! Welcome to the Pre-Registration Page. Please fill out these form accordingly.' }}
                    </x-slot>

                    <x-slot name="form">
                        <div class="col-span-6">
                            <x-jet-label for="classification" value="{{ __('Classification') }}" />
                            <select wire:model.defer="classification" wire:loading.attr="disabled" id="classification" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                <option value="">Select a classification</option>
                                <option value="regular">Regular</option>
                                <option value="irregular">Irregular</option>
                            </select>
                            <x-jet-input-error for="classification" class="mt-2"/>
                        </div>

                        <div class="col-span-6">
                            <x-jet-label for="student_type" value="{{ __('Student Type') }}" />
                            <select wire:model.defer="type" wire:loading.attr="disabled" id="student_type" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                <option value="">Select student type</option>
                                <option value="new">New</option>
                                <option value="old">Old</option>
                            </select>
                            <x-jet-input-error for="type" class="mt-2"/>
                        </div>

                        <div class="col-span-6">
                            <x-jet-label for="program" value="{{ __('Program') }}" />
                            <select wire:model.defer="programId" wire:loading.attr="disabled" id="program" aria-label="programs" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                @isset($student->program)
                                    <option value="{{ $programId }}">{{ $programName ?? 'N/A' }}</option>
                                @else
                                    <option value="">Select a program</option>
                                @endisset
                            </select>
                            <x-jet-input-error for="programId" class="mt-2"/>
                        </div>

                        <div class="col-span-6">
                            <x-jet-label for="level" value="{{ __('Level') }}"/>
                            <select wire:model.defer="levelId" wire:loading.attr="disabled" id="level" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                @forelse ($levels as $level)
                                    @if ($loop->first) <option value="">Select a level</option> @endif

                                    <option value="{{ $level->level->id ?? '' }}">{{ $level->level->level ?? 'N/A' }}</option>
                                @empty
                                    <option value="">No records</option>
                                @endforelse
                            </select>
                            <x-jet-input-error for="levelId" class="mt-2"/>
                        </div>

                        <div class="col-span-6">
                            <x-jet-label for="term" value="{{ __('Semester') }}" />
                            <select wire:model.defer="termId" wire:loading.attr="disabled" id="term" aria-label="terms" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                <option value="" selected>Select a semester</option>
                                <option value="1">1st sem</option>
                                <option value="2">2nd sem</option>
                            </select>
                            <x-jet-input-error for="termId" class="mt-2"/>
                        </div>
                    </x-slot>

                    <x-slot name="actions">
                        <x-jet-action-message class="mr-3 text-blue-500 font-bold w-full" on="saved">
                            {{ __('Redirecting...') }}
                        </x-jet-action-message>

                        <x-jet-action-message class="mr-3 text-red-500 font-bold w-full" on="error">
                            {{ __('Failed! Please read the error above.') }}
                        </x-jet-action-message>

                        <x-jet-button wire:click.prevent="next" class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
                            {{ __('Next') }}
                        </x-jet-button>
                    </x-slot>
                </x-jet-form-section>
                <x-jet-section-border/>
            </div>
        </div>
    </div>
</div>
