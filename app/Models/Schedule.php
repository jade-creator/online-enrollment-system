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

    public function day() { return
        $this->belongsTo(Day::class);
    }

    public function section() { return
        $this->belongsTo(Section::class);
    }

    public function subject() { return
        $this->belongsTo(Subject::class);
    }
}
