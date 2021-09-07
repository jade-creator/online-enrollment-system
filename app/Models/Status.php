<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeEnrolledAndReleased($query) { return
        $query->whereIn('name', ['enrolled', 'released'])->get();
    }

    public function registrations() { return
        $this->hasMany(Registration::class);
    }
}
