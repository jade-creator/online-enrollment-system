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
                            @isset ($registration->assessment)
                                <p class="text-base">Final Assessment of fees</p>
                            @else
                                <p class="text-base">Initial Assessment of fees</p>
                            @endisset
                        </div>
                    </x-slot>

                    <x-slot name="description"></x-slot>

                    <x-slot name="form">
                        <div class="col-span-6 font-bold">Details</div>
                        @isset ($registration->assessment)
                            @forelse ($registration->fees as $index => $fee)
                                <div class="col-span-6 flex items-center justify-between">
                                    <p class="text-gray-600 text-base">{{ $fee->category->name ?? 'N/A' }}</p>
                                    <p class="text-black font-semibold">{{ $fee->getFormattedPriceAttribute($fee->formatTwoDecimalPlaces($fee->pivot->total_fee)) ?? 'N/A' }}</p>
                                </div>

                                @if ($loop->last)
                                    <div class="col-span-6 flex items-center justify-between">
                                        <p class="text-gray-600 text-base">Additional Fee</p>
                                        <p class="text-black font-semibold">{{ $assessment->getFormattedPriceAttribute($assessment->additional) ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-span-6 flex items-center justify-between">
                                        <p class="text-gray-600 text-base">Discount Type</p>
                                        <p class="text-black font-semibold">
                                            @isset ($assessment->isPercentage)
                                                {{ $assessment->discount_type ?? 'N/A' }}
                                            @else
                                                N/A
                                            @endisset
                                        </p>
                                    </div>
                                    <div class="col-span-6 flex items-center justify-between">
                                        <p class="text-gray-600 text-base">Discount Amount</p>
                                        <p class="text-black font-semibold">{{ $assessment->discount_amount ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-span-6">
                                        <p class="text-gray-600 text-base">Remarks</p>
                                        <textarea readonly>{{ $assessment->remarks ?? 'N/A' }}</textarea>
                                    </div>
                                    <div class="col-span-6 flex justify-between items-center font-bold">
                                        <p class="text-lg text-black">Total Amount</p>
                                        <p class="text-lg text-green-500">{{ $assessment->getFormattedPriceAttribute($assessment->grand_total) ?? 'N/A' }}</p>
                                    </div>
                                @endif
                            @empty
                                <p>No calculated fees.</p>
                            @endforelse
                        @else
                            {{--STUDENT: DISPLAY ONLY FOR INITIAL ASSESSMENT.--}}
                            @can ('submitted', $registration)
                                @forelse ($registration->prospectus->program->fees as $index => $fee)
                                    <div class="col-span-6 flex items-center justify-between">
                                        <p class="text-gray-600 text-base">{{ $fee->category->name ?? 'N/A' }}</p>
                                        <p class="text-black font-semibold">{{ $fee->getFormattedPriceAttribute($fee->price) ?? 'N/A' }}</p>
                                    </div>
                                @empty
                                    <p>No calculated fees.</p>
                                @endforelse
                            {{--REGISTRAR: DISPLAY ONLY FOR INITIAL ASSESSMENT.--}}
                            @elsecan('reject', $registration)
                                @isset ($grandTotal)
                                    @forelse ($registration->fees as $index => $fee)
                                        <div class="col-span-6 flex items-center justify-between">
                                            <p class="text-gray-600 text-base">{{ $fee->category->name ?? 'N/A' }}</p>
                                            <p class="text-black font-semibold">{{ $fee->getFormattedPriceAttribute($fee->formatTwoDecimalPlaces($fee->pivot->total_fee)) ?? 'N/A' }}</p>
                                        </div>

                                        @if ($loop->last)
                                            <div class="col-span-6 flex items-center justify-between">
                                                <p class="text-gray-600 text-base">Additional Fee</p>
                                                <p class="text-black font-semibold">{{ $fee->getFormattedPriceAttribute($additional) ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-span-6 flex items-center justify-between">
                                                <p class="text-gray-600 text-base">Discount Type</p>
                                                <p class="text-black font-semibold">
                                                    @isset ($assessment->isPercentage)
                                                        {{ $assessment->discount_type ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endisset
                                                </p>
                                            </div>
                                            <div class="col-span-6 flex items-center justify-between">
                                                <p class="text-gray-600 text-base">Discount Amount</p>
                                                <p class="text-black font-semibold">{{ $assessment->discount_amount ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-span-6">
                                                <p class="text-gray-600 text-base">Remarks</p>
                                                <textarea readonly>{{ $assessment->remarks ?? 'N/A' }}</textarea>
                                            </div>
                                            <div class="col-span-6 flex justify-between items-center font-bold">
                                                <p class="text-lg text-black">Total Amount</p>
                                                <p class="text-lg text-green-500">{{ $fee->getFormattedPriceAttribute($grandTotal) ?? 'N/A' }}</p>
                                            </div>
                                        @endif
                                    @empty
                                        <p>No calculated fees.</p>
                                    @endforelse
                                @else
                                    @forelse ($registration->prospectus->program->fees as $fee)
                                        <div class="col-span-6 flex items-center">
                                            <input wire:model.defer="fees.{{ $fee->id }}.0" type="checkbox">
                                            <p class="text-gray-600 mx-1">{{ $fee->category->name }}</p>
                                        </div>
                                        <div class="col-span-6">
                                            <input wire:model.defer="fees.{{ $fee->id }}.1" value="{{ $fee->price }}" type="number">
                                        </div>
                                    @empty
                                        <p>No added fees under this program.</p>
                                    @endforelse
                                    <div class="col-span-6">
                                        <x-jet-section-border/>
                                    </div>
                                    <div class="col-span-6">
                                        <x-jet-label value="{{ __('Additional') }}"/>
                                        <input wire:model.defer="additional" wire:loading.attr="disabled" type="number" min="0">
                                        <x-jet-input-error for="additional" class="mt-2"/>
                                    </div>
                                    <div class="col-span-6">
                                        <x-jet-label value="{{ __('Discount Type') }}"/>
                                        <select wire:model="assessment.isPercentage" wire:loading.attr="disabled">
                                            <option value="" selected>N/A</option>
                                            <option value="0">Amount</option>
                                            <option value="1">Percentage</option>
                                        </select>
                                        <x-jet-input-error for="assessment.isPercentage" class="mt-2"/>
                                    </div>
                                    @if (filled($this->assessment->isPercentage))
                                        <div class="col-span-6">
                                            <x-jet-label value="{{ __('Discount Amount') }}"/>
                                            <input wire:model.defer="assessment.discount_amount" type="number" min="0">
                                            <x-jet-input-error for="assessment.discount_amount" class="mt-2"/>
                                        </div>
                                    @endif
                                    <div class="col-span-6">
                                        <x-jet-label value="{{ __('Remarks') }}"/>
                                        <textarea wire:model.defer="assessment.remarks" wire:loading.attr="disabled" type="number" min="0"></textarea>
                                        <x-jet-input-error for="assessment.remarks" class="mt-2"/>
                                    </div>
                                @endisset
                            @endcan
                        @endisset
                    </x-slot>

                    <x-slot name="actions">
                        @isset ($registration->assessment)
                            @can ('proceedToPayment', $registration->assessment)
                                <a class="w-full text-white py-2 rounded-md bg-indigo-500 hover:bg-indigo-800 flex items-center justify-center" href="{{ route('student.paywithpaypal', ['registrationId' => $this->registration->id]) }}">
                                    <span>Proceed to Payment</span>
                                    <x-icons.right-arrow-icon />
                                </a>
                            @elsecan ('view', $registration->assessment)
                                <a class="w-full text-white py-2 rounded-md bg-indigo-500 hover:bg-indigo-800 flex items-center justify-center" href="{{ route('admin.payments.view', ['search' => $this->registration->id]) }}">
                                    <x-icons.fee-icon/>
                                    <span class="mx-2">PAID AMOUNT: {{ $registration->assessment->paid_amount ?? 'N/A' }}</span>
                                </a>
                            @endcan
                        @else
                            @if (! isset($grandTotal))
                                @can ('enroll', $registration)
                                    <x-jet-button wire:click="compute" wire:loading.attr="disabled" class="w-full bg-indigo-500 hover:bg-indigo-800 flex items-center justify-center">
                                        <x-icons.fee-icon/>
                                        <span class="mx-2">{{ __('COMPUTE GRAND TOTAL') }}</span>
                                    </x-jet-button>
                                @elsecan ('submitted', $registration)
                                    <x-jet-button disabled="disabled" class="w-full bg-indigo-500 flex items-center justify-center cursor-not-allowed disabled:opacity-80">
                                        <x-icons.reject-icon/>
                                        <span class="mx-2">{{ __('PLEASE WAIT THE FINAL ASSESSMENT') }}</span>
                                    </x-jet-button>
                                @endcan
                            @else
                                <div class="w-full flex flex-col">
                                    <x-jet-button wire:click="save" wire:loading.attr="disabled" class="w-full bg-green-500 hover:bg-green-600 flex items-center justify-center">
                                        <x-icons.fee-icon/>
                                        <span class="mx-2">{{ __('PLACE FEES') }}</span>
                                    </x-jet-button>
                                    <x-jet-button wire:click="cancel" class="w-full text-indigo-500 border-indigo-500 bg-white hover:bg-gray-200 flex items-center justify-center my-2">
                                        <x-icons.reject-icon/>
                                        <span class="mx-2">{{ __('CANCEL') }}</span>
                                    </x-jet-button>
                                </div>
                            @endif
                        @endisset

                    </x-slot>
                </x-jet-form-section>
            </div>
        </div>
        <x-jet-section-border/>
    @endif
</div>
