<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subject_id',
        'day_id',
        'section_id',
        'start_time',
        'end_time',
    ];

    public function classes() { return
        $this->belongsToMany(Registration::class, 'classes', 'schedule_id', 'registration_id')->withTimestamps();
    }

    public function day() { return
        $this->belongsTo(Day::class);
    }

    public function section() { return
        $this->belongsTo(Section::class);
    }

    public function prospectusSubject() { return
        $this->belongsTo(ProspectusSubject::class);
    }
}
