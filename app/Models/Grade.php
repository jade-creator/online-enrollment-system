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
        'value',
    ];

    public function mark() { return
        $this->belongsTo(Mark::class);
    }

    public function subject() { return
        $this->belongsTo(Subject::class);
    }

    public function registration() { return
        $this->belongsTo(Registration::class);
    }
}
