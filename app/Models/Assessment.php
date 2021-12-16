<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'registration_id',
        'additional',
        'isPercentage',
        'discount_amount',
        'grand_total',
        'balance',
        'downpayment',
        'amount_due',
        'remarks',
        'isUnifastBeneficiary',
        'isFullPayment',
        'downpayment_due_date',
        'first_due_date',
        'second_due_date',
        'approver_id',
    ];

    protected $casts = [
        'isUnifastBeneficiary' => 'boolean',
        'isFullPayment' => 'boolean',
    ];

    protected $attributes = [
        'isUnifastBeneficiary' => false,
        'isFullPayment' => false,
    ];

    public function getIsDownpaymentPaidAttribute()
    {
        if ($this->balance === $this->grand_total) return false;

        return true;
    }

    public function getActiveDueDateAttribute()
    {
        if ($this->balance == 0) return null;

        //return downpayment due
        if (! $this->isDownpaymentPaid) return $this->downpayment_due_date;

        //if partial payment check if first_amount_due is paid.
        if (! $this->isFullPayment
            && $this->paidAmount > $this->downpayment) return $this->second_due_date;

        //else return first_due_date payment
        return $this->first_due_date;
    }

    public function getCurrentDate() { return
        \Carbon\Carbon::parse(now())->timezone('Asia/Manila')->format('Y-m-j');
    }

    public function getIsActiveDueDatePayableAttribute()
    {
        $now = $this->getCurrentDate();

        switch ($this->activeDueDate) {
            case $this->downpayment_due_date:
                return $now <= $this->downpayment_due_date;
            break;

            case $this->first_due_date:
                if ($now > $this->downpayment_due_date
                    && $now <= $this->first_due_date) return true;

                return false;
            break;

            case $this->second_due_date:
                if ($this->isFullPayment) return null;

                if ($now > $this->first_due_date
                    && $now <= $this->second_due_date) return true;

                return false;
            break;

            default:
                return null;
            break;
        }
    }

    public function getDueDateOnLateAttribute()
    {
        $now = $this->getCurrentDate();

        if ($this->activeDueDate == $this->downpayment_due_date
            && $now > $this->activeDueDate) return $this->downpayment_due_date;

        if ($this->activeDueDate == $this->first_due_date
            && $now > $this->activeDueDate) return $this->first_due_date;

        if ($this->activeDueDate == $this->second_due_date
            && $now > $this->activeDueDate) return $this->second_due_date;

        return null;
    }

    public function getAmountToPayAttribute()
    {
        if ($this->balance == 0) return 0;

        if (! $this->isDownpaymentPaid) return $this->downpayment;

        //just in case there's remaining in the downpayment
        if ($this->paidAmount < $this->downpayment) return $this->downpayment - $this->paidAmount;

        return $this->amount_due;
    }

    public function getPaymentTypeAttribute() { return
        $this->attributes['isFullPayment'] == true ? 'Full Payment' : 'Partial Payment';
    }

    public function getIsUnifastRecepientAttribute() { return
        $this->attributes['isUnifastBeneficiary'] == true ? 'Yes' : 'No';
    }

    public function getPaidAmountAttribute() { return
        $this->grand_total - $this->balance;
    }

    public function getAmountDueAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function getDownpaymentAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function getBalanceAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function getGrandTotalAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function getAdditionalAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function setAmountDueAttribute($value)
    {
        $this->attributes['amount_due'] = $this->addTwoZeroDigits($value);
    }

    public function setDownpaymentAttribute($value)
    {
        $this->attributes['downpayment'] = $this->addTwoZeroDigits($value);
    }

    public function setBalanceAttribute($value)
    {
        $this->attributes['balance'] = $this->addTwoZeroDigits($value);
    }

    public function setGrandTotalAttribute($value)
    {
        $this->attributes['grand_total'] = $this->addTwoZeroDigits($value);
    }

    public function setAdditionalAttribute($value)
    {
        $this->attributes['additional'] = $this->addTwoZeroDigits($value);
    }

    public function getDiscountTypeAttribute() { return
        $this->attributes['isPercentage'] ? 'Percentage' : 'Amount';
    }

    public function approver() { return
        $this->belongsTo(User::class, 'approver_id');
    }

    public function registration() { return
        $this->belongsTo(Registration::class);
    }
}
