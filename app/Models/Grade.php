<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'subject_id',
        'mark_id',
        'isScale',
        'value',
    ];

//    public function setValueAttribute($value)
//    {
//        if ($value == null) return;
//        $this->attributes['value'] = round($value, 2);
//    }

    public function mark() { return
        $this->belongsTo(Mark::class);
    }

    public function prospectus_subject() { return
        $this->belongsTo(ProspectusSubject::class, 'subject_id');
    }

    public function registration() { return
        $this->belongsTo(Registration::class);
    }
}
