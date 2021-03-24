<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }

    protected $fillable = [
        'relationship',
        'person_id',
        'student_id',
    ];
}
