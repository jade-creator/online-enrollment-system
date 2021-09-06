<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'isNew',
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
                'prospectus.fees',
                'student.user.person.contact',
                'student.user.person.detail.country',
                'grades:id,registration_id,subject_id',
                'grades.prospectus_subject:id,subject_id,unit',
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
        return $query->select(['id', 'isNew', 'status_id', 'section_id', 'student_id', 'prospectus_id', 'created_at'])
            ->where('student_id', $studentId)
            ->with([...$this->relationships]);
    }

    public function statusEnrolled() { return
        Status::where('name', 'enrolled')->first();
    }

    public function scopeEnrolled($query)
    {
        return $query->where('status_id', $this->statusEnrolled()->id)
            ->whereNull('released_at');
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
