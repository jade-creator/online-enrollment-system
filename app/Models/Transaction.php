<?php

namespace App\Models;

use App\Services\PaymentService;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'registration_id',
        'collector_id',
        'custom_id',
        'name',
        'email',
        'status',
        'amount',
        'running_balance',
        'penalty',
        'archived_at',
    ];

    public $with = [
        'registration.assessment'
    ];

    protected $dates = ['archived_at'];

    public string $completed = 'COMPLETED', $failed = 'FAILED', $pending = 'PENDING';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->custom_id = IdGenerator::generate(['table' => 'transactions', 'field' => 'custom_id', 'length' => 10, 'prefix' =>'TRN-']);
        });
    }

    public function getPaymentElementAttribute()
    {
        $status = $this->attributes['status'];
        $color = '';

        switch ($status) {
            case $this->failed:
                $color = 'border border-red-500 text-red-500';
                break;

            case $this->completed:
                $color = 'border border-green-500 text-green-500';
                break;

            case $this->pending:
                $color = 'border border-yellow-500 text-yellow-500';
                break;

            default:
                $color = 'border border-gray-500 text-gray-500';
                break;
        }

        return '<span class="px-2 py-1 rounded text-white uppercase '.$color.'">'.$status.'</span>';
    }

    public function scopefilterByStudent($query, $studentId)
    {
        return $query->when(filled($studentId), function ($query) use ($studentId) {
            return $query->whereHas('registration', function ($query) use ($studentId) {
                return $query->where('student_id', $studentId);
            });
        });
    }

    public function getChargeAttribute() { return
        $this->amount + $this->penalty;
    }

    public function getPenaltyAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function getRunningBalanceAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function getAmountAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function setPenaltyAttribute($value)
    {
        $this->attributes['penalty'] = $this->addTwoZeroDigits($value);
    }

    public function setRunningBalanceAttribute($value)
    {
        $this->attributes['running_balance'] = $this->addTwoZeroDigits($value);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $this->addTwoZeroDigits($value);
    }

    public function collector() { return
        $this->belongsTo(User::class, 'collector_id');
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
