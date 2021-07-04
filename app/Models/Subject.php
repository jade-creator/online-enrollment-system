<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'unit',
    ];  

    public function prospectuses() { return
        $this->belongsToMany(Prospectus::class)->withTimestamps();
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('code', 'LIKE', $search)
                ->orWhere('title', 'LIKE', $search);
            });
    }
}
