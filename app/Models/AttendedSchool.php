<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendedSchool extends Model
{
    use HasFactory;

    public function schoolType(){
        return $this->belongsTo(SchoolType::class);
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }

    protected $fillable = [
        'name',
        'date_graduated',
        'program',
        'school_type_id',
        'level_id',
        'student_id',
    ];
}
