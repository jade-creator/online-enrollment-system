<x-app-layout>
    <div class="w-full mx-auto pt-8">
        <div class="w-full pl-0 md:pl-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-3 p-4 md:p-8 grid grid-cols-6">
                    <div class="col-span-6 xl:col-span-4">
                        <x-jet-label class="block md:hidden font-extrabold text-xl">{{ $registration->custom_id ?? 'N/A' }}</x-jet-label>

                        <div class="my-2">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <div class="flex items-start">
                                    <img class="border border-gray-200 mt-1 h-28 w-28 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="photo"/>
                                    <div class="px-6 py-2 flex flex-col text-2xl w-full">
                                        <div class="flex items-center justify-between w-full">
                                            <h2 class="font-extrabold">{{ auth()->user()->person->short_full_name }}</h2>
                                            <p class="hidden md:block text-gray-500 text-md">{{ $registration->custom_id ?? 'N/A' }}</p>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1 tracking-widest">{{ $registration->classification }}</p>

                                        <p class="text-sm text-gray-600 mt-1 tracking-widest">{{ $registration->prospectus->program->program ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $registration->prospectus->level->level ?? 'N/A' }} - {{ $registration->prospectus->term->term ?? 'N/A' }}</p>

                                        <div class="my-6">
                                            <a href="{{ route('pre.registration.view', $registration->id) }}">
                                                <p class="hover:text-indigo-500 underline text-sm text-gray-600">View Details</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="w-full md:w-11/12 border-t border-gray-200 mb-10"></div>
                    </div>

                    <form class="col-span-6 xl:col-span-2 w-full md:w-8/12 lg:w-1/2 xl:w-full grid place-items-center" method="POST" id="payment-form" role="form" action="{!! URL::route('student.paypal') !!}" >
                    {{ csrf_field() }}
                        <div class="w-full px-4 py-5 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md bg-white">
                            <div>
                                <p class="uppercase font-extrabold text-2xl font-mono">SUMMARY</p>
                            </div>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 flex items-center justify-between pt-4">
                                    <label class="flex items-center"><span>Subtotal</span> <span class="bg-black text-white font-black text-xs rounded-full px-1.5 mx-2">?</span></label>
                                    <span>{{ $registration->totalFees() ?? '--' }}</span>
                                </div>

                                <div class="col-span-6 flex items-center justify-between">
                                    <label>Additional</label>
                                    <span>{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->additional) ?? '--' }}</span>
                                </div>

                                <div class="col-span-6 flex items-center justify-between">
                                    <label>Discount @if (filled($registration->assessment->isPercentage))
                                        {{$registration->assessment->discount_type ?? ''}} @endif</label>
                                    <span>
                                        @if (filled($registration->assessment->isPercentage))
                                            {{$registration->assessment->discount_amount}}
                                        @else
                                            --
                                        @endif
                                    </span>
                                </div>

                                <div class="col-span-6 flex items-center justify-between">
                                    <label>Grand Total</label>
                                    <span>{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->grand_total) ?? '--' }}</span>
                                </div>

                                <div class="col-span-6">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>

                                <div class="col-span-6 flex items-center justify-between">
                                    <label class="text-black font-mono upppercase">RUNNING BALANCE</label>
                                    <input id="balance" type="hidden" name="balance" value="{{ $registration->assessment->balance ?? 0 }}" min="0" class="hidden">
                                    <span>{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->balance) ?? '--' }}</span>
                                </div>

                                <div class="col-span-6">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>

                                <div class="col-span-6 grid grid-cols-6">
                                        <input id="amount" type="number" name="amount" value="{{ old('amount') }}" min="0" autofocus class="col-span-4">
                                        <button type="submit" class="md:text-sm py-2.5 ml-2 bg-black font-black rounded-md text-white col-span-2">
                                            Enter Amount
                                        </button>
                                </div>

                                <div class="col-span-6">
                                    <x-jet-input-error for="amount" class="mt-2"/>
                                </div>
                            </div>
                        </div>
                        <div class="my-6 text-gray-400 text-md flex items-center justify-center">
                            <x-icons.lock-icon/>
                            <span>Secured payment with <span class="font-bold text-indigo-500">Pay</span><span class="font-bold text-blue-400">Pal</span></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
