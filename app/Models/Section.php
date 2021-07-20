<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'remarks',
        'prospectus_id',
        'room_id',
        'seat',
    ];

    public function registrations() { return
        $this->hasMany(Registration::class);
    }

    public function schedules() { return
        $this->belongsToMany(Schedule::class)->withTimestamps();
    }

    public function room() { return
        $this->belongsTo(Room::class);
    }

    public function prospectus() { return
        $this->belongsTo(Prospectus::class);
    }

    public static function search(?string $search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('id', 'LIKE', $search)
                ->orWhere('name', 'LIKE', $search);
            });
    }
}
