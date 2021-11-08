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
                <x-table.column-title class="col-span-2">Paypal</x-table.column-title>
                <x-table.column-title class="col-span-2">Amount</x-table.column-title>
                <x-table.column-title class="col-span-2">Balance</x-table.column-title>
                <x-table.column-title class="col-span-3">Payment</x-table.column-title>
                <x-table.column-title class="col-span-1">Option</x-table.column-title>
            </x-slot>

            <x-slot name="body">
                @forelse ($transactions as $transaction)
                    <div wire:key="table-row-{{$transaction->id}}" x-data="{ open: false }">
                        <x-table.row :active="$this->isSelected($transaction->id)">
                            <div name="slot" class="grid grid-cols-12 gap-2">
                                <x-table.cell-checkbox :value="$transaction->id">{{ $transaction->custom_id ?? 'N/A' }}</x-table.cell-checkbox>
                                <x-table.cell headerLabel="Paypal Transaction ID" class="justify-start md:col-span-2">
                                    <div class="hidden md:block flex flex-col">
                                        <div>
                                            <a href="{{ 'https://www.sandbox.paypal.com/activity/payment/'.$transaction->paypal_transaction_id }}" class="underline text-blue-500" target="_blank">
                                                {{ $transaction->paypal_transaction_id ?? '--' }}
                                            </a>
                                        </div>
                                        <div class="font-bold text-gray-400 text-xs pt-0.5">{{ $transaction->created_at->timezone('Asia/Manila')->format('M. d, Y g:i:s A') ?? 'N/A' }}</div>
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

                                                    @can ('export', $transaction)
                                                        <a href="{{ route('stream.transaction.pdf', $transaction) }}" target="_blank">
                                                            <x-table.cell-button title="Print Details">
                                                                <x-icons.export-icon/>
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

                        <x-table.nested-row>
                            <x-slot name="nestedTable">
                                <div class="hidden md:grid grid-cols-12 gap-2 p-4 bg-indigo-500">
                                    <x-table.column-title class="col-span-2"><span class="text-white">Student</span></x-table.column-title>
                                    <x-table.column-title class="col-span-2"><span class="text-white">Registration ID</span></x-table.column-title>
                                    <x-table.column-title class="col-span-2"><span class="text-white">Program</span></x-table.column-title>
                                    <x-table.column-title class="col-span-2"><span class="text-white">total</span></x-table.column-title>
                                    <x-table.column-title class="col-span-3"><span class="text-white">date</span></x-table.column-title>
                                    <x-table.column-title class="col-span-1"><span class="text-white">action</span></x-table.column-title>
                                </div>

                                <div class="grid grid-cols-12 md:gap-2 px-4 py-4 md:py-0">
                                    @if (filled($transaction->registration))
                                        <x-table.cell headerLabel="Student" class="md:col-span-2 md:flex items-center">
                                            @if ( Laravel\Jetstream\Jetstream::managesProfilePhotos() )
                                                <div class="hidden md:block mr-4 flex-shrink-0"><img class="h-8 w-8 rounded-full object-cover" src="{{ $transaction->registration->student->user->profile_photo_url ?? 'N/A' }}"/></div>
                                            @endif
                                            <div class="flex flex-col my-2 md:my-0">
                                                <div>{{ $transaction->registration->student->user->person->short_full_name ?? 'N/A'}}</div>
                                                <div class="font-bold text-gray-400 text-xs pt-0.5">{{ $transaction->registration->student->custom_id ?? 'N/A' }}</div>
                                            </div>
                                        </x-table.cell>
                                        <x-table.cell headerLabel="Registration ID" class="md:col-span-2">{{ $transaction->registration->custom_id ?? 'N/A' }}</x-table.cell>
                                        <x-table.cell headerLabel="Program" class="md:col-span-2">
                                            <div class="flex flex-col my-2 md:my-0">
                                                <div>{!! $transaction->registration->prospectus->program->code ?? '<span class="text-gray-400">N/A</span>' !!}</div>
                                                <div class="tracking-widest text-gray-500 text-xs pt-0.5">
                                                    {!! $transaction->registration->prospectus->level->level ?? '<span class="text-gray-400">N/A</span>' !!} - {{ $transaction->registration->prospectus->term->term ?? '<span class="text-gray-400">N/A</span>' }}
                                                </div>
                                            </div>
                                        </x-table.cell>
                                        <x-table.cell headerLabel="total" class="md:col-span-2">{{ $transaction->registration->assessment->getFormattedPriceAttribute($transaction->registration->assessment->grand_total) ?? 'N/A' }}</x-table.cell>
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
    </div>

    <div wire:loading>
        @include('partials.loading')
    </div>
</div>
