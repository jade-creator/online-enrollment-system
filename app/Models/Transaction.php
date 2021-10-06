<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends BaseModel
{
    protected $fillable = [
        'registration_id',
        'amount',
        'running_balance',
    ];

    public $with = [
        'registration.assessment'
    ];

    public function scopefilterByStudent($query, $studentId)
    {
        return $query->when(filled($studentId), function ($query) use ($studentId) {
            return $query->whereHas('registration', function ($query) use ($studentId) {
                return $query->where('student_id', $studentId);
            });
        });
    }

    public function getFormattedPriceAttribute($value) { return
        'PHP '.number_format($value, 2, '.', ',');
    }

    public function formatTwoDecimalPlaces($value) {
        $value = $value / 100;
        return number_format((float)$value, 2, '.', '');
    }

    public function getRunningBalanceAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function getAmountAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function addTwoZeroDigits($value) { return
        $value * 100;
    }

    public function setRunningBalanceAttribute($value)
    {
        $this->attributes['running_balance'] = $this->addTwoZeroDigits($value);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $this->addTwoZeroDigits($value);
    }

    public function registration() { return
        $this->belongsTo(Registration::class);
    }

    public static function search(?string $search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                    ->where('id', 'LIKE', $search)
                    ->orWhere('registration_id', 'LIKE', $search);
            });
    }
}
