<?php

namespace App\Models;

class Student extends BaseModel
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = [
        'custom_id',
        'user_id',
        'program_id',
        'isRegular',
        'isNew',
        'curriculum_id',
    ];

    protected $casts = [
        'isRegular' => 'boolean',
        'isNew' => 'boolean',
    ];

    protected $attributes = [
        'isRegular' => true,
        'isNew' => true,
    ];

    public function scopeFilterByProgram($query, $programId) { return
        $query->whereBetween('created_at', [
                now()->startOfYear(),
                now()->endOfYear(),
            ])
            ->when(filled($programId), function ($query) use ($programId) {
                return $query->where('program_id', $programId);
            });
    }

    public function getClassificationAttribute() { return
        $this->attributes['isRegular'] ? 'Regular' : 'Irregular';
    }

    public function getIsNewAttribute($value) { return
        $value ? 'New' : 'Old';
    }

    public function grandTotal() { return
        $this->hasManyDeep( Assessment::class, [Registration::class]);
    }

    public function curriculum() { return
        $this->belongsTo(Curriculum::class);
    }

    public function program() { return
        $this->belongsTo(Program::class);
    }

    public function registrations() { return
        $this->hasMany(Registration::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function guardian(){
        return $this->hasOne(Guardian::class);
    }

    public function attendedSchool(){
        return $this->hasOne(AttendedSchool::class);
    }

    public static function search(?string $search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query->where('custom_id', 'LIKE', $search);
            });
    }
}
