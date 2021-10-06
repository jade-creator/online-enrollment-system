<div class="w-full scrolling-touch">

    <div class="h-content w-full py-8 px-8">
        <x-table.title tableTitle="Payments">
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter/>
            </x-slot>

            <x-slot name="paginationLink">
            </x-slot>

            <x-slot name="head">
                <x-table.column-title class="col-span-2">Transaction ID</x-table.column-title>
                <x-table.column-title class="col-span-2">DateTime</x-table.column-title>
                <x-table.column-title class="col-span-2">Amount</x-table.column-title>
                <x-table.column-title class="col-span-2">Registration ID</x-table.column-title>
                <x-table.column-title class="col-span-2">Grand Total</x-table.column-title>
                <x-table.column-title class="col-span-1">Balance</x-table.column-title>
                <x-table.column-title class="col-span-1">Option</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($transactions as $transaction)
                    <div wire:key="table-row-{{$transaction->id}}">
                        <x-table.row :active="$this->isSelected($transaction->id)">
                            <div name="slot" class="grid grid-cols-12 gap-2">
                                <x-table.cell-checkbox :value="$transaction->id">{{ $transaction->id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell class="justify-start md:col-span-2">{{ $transaction->created_at ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $transaction->getFormattedPriceAttribute($transaction->amount) ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $transaction->registration->id ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-2">{{ $transaction->getFormattedPriceAttribute($transaction->registration->assessment->grand_total) ?? 'N/A' }}</x-table.cell>
                                <x-table.cell class="justify-start md:col-span-1">{{ $transaction->getFormattedPriceAttribute($transaction->running_balance) ?? 'N/A' }}</x-table.cell>
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
                                                </div>
                                            </x-slot>
                                        </x-jet-dropdown>
                                    @endif
                                </x-table.cell-action>
                            </div>
                        </x-table.row>
                    </div>
                @empty
                    <x-table.no-result>No payments found.🤔</x-table.no-result>
                @endforelse
            </x-slot>
        </x-table.main>
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>
</div>
