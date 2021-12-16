<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Payments" :isSelectedAll="$this->selectAll" :count="count($this->selected)">
            <x-table.nav-button wire:click="pay">
                Create New Payment
            </x-table.nav-button>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter>
                    <x-table.filter-slot title="Archive">
                        <select wire:model="isArchived" wire:loading.attr="disabled" name="Archive" class="w-full flex-1">
                            <option value="" selected>All</option>
                            <option value="0">Active</option>
                            <option value="1">Archived</option>
                        </select>
                    </x-table.filter-slot>
                </x-table.filter>
            </x-slot>

            <x-slot name="paginationLink"></x-slot>

            <x-slot name="head">
                <div class="col-span-2 flex items-center">
                    <input wire:model="selectPage" wire:loading.attr="disabled" type="checkbox" title="Select Displayed Data" class="mx-3 cursor-pointer border-gray-500 border-opacity-50 focus:outline-none focus:ring focus:ring-transparent rounded-sm">
                    <x-table.sort-button event="sortFieldSelected('id')">Transaction ID</x-table.sort-button>
                </div>
                <x-table.column-title class="col-span-2">Name</x-table.column-title>
                <x-table.column-title class="col-span-2">Amount</x-table.column-title>
                <x-table.column-title class="col-span-2">Balance</x-table.column-title>
                <x-table.column-title class="col-span-3">Payment</x-table.column-title>
                <x-table.column-title class="col-span-1">Option</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($transactions as $transaction)
                    <div wire:key="table-row-{{$transaction->id}}" x-data="{ open: false }">
                        <x-table.row :active="$this->isSelected($transaction->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$transaction->id">{{ $transaction->custom_id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="Name" class="justify-start md:col-span-2">
                                    <div class="flex flex-col my-2 md:my-0">
                                        <div>{{ $transaction->name ?? 'N/A'}}</div>
                                        <div class="font-bold text-gray-400 text-xs pt-0.5">{{ $transaction->email ?? 'N/A' }}</div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell headerLabel="Amount" class="justify-start md:col-span-2">
                                    <div class="flex flex-col my-2 md:my-0">
                                        <div>{{ $transaction->getFormattedPriceAttribute($transaction->amount) ?? 'N/A' }}</div>
                                        <div class="font-bold text-red-500 text-xs pt-0.5">
                                            {{ $transaction->penalty == 0 ? '' : '+ '.$transaction->getFormattedPriceAttribute($transaction->penalty) }}
                                        </div>
                                    </div>
                                </x-table.cell>
                                <x-table.cell headerLabel="Balance" class="justify-start md:col-span-2">{{ $transaction->getFormattedPriceAttribute($transaction->running_balance) ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Payment" class="justify-start md:col-span-3">{!! $transaction->payment_element ?? 'N/A' !!}</x-table.cell>
                                @if (is_null($transaction->archived_at))
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
                                                        @can ('view', $transaction->registration)
                                                            <a href="{{ route('pre.registration.view', $transaction->registration->id) }}">
                                                                <x-table.cell-button title="View Registration">
                                                                    <x-icons.pre-enrollment-icon/>
                                                                </x-table.cell-button>
                                                            </a>
                                                        @endcan

                                                        <a href="{{ route('stream.transaction.pdf', $transaction) }}" target="_blank">
                                                            <x-table.cell-button title="Print Details">
                                                                <x-icons.export-icon/>
                                                            </x-table.cell-button>
                                                        </a>

                                                        <x-table.cell-button wire:click="archive('Transaction', {{$transaction}}, 'archived_at')" wire:loading.attr="disabled" @click.stop title="Archive">
                                                            <x-icons.edit-icon/>
                                                        </x-table.cell-button>
                                                    </div>
                                                </x-slot>
                                            </x-jet-dropdown>
                                        @endif
                                    </x-table.cell-action>
                                @else
                                    @if (!count($selected) > 0)
                                        <x-table.cell x-data="{ open: true }" @click.stop headerLabel="Action" class="justify-start md:col-span-1">
                                            <button wire:click="unarchive('Transaction', {{$transaction}}, 'archived_at')" wire:loading.attr="disabled" @click.stop class="text-blue-400 hover:text-blue-500 text-base focus:outline-none relative px-2">
                                                <span>loading...</span>
                                                <span x-show="open"
                                                      @click="open = ! open"
                                                      :class="{'visible': open, 'invisible': ! open}"
                                                      class="absolute left-0 bg-white underline">Unarchive</span>
                                            </button>
                                        </x-table.cell>
                                    @endif
                                @endif
                            </div>
                        </x-table.row>

                        <x-table.nested-row>
                            <x-slot name="nestedTable">
                                <div class="hidden md:grid grid-cols-12 gap-2 p-4 bg-indigo-500">
                                    <x-table.column-title class="col-span-2"><span class="text-white">Registration ID</span></x-table.column-title>
                                    <x-table.column-title class="col-span-2"><span class="text-white">level</span></x-table.column-title>
                                    <x-table.column-title class="col-span-2"><span class="text-white">semester</span></x-table.column-title>
                                    <x-table.column-title class="col-span-2"><span class="text-white">total</span></x-table.column-title>
                                    <x-table.column-title class="col-span-3"><span class="text-white">date</span></x-table.column-title>
                                    <x-table.column-title class="col-span-1"><span class="text-white">action</span></x-table.column-title>
                                </div>

                                <div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
                                    @if (filled($transaction->registration))
                                        <x-table.cell headerLabel="Registration ID" class="md:col-span-2">{{ $transaction->registration->custom_id ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell headerLabel="level" class="md:col-span-2">{{ $transaction->registration->prospectus->level->level ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell headerLabel="semester" class="md:col-span-2">{{ $transaction->registration->prospectus->term->term ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell headerLabel="total" class="md:col-span-2">{{$transaction->getFormattedPriceAttribute($transaction->registration->assessment->grand_total) ?? '--'}}</x-table.cell>
                                        <x-table.cell headerLabel="date" class="md:col-span-3">{{ $transaction->registration->created_at->timezone('Asia/Manila')->format('M. d, Y') ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell-action>
                                            <a href="{{ route('pre.registration.view', $transaction->registration->id ?? '') }}">
                                                <x-table.cell-button>
                                                    <div class="w-full text-center">
                                                        <x-icons.view-icon class="hidden md:block"/>
                                                        <div class="flex justify-center md:hidden">
                                                            <span>View</span>
                                                            <x-icons.corner-right-up />
                                                        </div>
                                                    </div>
                                                </x-table.cell-button>
                                            </a>
                                        </x-table.cell-action>
                                    @else
                                        <x-table.no-result>No registration found.🤔</x-table.no-result>
                                    @endif
                                </div>
                            </x-slot>
                        </x-table.nested-row>
                    </div>
                @empty
                    <x-table.no-result>No payments found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>

        <x-table.bulk-action-bar :count="count($selected)">
            @if (isset($isArchived) && $isArchived !== '1')
                <x-table.bulk-action-button nameButton="Archive" event="archiveAll('Transaction', 'archived_at')">
                    <x-icons.edit-icon/>
                </x-table.bulk-action-button>
            @else
                <x-table.bulk-action-button nameButton="Unarchive" event="unarchiveAll('Transaction', 'archived_at')">
                    <x-icons.edit-icon/>
                </x-table.bulk-action-button>
            @endif
        </x-table.bulk-action-bar>
    </div>

    <div>@include('partials.loading')</div>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
