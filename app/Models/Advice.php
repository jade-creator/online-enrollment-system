<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Advice extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'program_id',
        'level_id',
        'date',
        'time',
        'link',
        'remarks',
    ];

    public function program() { return
        $this->belongsTo(Program::class);
    }

    public function level() { return
        $this->belongsTo(Level::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                    ->where('id', 'LIKE', $search)
                    ->orWhere('date', 'LIKE', $search)
                    ->orWhere('time', 'LIKE', $search)
                    ->orWhere('link', 'LIKE', $search)
                    ->orWhere('remarks', 'LIKE', $search);
            });
    }
}
