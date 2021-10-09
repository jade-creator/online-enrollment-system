<?php

namespace App\Http\Livewire\Student\Payment;

use App\Models\Assessment;
use App\Models\Registration;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public string $registrationId = '';
    public $balance = 0;
    public bool $addingPayment = false;

    public function rules()
    {
        return ['registrationId' => ['required']];
    }

    protected $listeners = [ 'modalAddingPayment' => 'toggleModalAddingPayment'];

    public function render() { return
        view('livewire.student.payment.payment-add-component');
    }

    public function getRegistrationsProperty() { return
        Registration::filterByStudent(auth()->user()->student->id)
            ->has('assessment')
            ->where('status_id', 4)
            ->get(['id', 'custom_id']);
    }

    public function save()
    {
        $this->validate();
        return $this->redirect(route('student.paywithpaypal', ['registrationId' => $this->registrationId]));
    }

    public function toggleModalAddingPayment() {
        $this->addingPayment = ! $this->addingPayment;
    }

    public function updatedRegistrationId($value)
    {
        if (empty($value)) return $this->reset('balance');

        $registration = Registration::with('assessment')->where('custom_id', $value)->first();
        $this->balance = $registration->assessment->balance;
    }
}
