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

    public function statusEnrolled() { return
        Status::where('name', 'enrolled')->first();
    }

    public function scopeEnrolled($query)
    {
        return $query->where('status_id', $this->statusEnrolled()->id)
            ->whereNull('released_at');
    }

    public function grades() { return
        $this->hasMany(Grade::class);
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
                return $query->where('id', 'LIKE', $search);
            });
    }
}
