<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'isRegular',
        'isNew',
        'isExtension',
        'total_unit',
        'status_id',
        'section_id',
        'student_id',
        'prospectus_id',
    ];

    public array $relationships = [
        'status:id,name',
        'section:id,name',
        'prospectus:id,level_id,program_id,term_id',
        'prospectus.level:id,level',
        'prospectus.program:id,code',
        'prospectus.term:id,term',
    ];

    public function getClassificationAttribute() { return
        $this->attributes['isRegular'] ? 'Regular' : 'Irregular';
    }

    public function scopeFilterByProgram($query, $programId) { return
        $query->whereBetween('created_at', [
                now()->startOfYear(),
                now()->endOfYear(),
            ])
            ->when(filled($programId), function ($query) use ($programId) {
            return $query->whereHas('prospectus', function($query) use ($programId){
                return $query->where('program_id', $programId);
            });
        });
    }

    public function getSchoolYearAttribute() { return
        $this->created_at->format('Y').'-'.$this->created_at->addYear()->format('Y');
    }

    public function getIsNewAttribute($value) { return
        $value ? 'New' : 'Old';
    }

    public function scopePreRegistered($query, $regId)
    {
        return $query->select(['id', ...$this->fillable, 'released_at', 'created_at'])
            ->with([
                ...$this->relationships,
                'classes.prospectusSubject',
                'student.user.person.contact',
                'student.user.person.detail.country',
                'grades:id,registration_id,subject_id',
                'grades.prospectus_subject',
                'grades.prospectus_subject.subject:id,code,title',
                'grades.prospectus_subject.prerequisites',
            ])
            ->findOrFail($regId);
    }

    public function scopeFilterByStatus($query, $statusId) { return
        $query->when(filled($statusId), function ($query) use ($statusId) {
            return $query->where('status_id', $statusId);
        });
    }

    public function scopeFilterByStudent($query, $studentId)
    {
        return $query->select(['id', ...$this->fillable, 'created_at'])
            ->where('student_id', $studentId)
            ->where('isExtension', 0)
            ->with([...$this->relationships]);
    }

    public function scopeSearchByStudent($query, $search)
    {
        return $query->when(filled($search), function($query) use ($search) {
            return $query->orWhereHas('student', function($query) use ($search) {
                return $query->where('custom_id', 'LIKE', '%'.$search.'%');
            })
            ->orWhereHas('student.user.person', function($query) use ($search) {
                return $query->where('firstname', 'LIKE', '%'.$search.'%')
                    ->orWhere('middlename', 'LIKE', '%'.$search.'%')
                    ->orWhere('lastname', 'LIKE', '%'.$search.'%');
            });
        });
    }

    public function scopeWithGrades($query, $statuses)
    {
        return $query->select(['id', ...$this->fillable, 'created_at'])
            ->with([
                ...$this->relationships,
                'prospectus.level.schoolType:id',
                'student.user.person',
                'grades:id,registration_id,subject_id,mark_id,value',
                'grades.prospectus_subject:id,subject_id',
                'grades.mark:id,name',
                'grades.prospectus_subject.subject:id,code,title',
            ])
            ->whereIn('status_id', $statuses);
    }

    public function statusEnrolled() { return
        Status::where('name', 'enrolled')->first();
    }

    //dashboard
    public function scopeFinalized($query)
    {
        return $query->where([
            'status_id' => 3,
            'isExtension' => 0,
            'released_at' => null,
        ])->get();
    }

    //dashboard
    public function scopeConfirming($query)
    {
        return $query->where([
            'status_id' => 2,
            'isExtension' => 0,
            'released_at' => null,
        ])->get();
    }

    //dashboard
    public function scopePending($query)
    {
        return $query->where([
            'status_id' => 1,
            'isExtension' => 0,
            'released_at' => null,
        ])->get();
    }

    //section index
    public function scopeEnrolled($query)
    {
        return $query->where([
                'status_id' => $this->statusEnrolled()->id,
                'isExtension' => 0,
                'released_at' => null,
            ]);
    }

    public function transactions() { return
        $this->hasMany(Transaction::class);
    }

    public function assessment() { return
        $this->hasOne(Assessment::class);
    }

    public function fees() { return
        $this->belongsToMany(Fee::class)->withPivot(['total_fee'])
            ->withTimestamps();
    }

    public function classes() { return
        $this->belongsToMany(Schedule::class, 'classes', 'registration_id', 'schedule_id')->withTimestamps();
    }

    public function extensions() { return
        $this->hasMany(Extension::class);
    }

    public function grades() { return
        $this->hasMany(Grade::class);
    }

    public function status() { return
        $this->belongsTo(Status::class);
    }

    public function section() { return
        $this->belongsTo(Section::class);
    }

    public function student() { return
        $this->belongsTo(Student::class);
    }

    public function prospectus() { return
        $this->belongsTo(Prospectus::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query->where('id', 'LIKE', $search);
            });
    }
}
