<div class="w-full flex flex-1 scrolling-touch">
    <x-table.filter>
        <div name='slot'>
            <fieldset class="border-b border-gray-200 pb-3 my-6" id="role" class="mt-6" wire:model="role">
                <h3 class="mb-2 font-bold text-md">{{ __('Role')}}</h3>
                <div class="flex items-center justify-between py-2 pr-3">
                    <div class="flex items-center">
                        <svg class="w-5" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <label for="all" class="pl-2 font-bold cursor-pointer text-sm">All</label>
                    </div>  
                    <input type="radio" class="cursor-pointer focus:outline-none focus:ring-transparent" value="" name="role" id="all" checked>
                </div>
                <div class="flex items-center justify-between py-2 pr-3">
                    <div class="flex items-center">
                        <svg class="w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                            <path d="M16 11l2 2l4 -4"></path>
                         </svg>
                        <label for="admin" class="pl-2 font-bold cursor-pointer text-sm">Admin</label>
                    </div>
                    <input class="cursor-pointer focus:outline-none focus:ring-transparent" type="radio" value="1" name="role" id="admin" class="cursor-pointer">
                </div>
                <div class="flex items-center justify-between py-2 pr-3">
                    <div class="flex items-center">
                        <svg class="w-5" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                            <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                         </svg>
                        <label for="student" class="pl-2 font-bold cursor-pointer text-sm">Student</label>
                    </div>
                    <input class="cursor-pointer focus:outline-none focus:ring-transparent" type="radio" value="2" name="role" id="student">
                </div>
            </fieldset>
        </div>
    </x-table.filter>

    <!-- Module -->
    <div class="min-h-screen w-full py-8 px-8">
        
        <x-table.title tableTitle="All Users" :isSelectedAll="$this->selectAll" :count="count($this->checkedUsers)" :route="route('admin.users.create')" routeTitle="Add User"/>

        <x-table.main>
            <x-slot name="paginationLink">
                {{ $users->links() }} 
            </x-slot>

            <x-slot name="head">
                <div class="col-span-5 flex" id="columnTitle">
                    <input type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button nameButton="name" event="$emitSelf('sortFieldSelected', 'name')"/>
                </div>
                <div class="col-span-4" id="columnTitle">
                    <x-table.sort-button nameButton="email" event="$emitSelf('sortFieldSelected', 'email')"/>
                </div>
                <x-table.column-title columnTitle="role" class="col-span-2"/>
                <x-table.column-title columnTitle="" class="col-span-1"/>
            </x-slot>

            <x-slot name="body">
                @if ($users->count())
                    @foreach ($users as $user)
                        <div class="w-full p-2 my-1 rounded-md shadow hover:shadow-md @if ($this->isSelected($user->id)) bg-gray-200 @else bg-white @endif border-t border-l border-r border-gray-200 border-opacity-80">
                            <div class="grid grid-cols-12 gap-2">
                                <div class="col-span-12 md:col-span-5 truncate font-bold text-xs">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="{{ $user->id }}" value="{{ $user->id }}" wire:model="checkedUsers" class="cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent ml-3 mr-5 rounded-sm">
                                        @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url }}"/>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-start col-span-12 md:col-span-4 truncate md:border-0 border-t border-gray-300 font-bold text-xs">{{ $user->email }}</div>
                                <div class="flex items-center justify-start col-span-12 md:col-span-2 truncate md:border-0 border-t border-gray-300 font-bold text-xs">
                                    <span class="px-2 leading-5 rounded-md text-white @if ($user->role->name === 'admin') bg-gray-800 @else bg-indigo-800 @endif">
                                        {{ $user->role->name }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-center col-span-12 md:col-span-1 md:border-0 border-t border-gray-300">
                                    @if ( !count($checkedUsers) > 0)
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
                    @endforeach
                @else
                    <x-table.no-result title="No user found.🤔"/> 
                @endif
            </x-slot>
        </x-table.main>

        <!-- Bulk action bar -->
        @if ( count($checkedUsers) > 0)
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

    <div wire:loading wire:target="role, paginateValue, search, selectPage, previousPage, nextPage, sortFieldSelected">
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

            <x-jet-button class="ml-2 bg-blue-500 hover:blue-700" wire:click="$emit('fileExport')" wire:loading.attr="disabled">
                {{ __('Export') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>