<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    @include('partials.view-profile-button')

    <div class="flex flex-col md:flex-row">
        <div class="flex flex-col h-auto mb-3 md:h-0">
            <div class="w-full lg:w-64 md:w-60">
                <div class="">
                    <p class="py-3 pr-5 font-bold text-sm">Terms & Policy</p>
                </div>
                <div class="">
                    <p class="py-3 pr-5 font-bold text-sm">Requirements</p>
                </div>
                <div class="">
                    <p class="py-3 pr-5 font-bold text-sm">Fees</p>
                </div>
                <div class="">
                    <p class="py-3 pr-5 font-bold text-sm">FAQS</p>
                </div>

            </div>
        </div>

        <div class="w-full pl-0 md:pl-8">
            <div>
                <x-jet-form-section submit="">
                    <x-slot name="title">
                        {{ __('Program Setup') }}
                    </x-slot>
                
                    <x-slot name="description">
                        {{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, illum id? Ut officiis ea, quae vel rerum sed quaerat reiciendis sapiente cupiditate repellat explicabo accusamus!') }}
                    </x-slot>
                
                    <x-slot name="form">
                        @if ($currentStep == 1)
                            <!-- fName -->
                            <div class="col-span-6">
                                <x-jet-label for="student_type" value="{{ __('Student Type') }}" />
                                <select wire:model="registration.isNew" wire:loading.attr="disabled" id="student_type" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                    <option value="" selected>-- choose student type --</option>
                                    <option value="1">New</option>
                                    <option value="0">Old</option>
                                </select> 
                                <x-jet-input-error for="registration.isNew" class="mt-2"/>
                            </div>
                    
                            <div class="col-span-6">
                                <x-jet-label for="level" value="{{ __('Level') }}"/>
                                <select wire:model="levelId" wire:loading.attr="disabled" id="level" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                    @forelse ($this->levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                                    @empty
                                        <option value="">No records</option>
                                    @endforelse
                                </select>
                                <x-jet-input-error for="levelId" class="mt-2"/>
                            </div>
                    
                            @if ($levelId > 13)
                                <div class="col-span-6">
                                    <x-jet-label for="program" value="{{ __('Program') }}" />
                                    <select wire:model="programId" wire:loading.attr="disabled" id="program" aria-label="programs" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                        @forelse ($this->programs as $program)
                                            @if ($loop->first)
                                                <option value="" selected>-- choose a program --</option>
                                            @endif
                                            <option value="{{ $program->id }}">{{ $program->code }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="programId" class="mt-2"/>
                                </div>
                            @endif
                    
                            @if ($levelId > 11 && $levelId < 14) <!-- show if level is shs -->
                                <div class="col-span-6">
                                    <x-jet-label for="strand" value="{{ __('Strand') }}" />
                                    <select wire:model="strandId" wire:loading.attr="disabled" id="strand" aria-label="strands" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                        @forelse ($this->strands as $strand)
                                            @if ($loop->first)
                                                <option value="" selected>-- choose a strand --</option>
                                            @endif
                                            <option value="{{ $strand->id }}">{{ $strand->code }}</option>
                                        @empty
                                            <option value="">No records</option>
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="strandId" class="mt-2"/>
                                </div>
                            @endif

                            @if ($levelId > 11) <!-- show if level is shs to college -->
                                <div class="col-span-6">
                                    <x-jet-label for="term" value="{{ __('Term') }}" />
                                    <select wire:model="termId" wire:loading.attr="disabled" id="term" aria-label="terms" class="relative w-full bg-white mt-3 pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                                        <option value="" selected>-- choose a term --</option>
                                        <option value="1">1st term</option>
                                        <option value="2">2nd term</option>
                                    </select>
                                    <x-jet-input-error for="termId" class="mt-2"/>
                                </div>
                            @endif
                        @endif

                        @if ($currentStep == 2)
                            <x-jet-label class="font-bold text-indigo-500 text-xs" for="subjects" value="{{ __('Subjects') }}" />
                            <div class="col-span-6" id="subjects">
                                <div class="mb-4 grid grid-cols-6 gap-2 col-span-6">
                                    <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left flex">
                                        <input wire:model="selectAll" wire:loading.attr="disabled" type="checkbox" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent rounded-sm" title="Select Displayed Subject/s">
                                        <div class="ml-3">code</div>
                                    </div>
                                    <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">title</div>
                                    <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-center">unit</div>
                                    <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-center">pre requisite</div>
                                </div>

                                @foreach ($prospectus->subjects as $index => $subject)
                                    <div class="mb-2 py-2 grid grid-cols-6 gap-2 col-span-6 border-b-2 border-gray-200">
                                        <div class="col-span-1">
                                            <div class="flex items-center">
                                                <input wire:key="{{ $loop->index }}" wire:model="selected.{{ $index }}" wire:loading.attr="disabled" type="checkbox" id="{{ $subject->id }}" name="selected[{{ $index }}]" value="{{ $subject->id }}" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent rounded-sm">
                                                <div class="ml-3">
                                                    {{ $subject->code ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-2"><p class="truncate">{{ $subject->title ?? 'N/A' }}</p></div>
                                        <div class="col-span-1 text-center">{{ $subject->unit ?? 'N/A' }}</div>
                                        <div class="col-span-2 text-center">
                                            @forelse ($subject->requisites as $requisite)
                                                {{ $loop->first ? '' : ', '  }}
                                                <span>&nbsp;{{ $requisite->code }}</span>
                                            @empty

                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </x-slot>
                
                    <x-slot name="actions">
                        @if ($currentStep == 1)
                            <x-jet-button wire:click.prevent="next"  class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
                                {{ __('Proceed') }}
                            </x-jet-button>
                        @endif

                        @if ($currentStep == 2)
                            <x-jet-secondary-button wire:click.prevent="previous"  class="hover:bg-indigo-100" wire:loading.attr="disabled">
                                {{ __('Go Back') }}
                            </x-jet-secondary-button>
                            <x-jet-button wire:click.prevent="save"  class="ml-2 bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled">
                                {{ __('Submit') }}
                            </x-jet-button>
                        @endif
                    </x-slot>
                </x-jet-form-section>

                <x-jet-section-border/>
            </div>
        </div>
    </div>
</div>
