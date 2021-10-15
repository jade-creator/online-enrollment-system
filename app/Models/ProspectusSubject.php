<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProspectusSubject extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'prospectus_id',
        'subject_id',
        'unit',
    ];

    public $select = [
        'id',
        'prospectus_id',
        'subject_id',
        'curriculum_id',
        'unit',
        'created_at',
    ];

    public $with = [ 'subject:id,code,title' ];

    //get all the subjects in the given prospectus.
    public function scopeGetAllSubjectsInProspectus($query, $prospectusId) { return
        $query->where('prospectus_id', $prospectusId)
            ->get($this->select);
    }

    public function curriculum() { return
        $this->belongsTo(Curriculum::class);
    }

    public function corequisites() { return
        $this->belongsToMany(Subject::class, 'prospectus_subject_corequisite', 'prospectus_subject_id', 'corequisite_id')
            ->withTimestamps();
    }

    public function prerequisites() { return
        $this->belongsToMany(Subject::class, 'prospectus_subject_prerequisite', 'prospectus_subject_id', 'prerequisite_id')
            ->withTimestamps();
    }

    public function prospectus() { return
        $this->belongsTo(Prospectus::class);
    }

    public function subject() { return
        $this->belongsTo(Subject::class);
    }
}
