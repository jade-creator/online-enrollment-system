<div class="col-span-6 grid grid-cols-6 z-10">
    @if ($totalAmount > 0 && $totalAmount <= $totalBalance)
        <div class="flex items-center justify-end col-span-6 text-sm mb-2">
            <button wire:click.prevent="$set('totalAmount', 0)" class="hover:text-gray-400 underline outline-none focus:outline-none bg-transparent">Change Amount</button>
        </div>

        <div class="col-span-6 flex items-center justify-between">
            <label>Amount</label>
            <span>{{ $registration->assessment->getFormattedPriceAttribute($totalAmount) ?? '--' }}</span>
        </div>

        <button wire:click.prevent="payConfirm"
            @if (auth()->user()->can('cash', \App\Models\Transaction::class))
                class="bg-indigo-500 hover:bg-indigo-700 col-span-6 mt-4 py-2.5 text-white text-lg font-semibold rounded-md flex items-center justify-center"
            @else
                class="bg-indigo-500 hover:bg-indigo-700 col-span-6 mt-4 py-2.5 text-white text-lg font-semibold rounded-md flex items-center justify-center cursor-not-allowed"
                disabled="disabled"
                title="Please contact us at {{$school_email}}"
            @endif>
            <img src="{{$school_profile_photo_path ?? ''}}" class="w-6 h-6 bg-white rounded-full mx-2"/>
            <span class="block">Cash</span>
        </button>

        <div id="paypal-button-container" class="col-span-6 mt-4"></div>
    @else
        <form wire:submit.prevent="enterAmount" class="col-span-6 grid grid-cols-6">
            <input wire:model.defer="totalAmount" type="number" min="0" max="{{$totalBalance}}" autofocus class="col-span-4">
            <button type="submit" class="md:text-sm py-2.5 ml-2 bg-indigo-500 font-black rounded-md text-white col-span-2 hover:bg-indigo-700">
                Enter Amount
            </button>

            <div class="col-span-6">
                <x-jet-input-error for="totalAmount" class="mt-2"/>
            </div>
        </form>
    @endif

    <script src="https://www.paypal.com/sdk/js?client-id={{$clientId}}&currency={{$currencyCode}}&locale={{$locale}}"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "{{$totalAmount}}"
                        }
                    }],
                    application_context: {
                        shipping_preference: "{{$shippingPreference}}"
                    }
                });
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                    // This function shows a transaction success message to your buyer.
                    window.livewire.emit('pay', details.payer.name.given_name + ' ' + details.payer.name.surname, details.payer.email_address, details.status);
                });
            }
        }).render('#paypal-button-container');
    </script>
</div>
