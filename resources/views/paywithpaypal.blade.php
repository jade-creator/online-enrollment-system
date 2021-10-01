<x-app-layout>
    <div class="w-full">
        <div class="h-content w-full py-8 px-8">
            <x-table.title tableTitle="Payment"></x-table.title>
            <form class="grid place-items-center" method="POST" id="payment-form" role="form" action="{!! URL::route('student.paypal') !!}" >
                {{ csrf_field() }}

                <div class="w-4/5 sm:w-1/2 flex flex-col space-y-4">
                    <div>
                        <label for="registrationId">Registration ID:</label>
                        <input id="registrationId" type="text" name="registrationId" value="{{ $registration->id }}" readonly autofocus>
                    </div>
                    
                    <div>
                        <label for="total">Grand Total:</label>
                        <input id="total" type="number" name="total" value="{{ $registration->assessment->grand_total }}" readonly autofocus>
                    </div>
                    
                    <div>
                        <label for="balance">Balance</label>
                        <input id="balance" type="number" name="balance" value="{{ $registration->assessment->balance }}" readonly autofocus>
                    </div>
                    
                    <div>
                        <label for="amount">Enter Amount</label>
                        <input id="amount" type="number" name="amount" value="{{ old('amount') }}" min="0" autofocus>
                    </div>

                    <button type="submit" class="text-white font-bold py-2 px-4 rounded-md bg-indigo-500 hover:bg-indigo-600 flex items-center justify-center">
                        Pay with Paypal
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
