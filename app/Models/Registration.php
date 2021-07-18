<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'isNew',
        'status_id',
        'section_id',
        'student_id',
        'prospectus_id',
    ];

    public function subjects() { return
        $this->belongsToMany(Subject::class)
            ->withTimestamps()
            ->withPivot(['grade', 'mark_id']);
    }

    public function status() { return
        $this->belongsTo(Status::class);
    }

    public function section() { return
        $this->belongsTo(Section::class);
    }

    public function student() { return
        $this->belongsTo(Student::class);
    }

    public function prospectus() { return
        $this->belongsTo(Prospectus::class);
    }

    public static function search($search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('id', 'LIKE', $search);
            });
    }
}
