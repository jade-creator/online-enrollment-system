<div>
    @if ((isset($registration) && $registration->status->name !== 'pending')
            && $registration->status->name !== 'confirming' && $registration->status->name !== 'denied')
        <div class="md:w-8/12">
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
                        @foreach ($registration->fees as $index => $fee)
                            <div class="col-span-6 flex items-center justify-between">
                                <p class="text-gray-600 text-base">{{ $fee->category->name ?? 'N/A' }}</p>
                                <p class="text-black font-semibold">{{ $fee->getFormattedPriceAttribute($fee->formatTwoDecimalPlaces($fee->pivot->total_fee)) ?? 'N/A' }}</p>
                            </div>
                        @endforeach
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
                        @if ($assessment->isUnifastBeneficiary)
                            <div class="col-span-6 flex items-center justify-between">
                                <p class="text-gray-600 text-base">Unifast Beneficiary</p>
                                <p class="text-black font-semibold uppercase">{{ $assessment->isUnifastRecepient ?? 'N/A' }}</p>
                            </div>
                        @endif
                        <div class="col-span-6 flex justify-between items-center font-bold">
                            <p class="text-lg text-black">Total Amount</p>
                            <p class="text-lg text-green-500">{{ $assessment->getFormattedPriceAttribute($assessment->grand_total) ?? 'N/A' }}</p>
                        </div>
                        <div class="col-span-6 flex justify-between items-center font-bold text-sm text-gray-500">
                            <p>Running Balance</p>
                            <p>{{ $assessment->getFormattedPriceAttribute($assessment->balance) ?? 'N/A' }}</p>
                        </div>
                    @else
                        {{-- DISPLAY if no assessment found.--}}
                        @can ('submitted', $registration)
                            {{--STUDENT SIDE--}}
                            @forelse ($registration->prospectus->program->fees as $index => $fee)
                                <div class="col-span-6 flex items-center justify-between">
                                    <p class="text-gray-600 text-base">{{ $fee->category->name ?? 'N/A' }}</p>
                                    <p class="text-black font-semibold">{{ $fee->getFormattedPriceAttribute($fee->price) ?? 'N/A' }}</p>
                                </div>
                            @empty
                                <p class="col-span-6 text-center font-bold text-red-500">No added fees under this program.</p>
                            @endforelse
                        @elsecan('finalize', $registration)
                            {{-- ADMIN SIDE not computed yet.--}}
                            @if (! isset($grandTotal))
                                @forelse ($registration->prospectus->program->fees as $fee)
                                    <div class="col-span-6 flex items-center">
                                        <input wire:model.defer="fees.{{ $fee->id }}.0" type="checkbox">
                                        <p class="text-gray-600 mx-1">{{ $fee->category->name }}</p>
                                    </div>
                                    <div class="col-span-6">
                                        <input value="{{ $fees[$fee->id][1] }}" type="number" readonly>
                                    </div>
                                @empty
                                    <p class="col-span-6 text-center font-bold text-red-500">No added fees under this program.</p>
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
                                    <textarea wire:model.defer="assessment.remarks" wire:loading.attr="disabled"></textarea>
                                    <x-jet-input-error for="assessment.remarks" class="mt-2"/>
                                </div>
                                <div class="col-span-6">
                                    <x-jet-label value="{{ __('Unifast Beneficiary') }}"/>
                                    <fieldset name="type" class="w-100 flex items-center gap-6 mt-2">
                                        <label for="yes" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                                            <input wire:model.defer="isUnifastBeneficiary" wire:loading.attr="disabled" id="yes" type="radio" value="1" name="type" class="mr-2 outline-none">
                                            <label for="yes" class="cursor-pointer">Yes</label>
                                        </label>
                                        <label for="no" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                                            <input wire:model.defer="isUnifastBeneficiary" wire:loading.attr="disabled" id="no" type="radio" value="0" name="type" class="mr-2">
                                            <label for="no" class="cursor-pointer">No</label>
                                        </label>
                                    </fieldset>
                                    <x-jet-input-error for="isUnifastBeneficiary" class="mt-2"/>
                                </div>
                            @else
                                @foreach ($registration->fees as $index => $fee)
                                    @if ($fees[$fee->id][0] == TRUE)
                                        <div class="col-span-6 flex items-center justify-between">
                                            <p class="text-gray-600 text-base">{{ $fee->category->name ?? 'N/A' }}</p>
                                            <p class="text-black font-semibold">{{ $fee->getFormattedPriceAttribute($fee->formatTwoDecimalPlaces($fee->pivot->total_fee)) ?? 'N/A' }}</p>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-span-6 flex items-center justify-between">
                                    <p class="text-gray-600 text-base">Additional Fee</p>
                                    <p class="text-black font-semibold">{{ $assessment->getFormattedPriceAttribute($additional) ?? 'N/A' }}</p>
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
                                    <textarea readonly class="mt-2">{{ $assessment->remarks ?? 'N/A' }}</textarea>
                                </div>
                                @if ($isUnifastBeneficiary)
                                    <div class="col-span-6 flex items-center justify-between">
                                        <p class="text-gray-600 text-base">Unifast Beneficiary</p>
                                        <p class="text-black font-semibold uppercase">{{ $isUnifastBeneficiary == true ? 'Yes' : 'No' }}</p>
                                    </div>
                                @endif
                                <div class="col-span-6 flex justify-between items-center font-bold">
                                    <p class="text-lg text-black">Total Amount</p>
                                    <p class="text-lg text-green-500">{{ $assessment->getFormattedPriceAttribute($grandTotal) ?? 'N/A' }}</p>
                                </div>
                                <div x-data="{ open: false }" x-show="{{! $isUnifastBeneficiary}}" x-cloak class="col-span-6">
                                    <div class="w-full flex items-center justify-between">
                                        <p class="text-gray-600 text-base">Downpayment {{$this->setting->downpayment ?? 'N/A'}}</p>
                                        <p class="text-black font-semibold">{{ $assessment->getFormattedPriceAttribute($downpayment) ?? 'N/A' }}</p>
                                    </div>

                                    <div class="w-full mt-4">
                                        <x-jet-label value="{{ __('Payment Type') }}"/>
                                        <fieldset name="payment_type" class="w-100 flex items-center gap-6 mt-2">
                                            <label @click="open = true" for="full" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                                                <input @click="open = true" wire:model="isFullPayment" wire:loading.attr="disabled" id="full" type="radio" value="1" name="payment_type" class="mr-2 outline-none">
                                                <label for="full" class="cursor-pointer">Full Payment</label>
                                            </label>
                                            <label @click="open = false" for="partial" class="w-1/2 border border-gray-300 hover:border-indigo-400 rounded-md p-2 flex items-center cursor-pointer">
                                                <input @click="open = false" wire:model="isFullPayment" wire:loading.attr="disabled" id="partial" type="radio" value="0" name="payment_type" class="mr-2">
                                                <label for="partial" class="cursor-pointer">Partial Payment</label>
                                            </label>
                                        </fieldset>
                                        <x-jet-input-error for="isFullPayment" class="mt-2"/>
                                    </div>

                                    <div class="w-full grid grid-cols-6 gap-6 mt-4">
                                        <div class="col-span-6 flex items-center justify-between">
                                            <p class="text-gray-600 text-base">Amount Due</p>
                                            <p wire:target="isFullPayment" wire:loading.class="hidden" class="text-black font-semibold">{{ $assessment->getFormattedPriceAttribute($amountDue) ?? 'N/A' }}</p>
                                            <p wire:target="isFullPayment" wire:loading.class.remove="hidden" class="hidden"><x-icons.loading-icon/></p>
                                        </div>

                                        <div :class="{'col-span-6': open, '': ! open }" class="col-span-3">
                                            <x-jet-label x-show="! open" x-cloak for="first_due_date" value="{{ __('Midterm') }}" />
                                            <x-jet-input wire:model.defer="first_due_date" wire:loading.attr="disabled" id="first_due_date" type="date" autocomplete="first_due_date"/>
                                            <x-jet-input-error for="first_due_date" class="mt-2"/>
                                        </div>

                                        <div x-show="! open" x-cloak class="col-span-3">
                                            <x-jet-label for="first_due_date" value="{{ __('Finals') }}" />
                                            <x-jet-input wire:model.defer="second_due_date" wire:loading.attr="disabled" id="first_due_date" type="date" autocomplete="first_due_date"/>
                                            <x-jet-input-error for="second_due_date" class="mt-2"/>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endcan
                    @endisset
                </x-slot>

                <x-slot name="actions">
                    @can ('action', $registration)
                        @isset ($registration->assessment)
                            <a class="w-full text-white py-2 rounded-md bg-indigo-500 hover:bg-indigo-800 flex items-center justify-center" href="{{ route('user.payment.index', ['registration' => $this->registration]) }}">
                                <span>Proceed to Payment</span>
                                <x-icons.right-arrow-icon />
                            </a>
                        @else
                            @if (! isset($grandTotal))
                                @can ('finalize', $registration)
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
                                <div class="w-full flex flex-col md:flex-row md:items-center md:gap-6">
                                    <x-jet-button wire:click="save" wire:target="save" class="w-full md:w-1/2 bg-green-500 hover:bg-green-600 flex items-center justify-center">
                                        <x-icons.fee-icon/>
                                        <span class="mx-2">{{ __('PLACE FEES') }}</span>
                                    </x-jet-button>
                                    <x-jet-button wire:click="cancel" wire:target="cancel" class="w-full md:w-1/2 text-indigo-500 border-indigo-500 bg-white hover:bg-gray-200 flex items-center justify-center my-2">
                                        <x-icons.reject-icon/>
                                        <span class="mx-2">{{ __('CANCEL') }}</span>
                                    </x-jet-button>
                                </div>
                            @endif
                        @endisset
                    @endcan
                </x-slot>
            </x-jet-form-section>
        </div>
        <x-jet-section-border/>
    @endif
</div>
