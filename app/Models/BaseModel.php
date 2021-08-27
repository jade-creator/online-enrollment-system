<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function scopeDateFiltered($query, $dateMin, $dateMax)
    {
        return $query->when(!is_null($dateMin), function ($query) use ($dateMin, $dateMax) {
            return $query->whereBetween('created_at', [$dateMin, $dateMax]);
        });
    }
}
