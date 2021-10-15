<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prospectus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'level_id',
        'program_id',
        'term_id',
    ];

    public $with = [
        'level',
        'program',
        'term',
        'subjects',
    ];

    public function scopeFindSpecificProspectus($query, $programId, $levelId, $termId) { return
        $query->with('subjects.prerequisites')
            ->where([
                ['program_id', $programId],
                ['level_id', $levelId],
                ['term_id', $termId],
            ])
            ->firstOrFail();
    }

    // pluck subjects in a prospectus collection.
    public function pluckSubject($prospectuses, $curriculumId)
    {
        $subjects = new Collection();

        foreach ($prospectuses as $prospectus)
        {
            $prospectusSubjects = $prospectus->subjects->filter(function($subject) use ($curriculumId) {
                return $subject->curriculum_id == $curriculumId;
            });
            $subjects = $subjects->merge($prospectusSubjects);
        }

        return $subjects->map(fn($prospectus) => $prospectus->subject);
    }

    //get all preceding prospectus less than/less than or equal to current.
    public function scopeGetAllPrecedingProspectuses($query, $prospectus, $includeCurrent = false) { return
        $query->where([
            ['id', $includeCurrent ? '<=' : '<', $prospectus->id],
            ['level_id', '<=', $prospectus->level_id],
            ['program_id', '=', $prospectus->program_id],
        ])
        ->get(['id', ...$this->fillable]);
    }

    // get all subjects in all preceding prospectuses.
    public function scopeGetAllSubjectsInPrecedingProspectuses($query, $prospectus, $curriculumId) {
        $prospectuses = $query->getAllPrecedingProspectuses($prospectus);

        return $this->pluckSubject($prospectuses, $curriculumId);
    }

    // get all subjects in the given program.
    public function scopeGetAllSubjectsInProgram($query, $programId, $curriculumId)
    {
        $prospectuses = $query->where('program_id', $programId)
            ->get(['id', 'program_id']);

        return $this->pluckSubject($prospectuses, $curriculumId);
    }

    public function subjects() { return
        $this->hasMany(ProspectusSubject::class);
    }

    public function registrations() { return
        $this->hasMany(Registration::class);
    }

    public function sections() { return
        $this->hasMany(Section::class);
    }

    public function level() { return
        $this->belongsTo(Level::class);
    }

    public function program() { return
        $this->belongsTo(Program::class);
    }

    public function term() { return
        $this->belongsTo(Term::class);
    }
}
