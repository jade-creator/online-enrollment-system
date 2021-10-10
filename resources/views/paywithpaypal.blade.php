<x-app-layout>
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 pt-12">
        <div class="w-full pl-0 md:pl-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-jet-section-title>
                    <x-slot name="title">Add Payment</x-slot>
                    <x-slot name="description">Please fill out the form with correct data.</x-slot>
                </x-jet-section-title>

                <div class="mt-5 md:mt-0 md:col-span-3">
                    <form class="grid place-items-center" method="POST" id="payment-form" role="form" action="{!! URL::route('student.paypal') !!}" >
                    {{ csrf_field() }}
                        <div class="w-full px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <label for="registrationId">Registration ID:</label>
                                    <input id="registrationId" type="text" name="registrationId" value="{{ $registration->custom_id }}" readonly autofocus>
                                </div>

                                <div class="col-span-6">
                                    <label for="total">Grand Total:</label>
                                    <input id="total" type="number" name="total" value="{{ $registration->assessment->grand_total }}" readonly autofocus>
                                </div>

                                <div class="col-span-6">
                                    <label for="balance">Balance</label>
                                    <input id="balance" type="number" name="balance" value="{{ $registration->assessment->balance }}" readonly autofocus>
                                </div>

                                <div class="col-span-6">
                                    <label for="amount">Enter Amount</label>
                                    <input id="amount" type="number" name="amount" value="{{ old('amount') }}" min="0" autofocus>
                                    <x-jet-input-error for="amount" class="mt-2"/>
                                </div>

                                <div class="col-span-6">
                                    <button type="submit" class="text-white font-bold py-2 px-4 rounded-md bg-indigo-500 hover:bg-indigo-600 flex items-center justify-center">
                                        Pay with Paypal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <x-jet-section-border/>
        </div>
    </div>
</x-app-layout>
