<?php

namespace App\Http\Livewire\Forms\Payment;

use App\Models\Registration;
use App\Traits\WithSweetAlert;
use Livewire\Component;

class PaymentIndexComponent extends Component
{
    use WithSweetAlert;

    public Registration $registration;

    protected $listeners = ['sessionFlashAlert'];

    public function render()
    {
        return view('livewire.forms.payment.payment-index-component');
    }
}
