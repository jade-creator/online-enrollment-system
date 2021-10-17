<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function getNameElementAttribute()
    {
        $classes = 'px-2 py-1 rounded text-white';
        $bgColor = '';

        switch ($this->attributes['name']) {
            case 'Dropped':
                $bgColor = 'bg-yellow-600';
                break;

            case 'Failed':
                $bgColor = 'bg-red-500';
                break;

            case 'Passed':
                $bgColor = 'bg-green-500';
                break;

            case 'Incomplete':
                $bgColor = 'bg-gray-500';
                break;

            default:
                $bgColor = 'bg-indigo-500';
                break;
        }

        $class = $classes.' '.$bgColor;

        return '<span class="'.$class.'">'.$this->attributes['name'].'</span>';
    }

    public function grades() { return
        $this->hasMany(Grade::class);
    }
}
