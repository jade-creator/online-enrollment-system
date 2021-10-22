<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function getNameElementAttribute()
    {
        $classes = 'px-2 py-1 rounded-full text-xs uppercase border-2';
        $colors = '';

        switch ($this->attributes['name']) {
            case 'admin':
                $colors = 'border-red-500 text-red-500';
                break;

            case 'student':
                $colors = 'border-indigo-500 text-indigo-500';
                break;

            case 'registrar':
                $colors = 'border-blue-500 text-blue-500';
                break;

            case 'dean':
                $colors = 'border-green-500 text-green-500';
                break;

            default:
                $colors = 'border-yellow-500 text-yellow-500';
                break;
        }

        $class = $classes.' '.$colors;

        return '<span class="'.$class.'">'.$this->attributes['name'].'</span>';
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
