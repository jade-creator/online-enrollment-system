<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_id',
        'additional',
        'isPercentage',
        'discount_amount',
        'grand_total',
        'balance',
        'remarks',
    ];

    public function getFormattedPriceAttribute($value) { return
        'PHP '.number_format($value, 2, '.', ',');
    }

    public function formatTwoDecimalPlaces($value) {
        $value = $value / 100;
        return number_format((float)$value, 2, '.', '');
    }

    public function getBalanceAttribute($value) { return
        $this->attributes['balance'] = $this->formatTwoDecimalPlaces($value);
    }

    public function getGrandTotalAttribute($value) { return
        $this->attributes['grand_total'] = $this->formatTwoDecimalPlaces($value);
    }

    public function getAdditionalAttribute($value) { return
        $this->attributes['additional'] = $this->formatTwoDecimalPlaces($value);
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
