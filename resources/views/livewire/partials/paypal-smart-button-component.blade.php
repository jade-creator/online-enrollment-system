<div class="col-span-6 grid grid-cols-6 z-10">
    <livewire:partials.cash-payment-button-component
        :registration="$registration"
        :transaction="$transaction"
        :disableButton="$disableButton"
        key="'cash-payment-button-component-'{{now()}}"/>

    <div id="paypal-button-container" class="col-span-6 mt-4"></div>

    <script src="https://www.paypal.com/sdk/js?client-id={{$clientId}}&currency={{$currencyCode}}&locale={{$locale}}"></script>
    <script>
        paypal.Buttons({
            onInit: function(data, actions) {
                if ({{$disableButton ? 'true' : 'false'}}) {
                    actions.disable()

                    if ({{filled($transaction) ? 'true' : 'false'}}) { actions.enable() }
                }
            },
            createOrder: function(data, actions) {
                 // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "{{$value}}"
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
