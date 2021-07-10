<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function getPriceAttribute($value) { 
        $value = $value / 100;
        return number_format((float)$value, 2, '.', '');
    }

    public function setPriceAttribute($value) 
    { 
        $this->attributes['price'] = $value * 100;
    }

    public function prospectuses() { return
        $this->belongsToMany(Prospectus::class)->withTimestamps();
    }

    public static function search(?string $search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('id', 'LIKE', $search)
                ->orWhere('name', 'LIKE', $search);
            });
    }
}
