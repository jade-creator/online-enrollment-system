<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\Transaction;
use App\Services\Assessment\AssessmentService;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public Registration $registration;
    public int $amount;
    public int $total;
    public string $name;
    public string $email;
    public string $notificationSenderId;

    public function __construct(Registration $registration, int $amount, string $name, string $email, string $notificationSenderId = '')
    {
        $this->registration = $registration;
        $this->amount = $amount;
        $this->name = $name;
        $this->email = $email;
        $this->notificationSenderId = $notificationSenderId;
    }

    public function createTransaction(string $status = '') : Transaction
    {
        $transaction = Transaction::create([
            'amount' => $this->amount,
            'running_balance' => $this->registration->assessment->balance,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $status,
            'registration_id' => $this->registration->id,
            'collector_id' => empty($this->notificationSenderId) ? null : $this->notificationSenderId,
        ]);

        (new SendNotification())->dispatch(
            $this->notificationSenderId,
            $this->registration->student->user->id,
            'PAYMENT '.$transaction->status.'! Amount: '.$transaction->getFormattedPriceAttribute($transaction->amount)
        );

        return $transaction;
    }

    public function compute() : int
    {
        if (is_null($this->registration->assessment)) throw new \Exception('Assessment not found!');

        if ($this->registration->assessment->balance < $this->amount) throw new \Exception('Payment Amount Exceeds!');

        return $this->registration->assessment->balance - $this->amount;
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
}
