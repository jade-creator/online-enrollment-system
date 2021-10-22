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
        'remarks',
    ];

    public function getPaidAmountAttribute()
    {
        $value = $this->formatTwoDecimalPlaces($this->attributes['grand_total'] - $this->attributes['balance']);
        return $this->getFormattedPriceAttribute($value);
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

    public function addTwoZeroDigits($value) { return
        $value * 100;
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
