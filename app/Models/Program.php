<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'program',
        'description',
        'year',
    ];

    public function prospectuses() { return
        $this->hasMany(Prospectus::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('code', 'LIKE', $search)
                ->orWhere('program', 'LIKE', $search)
                ->orWhere('description', 'LIKE', $search);
            });
    }
}
