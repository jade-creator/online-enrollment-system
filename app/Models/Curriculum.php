<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculum extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'program_id',
        'code',
        'description',
        'isActive',
        'start_date',
        'end_date',
    ];

    public function scopeFindActiveCurriculum($query, $programId) { return
        $query->where([
            ['isActive', 1],
            ['program_id', $programId],
        ])->first();
    }

    public function getStateAttribute() { return
        $this->isActive ? 'Active' : 'Inactive';
    }

    public function getStateElementAttribute()
    {
        $elem = '';

        if ($this->isActive) {
            $elem = '<span class="px-2 py-1 bg-green-500 rounded text-white">'.$this->getStateAttribute().'</span>';
        } else {
            $elem = '<span class="px-2 py-1 bg-red-500 rounded text-white">'.$this->getStateAttribute().'</span>';
        }

        return $elem;
    }

    public function getSchoolYearAttribute() { return
        Carbon::parse($this->start_date)->format('Y').'-'.Carbon::parse($this->end_date)->format('Y');
    }

    public function students() { return
        $this->hasMany(Student::class);
    }

    public function registrations() { return
        $this->hasMany(Registration::class);
    }

    public function prospectusSubjects() { return
        $this->hasMany(ProspectusSubject::class);
    }

    public function program() { return
        $this->belongsTo(Program::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                    ->where('code', 'LIKE', $search);
            });
    }
}
