<?php

namespace App\Observers;

use App\Models\Registration;
use App\Models\Transaction;
use App\Services\Registration\RegistrationStatusService;

class TransactionObserver
{
    public function creating(Transaction $transaction)
    {
        $transaction->collector_id = auth()->user()->role->name == 'student' ? null : auth()->user()->id;
    }

    public function enroll(Transaction $transaction) : ?Registration
    {
        if ($transaction->status !== $transaction->completed
            || ! $transaction->registration()->exists()) return null;

        if ($transaction->registration->released_at
            || $transaction->registration->status->name === $transaction->registration->status->enrolled) return null;

        return (new RegistrationStatusService())->enroll($transaction->registration);
    }

    public function created(Transaction $transaction) {
        $this->enroll($transaction);
    }

    public function updated(Transaction $transaction) {
        $this->enroll($transaction);
    }
}
