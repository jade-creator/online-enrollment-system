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
        'first_due_date',
        'second_due_date',
    ];

    protected $casts = [
        'isUnifastBeneficiary' => 'boolean',
        'isFullPayment' => 'boolean',
    ];

    protected $attributes = [
        'isUnifastBeneficiary' => false,
        'isFullPayment' => false,
    ];

    public function getIsUnifastRecepientAttribute() { return
        $this->attributes['isUnifastBeneficiary'] == true ? 'Yes' : 'No';
    }

    public function getPaidAmountAttribute()
    {
        $value = $this->formatTwoDecimalPlaces($this->attributes['grand_total'] - $this->attributes['balance']);
        return $this->getFormattedPriceAttribute($value);
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

    public function registration() { return
        $this->belongsTo(Registration::class);
    }
}
