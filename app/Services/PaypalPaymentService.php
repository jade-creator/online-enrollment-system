<?php

namespace App\Services;

use App\Models\Registration;
use App\Models\Transaction;

class PaypalPaymentService
{
    /**
     * @throws \Exception
     */
    public function store(Registration $registration, $paypalTransactionId, float $amount = 0) : Registration
    {
        if (is_null($registration->assessment)) throw new \Exception('Assessment not found!');
        if ($registration->assessment->balance < $amount) throw new \Exception('Payment Amount Exceeds!');

        $total = $registration->assessment->balance - $amount;
        $registration->assessment->balance = $total;
        $registration->assessment->update();

        $registration->transactions()->create([
            'paypal_transaction_id' => $paypalTransactionId,
            'amount' => $amount,
            'running_balance' => $total,
        ]);

        return $registration;
    }

    public function failed(Registration $registration, float $amount = 0) : Registration
    {
        if (is_null($registration->assessment)) throw new \Exception('Assessment not found!');
        if ($registration->assessment->balance < $amount) throw new \Exception('Payment Amount Exceeds!');

        $registration->transactions()->create([
            'amount' => $amount,
            'running_balance' => $registration->assessment->balance,
        ]);

        return $registration;
    }
}
