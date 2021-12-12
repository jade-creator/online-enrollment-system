<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'isRegular',
        'isNew',
        'isExtension',
        'custom_id',
        'total_unit',
        'status_id',
        'section_id',
        'student_id',
        'prospectus_id',
        'curriculum_id',
        'registrar_id',
    ];

    public array $relationships = [
        'status:id,name',
        'section:id,name',
        'prospectus:id,level_id,program_id,term_id',
        'prospectus.level:id,level',
        'prospectus.program:id,code,program',
        'prospectus.term:id,term',
        'curriculum',
    ];

    protected $casts = [
        'isRegular' => 'boolean',
        'isNew' => 'boolean',
        'isExtension' => 'boolean',
    ];

    protected $attributes = [
        'isRegular' => true,
        'isNew' => false,
        'isExtension' => false,
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->custom_id = IdGenerator::generate(['table' => 'registrations', 'field' => 'custom_id', 'length' => 10, 'prefix' =>date('ym')]);
        });
    }

    public function getClassificationAttribute() { return
        $this->attributes['isRegular'] ? 'Regular' : 'Irregular';
    }

    public function scopeFilterByTerm($query, $termId) { return
        $query->when(filled($termId), function ($query) use ($termId) {
            return $query->whereHas('prospectus', function($query) use ($termId){
                return $query->where('term_id', $termId);
            });
        });
    }

    public function scopeFilterByLevel($query, $levelId) { return
        $query->when(filled($levelId), function ($query) use ($levelId) {
                return $query->whereHas('prospectus', function($query) use ($levelId){
                    return $query->where('level_id', $levelId);
                });
            });
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
                'classes' => function ($query) {
                    $query->withTrashed()
                        ->with([
                        'prospectusSubject.subject' => function ($query) { $query->withTrashed(); },
                        'employee.user.person'
                    ]);
                },
                'fees.category' => function ($query) { $query->withTrashed(); },
                'student.user.person.contact',
                'student.user.person.detail.country',
                'grades:id,registration_id,subject_id,mark_id,value',
                'grades.mark',
                'grades.prospectus_subject',
                'grades.prospectus_subject.subject' => function ($query) { $query->withTrashed(); },
                'grades.prospectus_subject.prerequisites' => function ($query) { $query->withTrashed(); },
                'grades.prospectus_subject.corequisites' => function ($query) { $query->withTrashed(); },
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

    //section index
    public function scopeEnrolled($query)
    {
        return $query->where([
                'status_id' => $this->statusEnrolled()->id,
                'released_at' => null,
            ]);
    }

    public function totalFees() { return
        $this->getFormattedPriceAttribute($this->formatTwoDecimalPlaces($this->fees()->sum('total_fee')));
    }

    public function registrar() { return
        $this->belongsTo(User::class, 'registrar_id');
    }

    public function curriculum() { return
        $this->belongsTo(Curriculum::class);
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
                return $query->where('id', 'LIKE', $search)
                        ->orWhere('custom_id', 'LIKE', $search);
            });
    }
}
