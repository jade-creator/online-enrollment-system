<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolType extends Model
{
    use HasFactory;

    public $with = ['levels'];

    public function scopeFilterByType($query, $type) { return
        $query->where('type', $type)->firstOrFail();
    }

    public function levels(){
        return $this->hasMany(Level::class);
    }

    public function attendedSchools(){
        return $this->hasMany(AttendedSchool::class);
    }

    protected $fillable = [
        'type',
    ];
}
