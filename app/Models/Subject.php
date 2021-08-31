<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
    ];

    public function scopeGetAllSubjectsExcept($query, $ids) { return
        $query->whereNotIn('id',  $ids)
            ->orderBy('title', 'asc')
            ->get(['id', 'title']);
    }

    public function grades() { return
        $this->hasMany(Grade::class);
    }

    public function schedules() { return
        $this->hasMany(Schedule::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('code', 'LIKE', $search)
                ->orWhere('title', 'LIKE', $search)
                ->orWhere('description', 'LIKE', $search);
            });
    }
}
