<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\Transaction;
use App\Services\Assessment\AssessmentService;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public Registration $registration;
    public string $name, $email, $notificationSenderId;
    public string $completed = 'COMPLETED', $failed = 'FAILED';
    public $transactionAmount = 0;

    public function __construct(Registration $registration, string $name = '', string $email = '', string $notificationSenderId = '')
    {
        $this->registration = $registration;
        $this->transactionAmount = $registration->assessment->amountToPay;
        $this->name = $name;
        $this->email = $email;
        $this->notificationSenderId = $notificationSenderId;
    }

    public function sendNotification(Transaction $transaction) : void
    {
        (new SendNotification())->dispatch(
            $this->notificationSenderId,
            $this->registration->student->user->id,
            'PAYMENT '.$transaction->status.'! Amount: '.$transaction->getFormattedPriceAttribute($transaction->amount)
        );
    }

    public function createTransaction(string $status = '', float $penalty = 0) : Transaction
    {
        $transaction = Transaction::create([
            'amount' => $this->transactionAmount,
            'running_balance' => $this->registration->assessment->balance,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $status,
            'penalty' => $penalty,
            'registration_id' => $this->registration->id,
        ]);

        $this->sendNotification($transaction);

        return $transaction;
    }

    public function compute() : int
    {
        if (is_null($this->registration->assessment)) throw new \Exception('Assessment not found!');

        if ($this->registration->assessment->balance < $this->transactionAmount) throw new \Exception('Payment Amount Exceeds!');

        return $this->registration->assessment->balance - $this->transactionAmount;
    }

    public function store(string $status = '') : Registration
    {
        $this->registration->assessment->balance = $this->compute();

        DB::transaction( function() use ($status) {
            $assessment = (new AssessmentService())->store($this->registration, $this->registration->assessment);
            $transaction = $this->createTransaction($status);
        });

        return $this->registration;
    }

    public function update(Transaction $transaction, string $status = '') : Transaction
    {
        DB::transaction( function() use ($transaction, $status) {
            $transaction->update([
                'running_balance' => $this->compute(),
                'status' => $status,
            ]);

            $this->registration->assessment->balance = $this->compute();

            $assessment = (new AssessmentService())->store($this->registration, $this->registration->assessment);

            $this->sendNotification($transaction);
        });

        return $transaction;
    }
}
