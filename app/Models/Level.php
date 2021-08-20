<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public function schoolType(){
        return $this->belongsTo(SchoolType::class);
    }

    public function attendedSchools(){
        return $this->hasMany(AttendedSchool::class);
    }

    protected $fillable = [
        'level',
        'school_type_id',
    ];

    public static function search(?string $search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('level', 'LIKE', $search);
            });
    }
}
