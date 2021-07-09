<?php

namespace App\Models;

// use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'start_time_monday',
        'end_time_monday',
        'start_time_tuesday',
        'end_time_tuesday',
        'start_time_wednesday',
        'end_time_wednesday',
        'start_time_thursday',
        'end_time_thursday',
        'start_time_friday',
        'end_time_friday',
    ];

    public function sections() { return
        $this->belongsToMany(Section::class)->withTimestamps();
    }

    public function subject() { return
        $this->belongsTo(Subject::class);
    }
}
