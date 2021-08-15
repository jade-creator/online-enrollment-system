<?php

namespace App\Models;

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

    public function registrations() { return
        $this->hasMany(Registration::class);
    }

    public function sections() { return
        $this->hasMany(Section::class);
    }

    public function fees() { return
        $this->belongsToMany(Fee::class)->withTimestamps();
    }

    public function subjects() { return
        $this->belongsToMany(Subject::class)->withTimestamps();
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
