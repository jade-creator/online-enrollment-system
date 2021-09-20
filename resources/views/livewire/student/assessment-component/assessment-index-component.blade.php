<div>
    @if ((isset($registration) && $registration->status->name !== 'pending') && $registration->status->name !== 'confirming')
        <div class="grid grid-cols-6 gap-2">
            <div class="col-span-3">
                <p>University Logo/Other Info</p>
            </div>

            <div class="col-span-3">
                <x-jet-form-section submit="">
                    <x-slot name="title">
                        <div class="w-full font-semibold">
                            <p class="text-base">Initial Assessment of fees</p>
                        </div>
                    </x-slot>

                    <x-slot name="description"></x-slot>

                    <x-slot name="form">
                        <div class="col-span-6">Details</div>
                        <div class="col-span-6">
                            @forelse ($registration->prospectus->program->fees as $fee)
                                <div class="flex justify-between items-center my-2">
                                    <p class="text-gray-600">{{ $fee->category->name }}</p>
                                    <p class="text-gray-900 font-bold">{{ $fee->getFormattedPriceAttribute($fee->price) }}</p>
                                </div>

                                @if ($loop->last)
                                    <div class="flex justify-between items-center my-4 font-bold">
                                        <p class="text-lg text-black">Total Amount</p>
                                        <p class="text-lg text-green-500">{{ $fee->getFormattedPriceAttribute($registration->prospectus->program->fees->sum('price')) }}</p>
                                    </div>
                                @endif
                            @empty
                                <x-table.no-result>No fees found. 🤔</x-table.no-result>
                            @endforelse
                        </div>
                    </x-slot>

                    <x-slot name="actions">
                        @can ('enroll', $registration)
                            <x-jet-button class="w-full bg-indigo-500 hover:bg-indigo-800 flex items-center justify-center">
                                <x-icons.fee-icon/>
                                <span class="mx-2">{{ __('PLACE FEES') }}</span>
                            </x-jet-button>
                        @elsecan ('submitted', $registration)
                            <x-jet-button disabled="disabled" class="w-full bg-indigo-500 flex items-center justify-center cursor-not-allowed disabled:opacity-80">
                                <x-icons.reject-icon/>
                                <span class="mx-2">{{ __('PLEASE WAIT THE FINAL ASSESSMENT') }}</span>
                            </x-jet-button>
                        @endcan
{{--                        <x-jet-button class="w-full bg-indigo-500 hover:bg-green-500 flex items-center justify-center">--}}
{{--                            <x-icons.fee-icon/>--}}
{{--                            <span class="mx-2">{{ __('PROCEED TO PAYMENT') }}</span>--}}
{{--                        </x-jet-button>--}}
{{--                        <x-jet-button class="w-full bg-green-500 hover:bg-green-600 flex items-center justify-center">--}}
{{--                            <span class="mx-2">{{ __('PAID AMOUNT: PHP 250.00') }}</span>--}}
{{--                            <span class="animate-pulse"><x-icons.right-arrow-icon/></span>--}}
{{--                        </x-jet-button>--}}
                    </x-slot>
                </x-jet-form-section>
            </div>
        </div>
        <x-jet-section-border/>
    @endif
</div>
