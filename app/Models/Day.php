<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function getAbbrevAttribute()
    {
        switch ($this->attributes['name']) {
            case 'Monday':
                return 'Mon';
                break;

            case 'Tuesday':
                return 'Tues';
                break;

            case 'Wednesday':
                return 'Wed';
                break;

            case 'Thursday':
                return 'Thurs';
                break;

            case 'Friday':
                return 'Fri';
                break;

            case 'Saturday':
                return 'Sat';
                break;

            case 'Sunday':
                return 'Sun';
                break;

            default:
                return 'N/A';
        }
    }

    public function schedules() { return
        $this->hasMany(Schedule::class);
    }
}
