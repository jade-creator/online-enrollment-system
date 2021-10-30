<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends BaseModel
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'prospectus_id',
        'room_id',
        'seat',
        'isFull'
    ];

    public $with = [
        'prospectus:id,level_id,program_id,term_id',
        'prospectus.level:id,level',
        'prospectus.program:id,code,program',
        'prospectus.term:id,term',
        'room:id,name',
    ];

    protected $casts = ['isFull' => 'boolean'];

    protected $attributes = ['isFull' => false];

    public function scopeWithSortedSchedules($query) { return
        $query->select(['id', ...$this->fillable, 'created_at'])
            ->with([
                'schedules' => function($query) { return
                    $query->orderBy('day_id','ASC')
                        ->orderBy('start_time', 'ASC');
                },
                'schedules.prospectusSubject.subject',
                'schedules.employee.user.person',
                'schedules.day',
            ]);
    }

    public function scopeFilterWithProspectusByProgram($query, $programId)
    {
        return $query->when(filled($programId), function($query) use ($programId) {
            return $query->WhereHas('prospectus', function($query) use ($programId){
                return $query->where('program_id', $programId);
            });
        });
    }

    public function scopeEnrolledStudents($query) { return
        $query->registrations()->where([
            'status_id' => 4,
            'isExtension' => 0,
            'released_at' => null,
        ])->get();
    }

    public function days() { return
        $this->hasManyDeep(
            Day::class,
            [Schedule::class],
            [null, 'id', 'id'],
            [null, 'schedule_id', 'day_id'],
        );
    }

    public function registrations() { return
        $this->hasMany(Registration::class);
    }

    public function schedules() { return
        $this->hasMany(Schedule::class);
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
