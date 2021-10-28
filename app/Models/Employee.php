<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'user_id',
        'custom_id',
        'salutation',
    ];

    public function schedules() { return
        $this->hasMany(Schedule::class);
    }

    public function faculty() { return
        $this->belongsTo(Faculty::class);
    }

    public function user() { return
        $this->belongsTo(User::class);
    }

    public static function search(?string $search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query->where('custom_id', 'LIKE', $search);
            });
    }
}
