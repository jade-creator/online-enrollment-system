<?php

namespace App\Http\Livewire\Forms\Payment;

use App\Models;
use App\Services\PaymentService;
use App\Traits\WithSweetAlert;
use Livewire\Component;

class PaymentIndexComponent extends Component
{
    use WithSweetAlert;

    public Models\Registration $registration;
    public ?Models\Transaction $transactionPenalty = null;
    public Models\Setting $setting;

    protected $listeners = [
        'sessionFlashAlert',
        'save',
    ];

    public function mount()
    {
        $this->transactionPenalty = new Models\Transaction();

        $this->fill([
            'transactionPenalty' => $this->registration->transactions()
                ->where('status', 'LIKE', '%'.$this->transactionPenalty->pending.'%')
                ->where('penalty', '!=', 0)
                ->first(),
            'setting' => Models\Setting::get()->first(),
        ]);
    }

    public function render()
    {
        return view('livewire.forms.payment.payment-index-component', [
            'disableButton' => !(is_null($this->registration->assessment->dueDateOnLate)
                && $this->registration->assessment->isActiveDueDatePayable),
        ]);
    }

    public function checkDateStatus($date)
    {
        if ($date < $this->registration->assessment->activeDueDate 
            || is_null($this->registration->assessment->activeDueDate)) {
            return 'line-through';
        } else if ($date == $this->registration->assessment->activeDueDate
            && $this->registration->assessment->isActiveDueDatePayable) {
            return 'text-green-500';
        } else if ($date == $this->registration->assessment->dueDateOnLate) {
            return 'text-red-500';
        } else {
            return '';
        }
    }

    public function computePenalty() { return
        $this->setting->penalty_percentage / 100 * $this->registration->assessment->amountToPay;
    }

    public function save()
    {
        try {
            (new PaymentService(
                $this->registration,
                $this->registration->student->user->person->shortFullName,
                $this->registration->student->user->email,
                auth()->user()->id,
            ))->createTransaction((new Models\Transaction())->pending, $this->computePenalty());

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'Penalty has been issued.',
            ]);

            return redirect(route('user.payment.index', $this->registration));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function issue()
    {
        if (filled($this->transactionPenalty)) return $this->error("There's still a pending penalty.");

        return $this->confirm('save', 'Penalty: '.$this->setting->penalty
            .' of the amount to pay will be added. A total of '
            .$this->registration->assessment->getFormattedPriceAttribute($this->computePenalty()));
    }
}
