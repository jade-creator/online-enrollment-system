<div class="w-full flex flex-1 scrolling-touch">
    <x-table.filter>
        <div name='slot'>

            <div class="my-4">
                <h3 class="font-bold text-md">{{ __('Level')}}</h3>
                <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                    <select wire:model="levelId" wire:loading.attr="disabled" id="level" aria-label="levels" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                        @forelse ($this->levels as $level)
                            @if ($loop->first)
                                <option value="" selected>All (levels)</option>
                            @endif
                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                </div>
            </div>

            @if ($levelId > 13) <!-- show if level is college -->
                <div class="my-4">
                    <h3 class="font-bold text-md">{{ __('Program')}}</h3>
                    <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                        <select wire:model="programId" wire:loading.attr="disabled" id="program" aria-label="programs" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                            @forelse ($this->programs as $program)
                                @if ($loop->first)
                                    <option value="" selected>All (programs)</option>
                                @endif
                                <option value="{{ $program->id }}">{{ $program->code }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            @endif

            @if ($levelId > 10 && $levelId < 14) <!-- show if level is shs -->
                <div class="my-4">
                    <h3 class="font-bold text-md">{{ __('Strand')}}</h3>
                    <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                        <select wire:model="strandId" wire:loading.attr="disabled" id="strand" aria-label="strands" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                            @forelse ($this->strands as $strand)
                                @if ($loop->first)
                                    <option value="" selected>All (strands)</option>
                                @endif
                                <option value="{{ $strand->id }}">{{ $strand->code }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            @endif
                
            @if ($levelId > 10) <!-- show if level is shs to college -->
                <div class="my-4">
                    <h3 class="font-bold text-md">{{ __('Term')}}</h3>
                    <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                        <select wire:model="termId" wire:loading.attr="disabled" id="term" aria-label="terms" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                            <option value="" selected>All (Terms)</option>
                            <option value="1">1st term</option>
                            <option value="2">2nd term</option>
                        </select>
                    </div>
                </div>
            @endif
        </div>
    </x-table.filter>

    <div class="min-h-screen w-full py-8 px-8">
        <div class="mb-4 pb-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-gray-500">Sections</div>
        
                    @if ( count($this->selected) > 0 && !$this->selectAll )
                        <div class="px-2 text-green-600 font-bold">{{ __('[')}}
                            <span>{{ count($this->selected) }}</span>
                            <span>{{ __('selected ]')}}</span>
                        </div>
                    @endif
        
                    @if ( $this->selectAll )
                        <div class="px-2 text-green-600 font-bold">{{ __('[')}}
                            <span>{{ __('selected all ')}}</span>
                            <span>{{ count($this->selected) }}</span>
                            <span>{{ __(' records ]')}}</span>
                        </div>
                    @endif
                </div>
                @can('create', App\Models\Section::class)
                    <button wire:click.prevent="addingSection" wire:loading.attr="disabled" class="focus:ring-2 focus:bg-blue-500 focus:ring-opacity-50 bg-blue-500 hover:bg-blue-600 text-white py-2.5 px-4 font-bold text-xs rounded-lg border border-white">Add Section</button>
                @endcan
            </div>
        </div>

        <x-table.main>
            <x-slot name="paginationLink">
            </x-slot>

            <x-slot name="head">
                <div class="col-span-3 flex" id="ID">
                    <input type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button nameButton="ID" event="sortFieldSelected('ID')"/>
                </div>
                <div class="col-span-3" id="name">
                    <x-table.sort-button nameButton="name" event="sortFieldSelected('name')"/>
                </div>
                <x-table.column-title columnTitle="remarks" class="col-span-3"/>
                <x-table.column-title columnTitle="room" class="col-span-2"/>
                <div class="col-span-1">
                    <x-table.sort-button nameButton="latest" event="sortFieldSelected('created_at')"/>
                </div>
            </x-slot>

            <x-slot name="body">
                    @forelse ($sections as $section)
                        <div id="{{ $section->id }}" x-data="{ open: false }">
                            <div @click="open = ! open" class="w-full p-2 my-1 rounded-md shadow hover:shadow-md @if ($this->isSelected($section->id)) bg-gray-200 @else bg-white @endif border-t border-l border-r border-gray-200 border-opacity-80 cursor-pointer">
                                <div class="grid grid-cols-12 gap-2">
                                    <div class="col-span-12 md:col-span-3 truncate font-bold text-xs">
                                        <div class="flex items-center">
                                            <input wire:loading.attr="disabled" type="checkbox" value="{{ $section->id }}" wire:model="selected" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
                                            <div class="h-10 flex items-center">
                                                {{ $section->id ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-start col-span-12 md:col-span-3 truncate md:border-0 border-t border-gray-300 font-bold text-xs"><p class="truncate">{{ $section->name ?? 'N/A' }}</p></div>
                                    <div class="flex items-center justify-start col-span-12 md:col-span-3 truncate md:border-0 border-t border-gray-300 font-bold text-xs"><p class="truncate">{{ $section->remarks ?? 'N/A' }}</p></div>
                                    <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs"><p class="truncate">{{ $section->room->name ?? 'N/A' }}</p></div>
                                    <div class="flex items-center justify-center col-span-12 md:col-span-1 md:border-0 border-t border-gray-300">
                                        @if ( !count($selected) > 0)
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
                                                        <div>
                                                            <a href="#">
                                                                <button class="flex w-full px-4 py-2 hover:bg-gray-200 outline-none focus:outline-none transition-all duration-300 ease-in-out" type="button">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                                        <polyline points="7 11 12 16 17 11"></polyline>
                                                                        <line x1="12" y1="4" x2="12" y2="16"></line>
                                                                    </svg>
                                                                    <p class="pl-2">{{ __('View')}}</p>
                                                                </button>
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <a href="#">
                                                                <button class="flex w-full px-4 py-2 hover:bg-gray-200 rounded-b-md outline-none focus:outline-none transition-all duration-300 ease-in-out" type="button">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                                        <polyline points="7 11 12 16 17 11"></polyline>
                                                                        <line x1="12" y1="4" x2="12" y2="16"></line>
                                                                    </svg>
                                                                    <p class="pl-2">{{ __('Delete')}}</p>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </x-slot>
                                            </x-jet-dropdown>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div x-show="open" 
                                 class="w-full py-2 px-4 my-1 rounded shadow hover:shadow-md bg-white border-t border-l border-r border-gray-200 border-opacity-80"
                                 x-cloak>

                                <div class="py-4 grid grid-cols-12 gap-2">
                                    <x-table.column-title columnTitle="subject" class="col-span-1 text-blue-500"/>
                                    <x-table.column-title columnTitle="monday" class="col-span-2"/>
                                    <x-table.column-title columnTitle="tuesday" class="col-span-2"/>
                                    <x-table.column-title columnTitle="wednesday" class="col-span-2"/>
                                    <x-table.column-title columnTitle="thursday" class="col-span-2"/>
                                    <x-table.column-title columnTitle="friday" class="col-span-2"/>
                                    <x-table.column-title columnTitle="action" class="col-span-1"/>
                                </div>
                                <div class="grid grid-cols-12 gap-2">
                                    @forelse ($section->schedules as $schedule)
                                        <div class="pb-3 col-span-12 md:col-span-1 font-bold text-xs">
                                            <p class="truncate">{{ $schedule->subject->code ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-span-12 md:col-span-2 font-bold text-xs">
                                            <p class="truncate">
                                                <span>{{ $schedule->start_time_monday ? \Carbon\Carbon::parse($schedule->start_time_monday)->format('g:ia') : '' }}</span> - <span>{{ $schedule->end_time_monday ? \Carbon\Carbon::parse($schedule->end_time_monday)->format('g:ia'): '' }}</span>
                                            </p>
                                        </div>
                                        <div class="col-span-12 md:col-span-2 font-bold text-xs">
                                            <p class="truncate">
                                                <span>{{ $schedule->start_time_tuesday ? \Carbon\Carbon::parse($schedule->start_time_tuesday)->format('g:ia'): '' }}</span> - <span>{{ $schedule->end_time_tuesday ? \Carbon\Carbon::parse($schedule->end_time_tuesday)->format('g:ia') : '' }}</span>
                                            </p>
                                        </div>
                                        <div class="col-span-12 md:col-span-2 font-bold text-xs">
                                            <p class="truncate">
                                                <span>{{ $schedule->start_time_wednesday ? \Carbon\Carbon::parse($schedule->start_time_wednesday)->format('g:ia') : '' }}</span> - <span>{{ $schedule->end_time_wednesday ? \Carbon\Carbon::parse($schedule->end_time_wednesday)->format('g:ia') : '' }}</span>
                                            </p>
                                        </div>
                                        <div class="col-span-12 md:col-span-2 font-bold text-xs">
                                            <p class="truncate">
                                                <span>{{ $schedule->start_time_thursday ? \Carbon\Carbon::parse($schedule->start_time_thursday)->format('g:ia') : '' }}</span> - <span>{{ $schedule->end_time_thursday ? \Carbon\Carbon::parse($schedule->end_time_thursday)->format('g:ia') : '' }}</span>
                                            </p>
                                        </div>
                                        <div class="col-span-12 md:col-span-2 font-bold text-xs">
                                            <p class="truncate">
                                                <span>{{ $schedule->start_time_friday ? \Carbon\Carbon::parse($schedule->start_time_friday)->format('g:ia') : '' }}</span> - <span>{{ $schedule->end_time_friday ? \Carbon\Carbon::parse($schedule->end_time_friday)->format('g:ia') : '' }}</span>
                                            </p>
                                        </div>
                                        <div class="col-span-12 md:col-span-1 font-bold text-xs">
                                            <button wire:click="updatedAddingSchedule({{ $schedule->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M3.5 5.5l1.5 1.5l2.5 -2.5"></path>
                                                    <path d="M3.5 11.5l1.5 1.5l2.5 -2.5"></path>
                                                    <path d="M3.5 17.5l1.5 1.5l2.5 -2.5"></path>
                                                    <line x1="11" y1="6" x2="20" y2="6"></line>
                                                    <line x1="11" y1="12" x2="20" y2="12"></line>
                                                    <line x1="11" y1="18" x2="20" y2="18"></line>
                                                </svg>
                                            </button>
                                        </div>
                                    @empty
                                        <div class="py-4 col-span-12 md:col-span-12 font-bold text-xs">
                                            <p class="truncate text-center">No added subject under the prospectus.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @empty  
                        <x-table.no-result title="No sectionsdad found.🤔"/> 
                    @endforelse
            </x-slot>
        </x-table.main>

        <!-- Bulk action bar -->
        @if ( count($selected) > 0)
            <div class="fixed right-0 bottom-0 pb-3 w-full bg-white bg-opacity-40 border-t border-gray-200" style="backdrop-filter: blur(20px);">
                <div class="flex items-center justify-end min-full">
                    <div class="flex pr-5">
                        <x-table.bulk-action-button nameButton="Cancel" event="$emit('DeselectPage', false)">
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="9" y1="6" x2="20" y2="6"></line>
                                    <line x1="9" y1="12" x2="20" y2="12"></line>
                                    <line x1="9" y1="18" x2="20" y2="18"></line>
                                    <line x1="5" y1="6" x2="5" y2="6.01"></line>
                                    <line x1="5" y1="12" x2="5" y2="12.01"></line>
                                    <line x1="5" y1="18" x2="5" y2="18.01"></line>
                                </svg>
                            </x-slot>
                        </x-table.bulk-action-button>
                    </div>
                    <div class="py-3 border-r border-gray-300">&nbsp;</div>
                    <div class="flex pl-5">
                        <x-table.bulk-action-button nameButton="Export" event="$toggle('confirmingExport')">
                            <x-slot name="icon">
                                <svg class="text-gray-600" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                    <polyline points="7 11 12 16 17 11"></polyline>
                                    <line x1="12" y1="4" x2="12" y2="16"></line>
                                </svg>
                            </x-slot>
                        </x-table.bulk-action-button>
                        <x-table.bulk-action-button nameButton="Select All" event="selectAll">
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3.5 5.5l1.5 1.5l2.5 -2.5"></path>
                                    <path d="M3.5 11.5l1.5 1.5l2.5 -2.5"></path>
                                    <path d="M3.5 17.5l1.5 1.5l2.5 -2.5"></path>
                                    <line x1="11" y1="6" x2="20" y2="6"></line>
                                    <line x1="11" y1="12" x2="20" y2="12"></line>
                                    <line x1="11" y1="18" x2="20" y2="18"></line>
                                 </svg>
                            </x-slot>
                        </x-table.bulk-action-button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div wire:loading wire:target="paginateValue, search, selectPage, previousPage, nextPage, confirmingExport">
        @include('partials.loading')
    </div>

    <!-- Export Seciotn/s Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingExport">
        <x-slot name="title">
            {{ __('Export Records') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to export selected data?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingExport')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="fileExport" wire:loading.attr="disabled">
                {{ __('Export') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Adding Section/s Confirmation Modal -->
    <x-jet-dialog-modal wire:model="addingSection">
        <x-slot name="title">
            {{ __('Section Maintenance') }}
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="grid grid-cols-8 gap-6">
                    <div class="mt-4 col-span-4">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input wire:model.lazy="section.name" id="name" class="block mt-1 w-full" type="text" name="name" autofocus required/>
                        <x-jet-input-error for="section.name" class="mt-2"/>
                    </div>
                    
                    <div class="mt-4 col-span-4">
                        <x-jet-label for="room" value="{{ __('Room') }}" />
                        <select wire:model.lazy="section.room_id" name="room" class="w-full mt-1 bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            @forelse ($this->rooms as $room)
                                @if ($loop->first)
                                    <option value="">-- choose a room --</option>
                                @endif
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                        <x-jet-input-error for="section.room_id" class="mt-2"/>
                    </div>
                </div>
                
                <div class="mt-4">
                    <x-jet-label for="remarks" value="{{ __('Remarks') }}" />
                    <textarea wire:model.lazy="section.remarks" id="remarks" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="remarks" autofocus required></textarea>
                    <x-jet-input-error for="section.remarks" class="mt-2"/>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('addingSection')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
                {{ __('Add') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Adding Schedule/s Confirmation Modal -->
    <x-jet-dialog-modal wire:model="addingSchedule">
        <x-slot name="title">
            {{ __('Schedule Maintenance') }}
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="grid grid-cols-8 gap-6">
                    <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                        <div class="col-span-8">
                            <x-jet-label for="monday" value="{{ __('Monday') }}" />
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="start" value="{{ __('Start Time') }}" />
                            <x-jet-input wire:model="schedule.start_time_monday" id="start" class="block mt-1 w-full" type="time" name="start" autofocus required/>
                            <x-jet-input-error for="schedule.start_time_monday" class="mt-2"/>
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="end" value="{{ __('End Time') }}" />
                            <x-jet-input wire:model="schedule.end_time_monday" id="end" class="block mt-1 w-full" type="time" name="end" autofocus required/>
                            <x-jet-input-error for="schedule.end_time_monday" class="mt-2"/>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                        <div class="col-span-8">
                            <x-jet-label for="tuesday" value="{{ __('Tuesday') }}" />
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="start" value="{{ __('Start Time') }}" />
                            <x-jet-input wire:model="schedule.start_time_tuesday" id="start" class="block mt-1 w-full" type="time" name="start" autofocus required/>
                            <x-jet-input-error for="schedule.start_time_tuesday" class="mt-2"/>
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="end" value="{{ __('End Time') }}" />
                            <x-jet-input wire:model="schedule.end_time_tuesday" id="end" class="block mt-1 w-full" type="time" name="end" autofocus required/>
                            <x-jet-input-error for="schedule.end_time_tuesday" class="mt-2"/>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                        <div class="col-span-8">
                            <x-jet-label for="wednesday" value="{{ __('Wednesday') }}" />
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="start" value="{{ __('Start Time') }}" />
                            <x-jet-input wire:model="schedule.start_time_wednesday" id="start" class="block mt-1 w-full" type="time" name="start" autofocus required/>
                            <x-jet-input-error for="schedule.start_time_wednesday" class="mt-2"/>
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="end" value="{{ __('End Time') }}" />
                            <x-jet-input wire:model="schedule.end_time_wednesday" id="end" class="block mt-1 w-full" type="time" name="end" autofocus required/>
                            <x-jet-input-error for="schedule.end_time_wednesday" class="mt-2"/>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                        <div class="col-span-8">
                            <x-jet-label for="thursday" value="{{ __('Thursday') }}" />
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="start" value="{{ __('Start Time') }}" />
                            <x-jet-input wire:model="schedule.start_time_thursday" id="start" class="block mt-1 w-full" type="time" name="start" autofocus required/>
                            <x-jet-input-error for="schedule.start_time_thursday" class="mt-2"/>
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="end" value="{{ __('End Time') }}" />
                            <x-jet-input wire:model="schedule.end_time_thursday" id="end" class="block mt-1 w-full" type="time" name="end" autofocus required/>
                            <x-jet-input-error for="schedule.end_time_thursday" class="mt-2"/>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-8 gap-2 col-span-8">
                        <div class="col-span-8">
                            <x-jet-label for="friday" value="{{ __('Friday') }}" />
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="start" value="{{ __('Start Time') }}" />
                            <x-jet-input wire:model="schedule.start_time_friday" id="start" class="block mt-1 w-full" type="time" name="start" autofocus required/>
                            <x-jet-input-error for="schedule.start_time_friday" class="mt-2"/>
                        </div>
                        <div class="col-span-4">
                            <x-jet-label for="end" value="{{ __('End Time') }}" />
                            <x-jet-input wire:model="schedule.end_time_friday" id="end" class="block mt-1 w-full" type="time" name="end" autofocus required/>
                            <x-jet-input-error for="schedule.end_time_friday" class="mt-2"/>
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('addingSchedule')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="updateSchedule" wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>