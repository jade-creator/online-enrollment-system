<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strand extends Model
{
    use HasFactory;

    public function specialization() { return
        $this->hasMany(Specialization::class);
    }

    public function track() { return
        $this->belongsTo(Track::class);
    }
}
