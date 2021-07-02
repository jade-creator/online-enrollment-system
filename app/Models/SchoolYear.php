<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_date',
        'to_date',
        'is_active',
    ];

    private function getYearOnly($date) { return 
        Carbon::createFromFormat('Y-m-d', $date)->format('Y');
    }

    public function getSchoolYearAttribute() { return
        'SY. ' . $this->getYearOnly($this->from_date) . '-' . $this->getYearOnly($this->to_date);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                    ->where('from_date', 'LIKE', $search)
                    ->orWhere('to_date', 'LIKE', $search);
            });
    }
}
