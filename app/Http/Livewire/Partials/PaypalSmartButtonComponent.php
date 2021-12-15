<?php

namespace App\Http\Livewire\Partials;

use App\Models;
use App\Services\PaymentService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PaypalSmartButtonComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Registration $registration;
    public ?Models\Transaction $transaction = null;
    public string $clientId = '', $currencyCode = '', $shippingPreference = '', $locale = '';
    public bool $disableButton = true;

    protected $listeners = ['pay'];

    public function mount()
    {
        $paypalConfiguration = \Config::get('paypal');

        $this->fill([
            'clientId' => $paypalConfiguration['client_id'],
            'currencyCode' => $paypalConfiguration['currency_code'],
            'shippingPreference' => $paypalConfiguration['shipping_preference'],
            'locale' => $paypalConfiguration['locale'],
        ]);
    }

    public function render() { return
        view('livewire.partials.paypal-smart-button-component', [
            'value' => is_null($this->transaction) ? $this->registration->assessment->amountToPay
                : $this->transaction->charge,
        ]);
    }

    public function pay(string $name = '', string $email = '', string $status = '')
    {
        $paymentService = new PaymentService($this->registration, $name, $email);

        try {
            if (is_null($this->transaction)) {
                $paymentService->store($status);
            } else {
                $paymentService->update($this->transaction, $status);
            }

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'PAYMENT '.$status,
            ]);

            return redirect(route('user.payment.index', $this->registration));
        } catch (\Exception $e) {
            $paymentService->createTransaction((new Models\Transaction())->failed);
            $this->emitUp('sessionFlashAlert', 'alert', $this->errorType, $e->getMessage());
        }
    }
}
