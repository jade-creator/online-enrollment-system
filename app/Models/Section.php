<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'prospectus_id',
        'room_id',
        'seat',
    ];

    public $with = [
        'prospectus:id,level_id,program_id,term_id',
        'prospectus.level:id,level',
        'prospectus.program:id,code',
        'prospectus.term:id,term',
        'room:id,name',
    ];

    public function scopeFilterWithProspectusByProgram($query, $programId)
    {
        return $query->when(filled($programId), function($query) use ($programId) {
            return $query->WhereHas('prospectus', function($query) use ($programId){
                return $query->where('program_id', $programId);
            });
        });
    }

    public function registrations() { return
        $this->hasMany(Registration::class);
    }

    public function schedules() { return
        $this->belongsToMany(Schedule::class)->withTimestamps();
    }

    public function room() { return
        $this->belongsTo(Room::class);
    }

    public function prospectus() { return
        $this->belongsTo(Prospectus::class);
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
