<div class="w-full flex flex-1 scrolling-touch">
    <x-table.filter>
        <div name='slot'>
        </div>
    </x-table.filter>

    <!-- Module -->
    <div class="min-h-screen w-full py-8 px-8">

        <div class="mb-4 pb-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-gray-500">Released: Pre Enrollment</div>

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
                <a href="{{ route("admin.pre.enrollments.view") }}">
                    <x-jet-secondary-button class="flex items-center">
                        <svg fill="none" stroke="currentColor" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="pl-2">{{ __('Current List')}}</p>
                    </x-jet-secondary-button>
                </a>
            </div>
        </div>

        <x-table.main>
            <x-slot name="paginationLink">
                {{ $registrations->links() }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex" id="columnTitle">
                    <input type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.column-title columnTitle="Student ID"/>
                </div>
                <x-table.column-title columnTitle="name" class="col-span-3"/>
                <x-table.column-title columnTitle="level" class="col-span-2"/>
                <x-table.column-title columnTitle="section" class="col-span-2"/>
                <x-table.column-title columnTitle="status" class="col-span-2"/>
                <div class="col-span-1">
                    <x-table.sort-button nameButton="latest" event="sortFieldSelected('created_at')"/>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($registrations as $registration)
                    <div class="{{ $this->isSelected($registration->id) ? 'w-full p-2 my-1 rounded-md shadow hover:shadow-md bg-gray-200 border-t border-l border-r border-gray-200 border-opacity-80 cursor-pointer'
                        : 'w-full p-2 my-1 rounded-md shadow hover:shadow-md bg-white border-t border-l border-r border-gray-200 border-opacity-80 cursor-pointer' }}">

                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-12 md:col-span-2 truncate font-bold text-xs">
                                <div class="flex items-center">
                                    <input wire:loading.attr="disabled" type="checkbox" id="{{ $registration->id }}" value="{{ $registration->id }}" wire:model="selected" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
                                    <div class="h-10 flex items-center">
                                        {{ $registration->student->isStudent ? $registration->student->custom_student_id : '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-3 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->student->user->person->full_name ?? 'N/A' }}</div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->prospectus->level->level ?? 'N/A' }}</div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->section->name ?? '--' }}</div>
                            <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $registration->status->name ?? 'N/A' }}</div>
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
                                                    <a href="{{ route('pre.registration.view', ['regId' => $registration->id]) }}">
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
                                                    <button wire:click.prevent="removeConfirm({{ $registration }})" class="flex w-full px-4 py-2 hover:bg-red-500 hover:text-white rounded-b-md outline-none focus:outline-none transition-all duration-300 ease-in-out">
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

    <div wire:loading wire:target="paginateValue, search, selectPage, previousPage, nextPage, confirmingExport">
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
</div>
