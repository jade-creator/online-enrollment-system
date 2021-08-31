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

    // pluck subjects in a prospectus collection.
    public function pluckSubject($prospectuses)
    {
        $subjects = new Collection();

        foreach ($prospectuses as $prospectus)
        {
            $subjects = $subjects->merge($prospectus->subjects);
        }

        return $subjects->map(fn($prospectus) => $prospectus->subject);
    }

    // get all subjects in all preceding prospectuses.
    public function scopeGetAllSubjectsInPrecedingProspectuses($query, $prospectus) {
        $prospectuses = $query->where([
                ['id', '<', $prospectus->id],
                ['level_id', '<=', $prospectus->level_id],
                ['program_id', '=', $prospectus->program_id],
            ])
            ->with('subjects')
            ->get(['id', 'level_id', 'program_id']);

        return $this->pluckSubject($prospectuses);
    }

    // get all subjects in the given program.
    public function scopeGetAllSubjectsInProgram($query, $programId)
    {
        $prospectuses = $query->where('program_id', $programId)
            ->with('subjects')
            ->get(['id', 'program_id']);

        return $this->pluckSubject($prospectuses);
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

    public function fees() { return
        $this->belongsToMany(Fee::class)->withTimestamps();
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
