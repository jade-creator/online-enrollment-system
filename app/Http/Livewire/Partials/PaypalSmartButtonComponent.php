<?php

namespace App\Http\Livewire\Partials;

use App\Models\Registration;
use App\Models\Transaction;
use App\Services\PaymentService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PaypalSmartButtonComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public Registration $registration;
    public string $clientId = '', $currencyCode = '', $shippingPreference = '', $locale = '';
    public int $totalAmount = 0, $totalBalance = 0;

    protected $listeners = ['pay', 'cash'];

    public function rules()
    {
        return [
            'totalAmount' => ['required', 'numeric', 'min:1', 'lte:totalBalance'],
            'totalBalance' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function mount()
    {
        $paypalConfiguration = \Config::get('paypal');

        $this->fill([
            'clientId' => $paypalConfiguration['client_id'],
            'currencyCode' => $paypalConfiguration['currency_code'],
            'shippingPreference' => $paypalConfiguration['shipping_preference'],
            'locale' => $paypalConfiguration['locale']
        ]);
    }

    public function render()
    {
        return view('livewire.partials.paypal-smart-button-component');
    }

    public function cash()
    {
        return $this->pay($this->registration->student->user->person->shortFullName, $this->registration->student->user->email,
            'COMPLETED', auth()->user()->id);
    }

    public function payConfirm()
    {
        try {
            $this->authorize('cash', Transaction::class);

            $this->confirm('cash', 'Are you sure? The student will be notified once the transaction is done.');
        } catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', $this->errorType, $e->getMessage());
        }
    }

    public function pay(string $name = '', string $email = '', string $status = '', string $notificationSenderId = '')
    {
        $paymentService = new PaymentService($this->registration, $this->totalAmount, $name, $email, $notificationSenderId);

        try {
            $this->registration = $paymentService->store($status);

            $this->emitUp('sessionFlashAlert', 'alert', $this->successType, 'Payment Successful!');
        } catch (\Exception $e) {
            $paymentService->createTransaction('FAILED');
            $this->emitUp('sessionFlashAlert', 'alert', $this->errorType, $e->getMessage());
        }
    }

    public function enterAmount()
    {
        $this->validate();
    }
}
