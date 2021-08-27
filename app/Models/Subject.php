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

    public function grades() { return
        $this->hasMany(Grade::class);
    }

    public function schedules() { return
        $this->hasMany(Schedule::class);
    }

    public function prospectuses() { return
        $this->belongsToMany(Prospectus::class)->withTimestamps();
    }

    public function requisites() { return //TODO will be moved to prospectys relationship.
        $this->belongsToMany(Subject::class, 'requisite_subject', 'subject_id', 'requisite_id')
            ->withTimestamps();
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
