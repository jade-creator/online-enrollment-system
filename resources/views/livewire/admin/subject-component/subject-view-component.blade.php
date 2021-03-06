<div class="w-full flex flex-1">
    <x-table.filter>
        <div name='slot'>

        </div>
    </x-table.filter>

    <div class="min-h-screen w-full py-8 px-8">
        <div class="mb-4 pb-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-gray-500">Subjects</div>

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
                <button wire:click="$toggle('addingSubject')" wire:loading.attr="disabled" class="focus:ring-2 focus:bg-blue-500 focus:ring-opacity-50 bg-blue-500 hover:bg-blue-600 text-white py-2.5 px-4 font-bold text-xs rounded-lg border border-white">Add Subject</button>
            </div>
        </div>

        <x-table.main>
            <x-slot name="paginationLink">
                {{ $subjects->links() }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-3 flex" id="code">
                    <input type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button nameButton="code" event="sortFieldSelected('code')"/>
                </div>
                <div class="col-span-4" id="title">
                    <x-table.sort-button nameButton="title" event="sortFieldSelected('title')"/>
                </div>
                <x-table.column-title columnTitle="Unit" class="col-span-2"/>
                <x-table.column-title columnTitle="Pre Requisite" class="col-span-2"/>
                <div class="col-span-1">
                    <x-table.sort-button nameButton="latest" event="sortFieldSelected('created_at')"/>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($subjects as $subject)
                    <div class="{{ $this->isSelected($subject->id) ? 'w-full p-2 my-1 rounded-md shadow hover:shadow-md bg-gray-200 border-t border-l border-r border-gray-200 border-opacity-80 cursor-pointer'
                        : 'w-full p-2 my-1 rounded-md shadow hover:shadow-md bg-white border-t border-l border-r border-gray-200 border-opacity-80 cursor-pointer' }}">

                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-12 md:col-span-3 truncate font-bold text-xs">
                                <div class="flex items-center">
                                    <input wire:loading.attr="disabled" type="checkbox" id="{{ $subject->id }}" value="{{ $subject->id }}" wire:model="selected" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
                                    <div class="h-10 flex items-center">
                                        {{ $subject->code ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-4 truncate md:border-0 border-t border-gray-300 font-bold text-xs"><p class="truncate">{{ $subject->title ?? 'N/A' }}</p></div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $subject->unit ?? 'N/A' }}</div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">
                                @forelse ($subject->requisites as $requisite)
                                    {{ $loop->first ? '' : ', '  }}
                                    <span>&nbsp;{{ $requisite->code }}</span>
                                @empty
                                    N/A
                                @endforelse
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
                                                    <button wire:click.prevent="viewSubject({{ $subject }})" class="flex w-full px-4 py-2 hover:bg-gray-200 outline-none focus:outline-none transition-all duration-300 ease-in-out">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <circle cx="12" cy="12" r="2"></circle>
                                                            <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
                                                         </svg>
                                                        <p class="pl-2">{{ __('View')}}</p>
                                                    </button>
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
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <x-table.no-result title="No subject found.????"/>
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

    <div>@include('partials.loading')</div>

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

    <!-- Add subect's Modal -->
    <x-jet-dialog-modal wire:model="addingSubject">
        <x-slot name="title">
            {{ __('Subject Maintenance') }}
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="grid grid-cols-8 gap-6">
                    <div class="mt-3 col-span-8">
                        <div class="mt-4">
                            <x-jet-label for="code" value="{{ __('Code') }}" />
                            <x-jet-input wire:model.defer="subject.code" id="code" class="block mt-1 w-full" type="text" name="code" autofocus required/>
                            <x-jet-input-error for="subject.code" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input wire:model.defer="subject.title" id="title" class="block mt-1 w-full" type="text" name="title" autofocus required/>
                            <x-jet-input-error for="subject.title" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="unit" value="{{ __('Unit') }}" />
                            <x-jet-input wire:model.defer="subject.unit" id="title" class="block mt-1 w-full" type="number" name="unit" autofocus required/>
                            <x-jet-input-error for="subject.unit" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="pre-requisite" value="{{ __('Pre-requisite') }}" />
                            <div class="flex flex-wrap mt-2">
                                @foreach ($preRequisites as $index => $requisite)
                                    <div class="mr-2 my-2">
                                        <div class="flex">
                                            <select wire:model="preRequisites.{{ $index }}" name="preRequisites[{{ $index }}]" class="w-full bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-l-md shadow-sm">
                                                @forelse ($this->allSubjects as $subject)
                                                    @if ($loop->first)
                                                        <option value="">-- choose a subject --</option>
                                                    @endif
                                                    <option value="{{ $subject->id }}">{{ $subject->code }}</option>
                                                @empty
                                                    <option value="">No records</option>
                                                @endforelse
                                            </select>
                                            <button wire:click.prevent="removeSubject({{ $index }})" class="bg-red-500 hover:bg-red-700 items-center px-3 py-2 border border-transparent rounded-r-md font-semibold text-xs text-white focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                 </svg>
                                            </button>
                                        </div>
                                        <x-jet-input-error for="preRequisite" class="mt-2"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-4 flex">
                            <x-jet-button class="flex items-end ml-2 border border-indigo-500 hover:bg-gray-200 text-indigo-500" wire:click.prevent="addSubject" wire:loading.attr="disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                 </svg>
                                <span>{{ __('Add Pre Requisite') }}</span>
                            </x-jet-button>
                            @if ($this->preRequisites)
                                <x-jet-button class="ml-2 border-0 text-blue-500" wire:click.prevent="resetSubjects" wire:loading.attr="disabled">
                                    {{ __('Reset') }}
                                </x-jet-button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('addingSubject')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="save" wire:loading.attr="disabled">
                {{ __('Add') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Viewing subect's Modal -->
    <x-jet-dialog-modal wire:model="viewingSubject">
        <x-slot name="title">
            {{ __('Subject Maintenance') }}
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="grid grid-cols-8 gap-6">
                    <div class="mt-3 col-span-8">
                        <div class="mt-4">
                            <x-jet-label for="code" value="{{ __('Code') }}" />
                            <x-jet-input wire:model.defer="subject.code" id="code" class="block mt-1 w-full" type="text" name="code" autofocus required/>
                            <x-jet-input-error for="subject.code" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input wire:model.defer="subject.title" id="title" class="block mt-1 w-full" type="text" name="title" autofocus required/>
                            <x-jet-input-error for="subject.title" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="unit" value="{{ __('Unit') }}" />
                            <x-jet-input wire:model.defer="subject.unit" id="title" class="block mt-1 w-full" type="number" name="unit" autofocus required/>
                            <x-jet-input-error for="subject.unit" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="pre-requisite" value="{{ __('Pre-requisite') }}" />
                            <div class="flex flex-wrap mt-2">
                                @foreach ($preRequisites as $index => $requisite)
                                    <div class="mr-2 my-2">
                                        <div class="flex">
                                            <select wire:model="preRequisites.{{ $index }}" name="preRequisites[{{ $index }}]" class="w-full bg-white flex-1 p-2 tracking-wide border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-l-md shadow-sm">
                                                @forelse ($this->availableSubjects as $subject)
                                                    @if ($loop->first)
                                                        <option value="">-- choose a subject --</option>
                                                    @endif
                                                    <option value="{{ $subject->id }}">{{ $subject->code }}</option>
                                                @empty
                                                    <option value="">No records</option>
                                                @endforelse
                                            </select>
                                            <button wire:click.prevent="removeSubject({{ $index }})" class="bg-red-500 hover:bg-red-700 items-center px-3 py-2 border border-transparent rounded-r-md font-semibold text-xs text-white focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                 </svg>
                                            </button>
                                        </div>
                                        <x-jet-input-error for="preRequisite" class="mt-2"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-4 flex">
                            <x-jet-button class="flex items-end ml-2 border border-indigo-500 hover:bg-gray-200 text-indigo-500" wire:click.prevent="addSubject" wire:loading.attr="disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                 </svg>
                                <span>{{ __('Add Pre Requisite') }}</span>
                            </x-jet-button>
                            @if ($this->preRequisites)
                                <x-jet-button class="ml-2 border-0 text-blue-500" wire:click.prevent="resetSubjects" wire:loading.attr="disabled">
                                    {{ __('Reset') }}
                                </x-jet-button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('viewingSubject')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="updateSubject" wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
