<div class="w-full">

    <div class="h-content w-full p-4 md:p-8">
        <x-table.title tableTitle="Payments">
            <x-table.nav-button wire:click="pay">
                Create New Payment
            </x-table.nav-button>
        </x-table.title>

        <x-table.main>
            <x-slot name="filter">
                <x-table.filter/>
            </x-slot>

            <x-slot name="paginationLink"></x-slot>

            <x-slot name="head">
                <x-table.column-title class="col-span-2">Transaction ID</x-table.column-title>
                <x-table.column-title class="col-span-2">Paypal</x-table.column-title>
                <x-table.column-title class="col-span-2">Amount</x-table.column-title>
                <x-table.column-title class="col-span-2">Balance</x-table.column-title>
                <x-table.column-title class="col-span-3">Payment</x-table.column-title>
                <x-table.column-title class="col-span-1">Option</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($transactions as $transaction)
                    <div wire:key="table-row-{{$transaction->id}}">
                        <x-table.row :active="$this->isSelected($transaction->id)">
                            <div name="slot" class="grid grid-cols-12 md:gap-2">
                                <x-table.cell-checkbox :value="$transaction->id">{{ $transaction->custom_id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="Paypal" class="justify-start md:col-span-2">
                                    <div class="hidden md:block flex flex-col">
                                        <div>{{ $transaction->paypal_transaction_id ?? '--' }}</div>
                                        <div class="font-bold text-gray-400 text-xs pt-0.5">{{ $transaction->created_at->timezone('Asia/Manila')->format('d-M-Y g:i:s A') ?? 'N/A' }}</div>
                                    </div>
                                    <div class="block md:hidden my-4">{{ $transaction->paypal_transaction_id ?? 'N/A' }}</div>
                                </x-table.cell>
                                <x-table.cell headerLabel="Amount" class="justify-start md:col-span-2">{{ $transaction->getFormattedPriceAttribute($transaction->amount) ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Balance" class="justify-start md:col-span-2">{{ $transaction->getFormattedPriceAttribute($transaction->running_balance) ?? 'N/A' }}</x-table.cell>
                                <x-table.cell headerLabel="Payment" class="justify-start md:col-span-3">{!! $transaction->payment_element ?? 'N/A' !!}</x-table.cell>
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

    <div>@include('partials.loading')</div>

    @if (session()->has('alert'))
        <x-form.alert type="{{session('alert')['type']}}">{!!session()->pull('alert')['message']!!}</x-form.alert>
    @endif

    @push('scripts')
        <script src="{{ asset('js/alert.js') }}"></script>
    @endpush
</div>
