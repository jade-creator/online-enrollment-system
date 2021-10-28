<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'mission',
        'vision',
    ];

    public function programs() { return
        $this->hasMany(Program::class);
    }

    public function employees() { return
        $this->hasMany(Employee::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                    ->where('code', 'LIKE', $search)
                    ->orWhere('name', 'LIKE', $search)
                    ->orWhere('description', 'LIKE', $search);
            });
    }
}
