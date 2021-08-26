<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

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

    public function scopeDateFiltered($query, $dateMin, $dateMax) //TODO: create baseModel and inherit this to every child models
    {
        return $query->when(!is_null($dateMin), function ($query) use ($dateMin, $dateMax) {
            return $query->whereBetween('created_at', [$dateMin, $dateMax]);
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
