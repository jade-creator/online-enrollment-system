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
    ];

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
