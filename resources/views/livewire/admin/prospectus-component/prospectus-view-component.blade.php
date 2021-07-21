<div class="w-full flex flex-1 scrolling-touch">
    <div class="flex-grow bg-white shadow-md px-5 pt-8 text-gray-500">
        <h3 class="font-bold text-lg">{{ __('Filters')}}</h3>
        <div class="my-4">
            <h3 class="font-bold text-md">{{ __('Level')}}</h3>
            <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                <select wire:model="levelId" wire:loading.attr="disabled" id="level" aria-label="levels" class="w-52 bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                    @forelse ($this->levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                    @empty
                        <option value="">No records</option>
                    @endforelse
                </select>
            </div>
        </div>

        @if ($levelId >= 14) <!-- show if level is college -->
            <div class="my-4">
                <h3 class="font-bold text-md">{{ __('Program')}}</h3>
                <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                    <select wire:model="programId" wire:loading.attr="disabled" id="program" aria-label="programs" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                        @forelse ($this->programs as $program)
                            <option value="{{ $program->id }}">{{ $program->code }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                </div>
            </div>
        @endif

        @if ($levelId == 12 || $levelId == 13) <!-- show if level is shs -->
            <div class="my-4">
                <h3 class="font-bold text-md">{{ __('Strand')}}</h3>
                <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                    <select wire:model="strandId" wire:loading.attr="disabled" id="strand" aria-label="strands" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                        @forelse ($this->strands as $strand)
                            <option value="{{ $strand->id }}">{{ $strand->code }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                </div>
            </div>
        @endif
            
        @if ($levelId >= 12) <!-- show if level is shs to college -->
            <div class="my-4">
                <h3 class="font-bold text-md">{{ __('Term')}}</h3>
                <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                    <select wire:model="termId" wire:loading.attr="disabled" id="term" aria-label="terms" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                        <option value="1">1st term</option>
                        <option value="2">2nd term</option>
                    </select>
                </div>
            </div>
        @endif
    </div>

    <div class="min-h-screen w-full py-8 px-8">
        <div class="mb-4 pb-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-gray-500">Prospectus</div>
                </div>
                @can('create', App\Models\Prospectus::class)
                    <button wire:click="$toggle('addingSubjects')" wire:loading.attr="disabled" class="focus:ring-2 focus:bg-blue-500 focus:ring-opacity-50 bg-blue-500 hover:bg-blue-600 text-white py-2.5 px-4 font-bold text-xs rounded-lg border border-white">Add Subjects</button>
                @endcan
            </div>
        </div>

        <x-table.main>
            <x-slot name="paginationLink">
            </x-slot>

            <x-slot name="head">
                <x-table.column-title columnTitle="code" class="col-span-3 pl-4"/>
                <x-table.column-title columnTitle="title" class="col-span-4"/>
                <x-table.column-title columnTitle="Unit" class="col-span-2"/>
                <x-table.column-title columnTitle="Pre Requisite" class="col-span-2"/>
                <x-table.column-title columnTitle="Actions" class="col-span-1"/>
            </x-slot>

            <x-slot name="body">
                @forelse ($prospectus->subjects as $subject)
                    <div class="w-full p-2 my-1 rounded-md shadow hover:shadow-md bg-white border-t border-l border-r border-gray-200 border-opacity-80">
                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-12 md:col-span-3 truncate font-bold text-xs">
                                <div class="flex items-center">
                                    <div class="h-10 flex items-center pl-4">
                                        {{ $subject->code ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-4 truncate md:border-0 border-t border-gray-300 font-bold text-xs"><p class="truncate">{{ $subject->title ?? 'N/A' }}</p></div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $subject->unit ?? 'N/A' }}</div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">
                                @forelse ($subject->requisites as $requisite)
                                    {{ $loop->first ? '' : ', '  }}
                                    <a href="{{ route('admin.subjects.view', ['search' => $requisite->title]) }}" class="text-indigo-500 underline"><span>{{ $requisite->code }}</span></a>
                                @empty
                                    N/A
                                @endforelse
                            </div>
                            <div class="flex items-center justify-center col-span-12 md:col-span-1 md:border-0 border-t border-gray-300">
                                <x-jet-dropdown align="right" width="60" dropdownClasses="z-10 shadow-2xl">
                                    <x-slot name="trigger">
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-2 py-2 border border-transparent rounded-full text-gray-500 bg-white hover:bg-gray-50 focus:outline-none focus:bg-gray-100 active:bg-gray-100 transition ease-in-out duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <circle cx="5" cy="12" r="1"></circle>
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="19" cy="12" r="1"></circle>
                                                </svg>
                                            </button>
                                        </span>
                                    </x-slot>
        
                                    <x-slot name="content">
                                        <div class="w-60">
                                            <div class="block px-4 py-3 text-sm text-gray-500 font-bold">
                                                {{ __('Actions') }}
                                            </div>
                                            @if (auth()->user()->role->name == 'admin')
                                                <div>
                                                    <a href="{{ route('admin.subjects.view', ['search' => $subject->title]) }}">
                                                        <button class="flex w-full px-4 py-2 hover:bg-gray-200 outline-none focus:outline-none transition-all duration-300 ease-in-out">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <circle cx="12" cy="12" r="2"></circle>
                                                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
                                                                </svg>
                                                            <p class="pl-2">{{ __('View')}}</p>
                                                        </button> 
                                                    </a>
                                                </div>
                                                <div>
                                                    <button wire:click.prevent="removeConfirm({{ $subject }})" class="flex w-full px-4 py-2 hover:bg-red-500 hover:text-white rounded-b-md outline-none focus:outline-none transition-all duration-300 ease-in-out">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <line x1="4" y1="7" x2="20" y2="7"></line>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                        <p class="pl-2">{{ __('Delete')}}</p>
                                                    </button>
                                                </div>
                                            @else
                                                <div>
                                                    <button class="flex w-full px-4 py-2 bg-gray-200 outline-none focus:outline-none transition-all duration-300 ease-in-out">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                                            <circle cx="12" cy="16" r="1"></circle>
                                                            <path d="M8 11v-4a4 4 0 0 1 8 0v4"></path>
                                                        </svg>
                                                        <p class="pl-2">{{ __('Administrative Access')}}</p>
                                                    </button>                                                        
                                                </div>
                                            @endif
                                        </div>
                                    </x-slot>
                                </x-jet-dropdown>
                            </div>
                        </div>
                    </div>
                @empty  
                    <x-table.no-result title="No subject found.🤔"/> 
                @endforelse
            </x-slot>
        </x-table.main>
    </div>

    <div wire:loading wire:target="levelId, ProgramId, TrackId, TermId">
        @include('partials.loading')
    </div>

    <!-- Export User/s Confirmation Modal -->
    <x-jet-dialog-modal wire:model="addingSubjects">
        <x-slot name="title">
            {{ __('Subject Maintenance') }}
        </x-slot>

        <x-slot name="content">
            <div class="">
                @foreach ($this->subjects as $subject)
                    <div class="flex items-center my-2">
                        <input wire:key="{{ $loop->index }}" wire:model="selectedSubjects" wire:loading.attr="disabled" value="{{ $subject->id }}" type="checkbox" name="selectedSubjects" id="selectedSubjects" class="mx-2">
                        <p>{{ $subject->title }}</p>
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('addingSubjects')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="addSubject" wire:loading.attr="disabled">
                {{ __('Add') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>