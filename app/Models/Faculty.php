<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'program_id',
        'name',
        'description',
        'mission',
        'vision',
    ];

    public function program() { return
        $this->belongsTo(Program::class);
    }

    public function users() { return
        $this->hasMany(User::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                    ->where('id', 'LIKE', $search)
                    ->orWhere('name', 'LIKE', $search)
                    ->orWhere('description', 'LIKE', $search);
            });
    }
}
