<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function query()
    {
        return Transaction::query()->whereKey($this->transactions);
    }

    public function headings(): array
    {
        return [
            'transaction id',
            'paypal transaction id',
            'datetime',
            'paypal account name',
            'paypal account email',
            'verification',
            'amount',
            'running_balance',
            'student id',
            'student name',
            'registration id',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->custom_id ?? 'N/A',
            $transaction->paypal_transaction_id ?? 'N/A',
            $transaction->created_at->timezone('Asia/Manila')->format('M. d, Y g:i:s A') ?? 'N/A',
            $transaction->paypal_name ?? 'N/A',
            $transaction->paypal_email ?? 'N/A',
            $transaction->paypal_is_verified_text ?? 'N/A',
            $transaction->getFormattedPriceAttribute($transaction->amount) ?? 'N/A',
            $transaction->getFormattedPriceAttribute($transaction->running_balance) ?? 'N/A',
            $transaction->registration->student->custom_id ?? 'N/A',
            $transaction->registration->student->user->person->short_full_name ?? 'N/A',
            $transaction->registration->custom_id ?? 'N/A',
        ];
    }
}
