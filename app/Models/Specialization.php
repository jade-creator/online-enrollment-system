<?php

namespace App\Models;

use App\Models\Strand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialization',
        'strand_id',
    ];

    public function strand() { return
        $this->belongsTo(Strand::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('specialization', 'LIKE', $search);
            });
    }
}
