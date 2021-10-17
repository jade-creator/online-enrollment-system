<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_id',
        'user_id',
        'program_id',
        'curriculum_id',
    ];

    public function curriculum() { return
        $this->belongsTo(Curriculum::class);
    }

    public function program() { return
        $this->belongsTo(Program::class);
    }

    public function registrations() { return
        $this->hasMany(Registration::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function guardian(){
        return $this->hasOne(Guardian::class);
    }

    public function attendedSchool(){
        return $this->hasOne(AttendedSchool::class);
    }
}
