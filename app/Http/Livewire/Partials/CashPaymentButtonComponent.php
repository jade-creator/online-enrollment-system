<?php

namespace App\Http\Livewire\Partials;

use App\Models;
use App\Services\PaymentService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CashPaymentButtonComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Registration $registration;
    public ?Models\Transaction $transaction = null;
    public bool $disableButton = true;

    protected $listeners = ['cash'];

    public function render() { return
        view('livewire.partials.cash-payment-button-component');
    }

    public function cash()
    {
        $paymentService = new PaymentService($this->registration, $this->registration->student->user->person->shortFullName,
            $this->registration->student->user->email, auth()->user()->id);

        $newTransaction = new Models\Transaction();

        try {
            $this->authorize('cash', Models\Transaction::class);

            if (is_null($this->transaction)) {
                $paymentService->store($newTransaction->completed);
            } else {
                $paymentService->update($this->transaction, $newTransaction->completed);
            }

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'PAYMENT '.$newTransaction->completed,
            ]);

            return redirect(route('user.payment.index', $this->registration));
        } catch (\Exception $e) {
            $paymentService->createTransaction($newTransaction->failed);
            $this->emitUp('sessionFlashAlert', 'alert', $this->errorType, $e->getMessage());
        }
    }

    public function payConfirm()
    {
        if (filled($this->registration->assessment->dueDateOnLate)
            && is_null($this->transaction)) return $this->error("Please wait for the penalty to be issued.");

        return $this->confirm('cash', 'Are you sure? The student will be notified once the transaction is done.');
    }
}
