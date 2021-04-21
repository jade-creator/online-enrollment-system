<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolType extends Model
{
    use HasFactory;

    public function levels(){
        return $this->hasMany(Level::class);
    }

    public function attendedSchools(){
        return $this->hasMany(AttendedSchool::class);
    }

    protected $fillable = [
        'type',
    ];

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('type', 'LIKE', $search);
            });
    }
}
