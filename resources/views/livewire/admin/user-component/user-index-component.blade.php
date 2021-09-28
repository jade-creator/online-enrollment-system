<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Users" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            @can('create', App\Models\User::class)
                <a href="{{ route('admin.users.create') }}">
                    <x-table.nav-button>
                        Creat New User
                    </x-table.nav-button>
                </a>
            @endcan
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter>
                    <x-jet-label for="role" value="{{ __('Role') }}" />
                    <select wire:model="roleId" wire:loading.attr="disabled" name="role" class="w-full bg-white flex-1 px-0 py-1 tracking-wide focus:outline-none border-0 focus:ring focus:ring-white focus:ring-opacity-0">
                        @forelse ($this->roles as $role)
                            @if ($loop->first)
                                <option value="" selected>All</option>
                            @endif
                            <option value="{{ $role->id ?? 'N/A' }}">{{ $role->name ?? 'N/A' }}</option>
                        @empty
                            <option value="">No records</option>
                        @endforelse
                    </select>
                </x-table.filter>
            </x-slot>

            <x-slot name="paginationLink">
                {{ $users->links('partials.pagination-link') }}
            </x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-start">
                    <input wire:loading.attr="disabled" type="checkbox" wire:model="selectPage" class="cursor-pointer border-gray-400 focus:outline-none focus:ring-transparent mx-5 rounded-sm" title="Select Displayed Data">
                    <x-table.sort-button event="sortFieldSelected('id')">id</x-table.sort-button>
                </div>
                <div class="col-span-3">
                    <x-table.sort-button event="sortFieldSelected('name')">name</x-table.sort-button>
                </div>
                <div class="col-span-4">
                    <x-table.sort-button event="sortFieldSelected('email')">email</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-2">role</x-table.column-title>
                <div class="col-span-1">
                    <x-table.sort-button event="sortFieldSelected('created_at')">latest</x-table.sort-button>
                </div>
            </x-slot>

            <x-slot name="body">
                @forelse ($users as $user)
                    <div wire:key="table-row-{{$user->id}}">
                        <x-table.row :active="$this->isSelected($user->id)">
                            <div name="slot" class="grid grid-cols-12 gap-2">
                                <x-table.cell-checkbox :value="$user->id">{{ $user->id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell class="justify-start md:col-span-3 flex items-center">
                                    @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url }}"/>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        {{ $user->name ?? 'N/A'}}
                                    </div>
                                </x-table.cell>
                                <x-table.cell class="justify-start md:col-span-4">{{ $user->email ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $user->role->name ?? 'N/A' }}</x-table.cell>
                                <x-table.cell-action>
                                    @if (!count($selected) > 0)
                                        <x-jet-dropdown align="right" width="60" dropdownClasses="z-10 shadow-2xl">
                                            <x-slot name="trigger">
                                                <x-table.cell-dropdown-trigger-btn/>
                                            </x-slot>

                                            <x-slot name="content">
                                                <div class="w-60">
                                                    <div class="block px-4 py-3 text-sm text-gray-500 font-bold">
                                                        {{ __('Actions') }}
                                                    </div>
                                                    @can ('activate', $user)
                                                        <x-table.cell-button wire:click="confirmAction('deactivate', {{ $user }})" title="Deactivate">
                                                            <x-icons.view-icon/>
                                                        </x-table.cell-button>
                                                    @elsecan('deactivate', $user)
                                                        <x-table.cell-button wire:click="confirmAction('activate', {{ $user }})" title="Activate">
                                                            <x-icons.view-icon/>
                                                        </x-table.cell-button>
                                                    @endcan
                                                </div>
                                            </x-slot>
                                        </x-jet-dropdown>
                                    @endif
                                </x-table.cell-action>
                            </div>
                        </x-table.row>
                    </div>
                @empty
                    <x-table.no-result>No users found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @can('export', App\Models\User::class)
                <x-table.bulk-action-button nameButton="Export" event="confirmFileExport">
                    <x-icons.export-icon/>
                </x-table.bulk-action-button>
            @endcan
        </x-table.bulk-action-bar>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>
</div>
