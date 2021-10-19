<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'registration_id',
        'custom_id',
        'paypal_transaction_id',
        'amount',
        'running_balance',
    ];

    public $with = [
        'registration.assessment'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->custom_id = IdGenerator::generate(['table' => 'transactions', 'field' => 'custom_id', 'length' => 10, 'prefix' =>'TRN-']);
        });
    }

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
                return $query->where('id', 'LIKE', $search)
                    ->orWhere('registration_id', 'LIKE', $search)
                    ->orWhere('custom_id', 'LIKE', $search);
            });
    }
}
