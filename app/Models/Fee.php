<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'program_id',
        'custom_id',
        'category_id',
        'price',
        'description',
    ];

    public $with = [
        'category',
        'program',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->custom_id = IdGenerator::generate(['table' => 'fees', 'field' => 'custom_id', 'length' => 10, 'prefix' =>'FEE-']);
        });
    }

    public function scopeFilterByCategory($query, $categoryId) {
        return $query->when(filled($categoryId), function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        });
    }

    public function scopeFilterByProgram($query, $programId) {
        return $query->when(filled($programId), function ($query) use ($programId) {
            return $query->where('program_id', $programId);
        });
    }

    public function getPriceAttribute($value) { return
        $this->formatTwoDecimalPlaces($value);
    }

    public function addTwoZeroDigits($value) { return
        $value * 100;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] =$this->addTwoZeroDigits($value);
    }

    public function registrations() { return
        $this->belongsToMany(Registration::class)->withPivot(['total_fee'])
            ->withTimestamps();
    }

    public function category() { return
        $this->belongsTo(Category::class);
    }

    public function program() { return
        $this->belongsTo(Program::class);
    }

    public static function search(?string $search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('id', 'LIKE', $search)
                ->orWhere('price', 'LIKE', $search)
                ->orWhere('description', 'LIKE', $search);
            });
    }
}
