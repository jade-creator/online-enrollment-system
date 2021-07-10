<div class="w-full flex flex-1 scrolling-touch">
    <x-table.filter>
        <div name='slot'>
            <div class="my-4">
                <div class="my-4">
                    <h3 class="font-bold text-md">{{ __('Status')}}</h3>
                    <div class="relative w-full bg-white pb-3 border-b border-gray-200 transition-all duration-500 focus-within:border-gray-300">
                        <select wire:model="statusId" wire:loading.attr="disabled" id="status" aria-label="statuses" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                            @forelse ($this->statuses as $status)
                                @if ($loop->first)
                                    <option value="">-- choose a status --</option>
                                @endif
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @empty
                                <option value="">No records</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </x-table.filter>

    <!-- Module -->
    <div class="min-h-screen w-full py-8 px-8">

        <x-table.title tableTitle="All Registrations" 
            :isSelectedAll="$this->selectAll" 
            :count="count($this->selected)" 
            :route="route('student.registrations.create')" 
            routeTitle="Add Registration"/>

        <x-table.main>
            <x-slot name="paginationLink">
                {{ $registrations->links() }} 
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex" id="columnTitle">
                    <input type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button nameButton="ID" event="sortFieldSelected('id')"/>
                </div>
                <x-table.column-title columnTitle="student type" class="col-span-2"/>
                <x-table.column-title columnTitle="status" class="col-span-2"/>
                <x-table.column-title columnTitle="section" class="col-span-2"/>
                <x-table.column-title columnTitle="prospectus" class="col-span-3"/>
                <div class="col-span-1">
                    <x-table.sort-button nameButton="latest" event="sortFieldSelected('created_at')"/>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div class="w-full p-2 my-1 rounded-md shadow hover:shadow-md @if ($this->isSelected($registration->id)) bg-gray-200 @else bg-white @endif border-t border-l border-r border-gray-200 border-opacity-80">
                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-12 md:col-span-2 truncate font-bold text-xs">
                                <div class="flex items-center">
                                    <input wire:loading.attr="disabled" type="checkbox" id="{{ $registration->id }}" value="{{ $registration->id }}" wire:model="selected" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
                                    <div class="h-10 flex items-center">
                                        {{ $registration->id ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->isNew ? 'Old' : 'New' }}</div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->status->name }}</div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->section->name ?? 'N/A' }}</div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-3 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->prospectus->level->level ?? 'N/A' }}
                            </div>
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
                                                    <a role="button">
                                                        <button wire:click.prevent="viewRegistration({{ $registration->id }})" wire:loading.attr="disabled" class="flex w-full px-4 py-2 hover:bg-gray-200 outline-none focus:outline-none transition-all duration-300 ease-in-out" type="button">
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
                                                    <a role="button">
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
                @empty  
                    <x-table.no-result title="No registration found.🤔"/> 
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

    <div wire:loading wire:target="paginateValue, search, selectPage, previousPage, nextPage, confirmingExport, viewRegistration">
        @include('partials.loading')
    </div>

    <!-- Export User/s Confirmation Modal -->
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

    <!-- View Student Registration -->
    <x-jet-dialog-modal wire:model="viewRegistrationDetails">
        <x-slot name="title">
            {{ __('Registration Details') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6">
                <x-jet-label for="prospectus" value="{{ __('Prospectus') }}" class="my-2" />
                <input wire:model="prospectus" type="text" id="prospectus" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            </div>

            <div class="col-span-6">
                <x-jet-label for="status" value="{{ __('Status') }}" class="my-2" />
                <input wire:model="status" type="text" id="status" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            </div>

            <div class="col-span-6">
                <x-jet-label for="type" value="{{ __('Status') }}" class="my-2" />
                <input wire:model="studentType" type="text" id="type" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            </div>

            <div class="col-span-6 mt-2" id="subjects">
                <x-jet-label class="my-2 font-bold text-indigo-500 text-xs" for="subjects" value="{{ __('Subjects') }}" />
                <div class="mb-4 grid grid-cols-6 gap-2 col-span-6">
                    <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">code</div>
                    <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">title</div>
                    <div class="col-span-1 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">unit</div>
                    <div class="col-span-2 font-bold text-xs text-gray-400 uppercase tracking-widest text-left">pre requisite</div>
                </div>

                @foreach ($registration->prospectus->subjects as $subject)
                    <div class="mb-2 py-2 grid grid-cols-6 gap-2 col-span-6 border-b-2 border-gray-200">
                        <div class="col-span-1">{{ $subject->code }}</div>
                        <div class="col-span-2">{{ $subject->title }}</div>
                        <div class="col-span-1">{{ $subject->unit }}</div>
                        <div class="col-span-2">
                            @forelse ($subject->requisites as $requisite)
                                {{ $loop->first ? '' : ', '  }}
                                <span>&nbsp;{{ $requisite->code }}</span>
                            @empty

                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click.prevent="back" wire:loading.attr="disabled">
                {{ __('Back') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>