<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public string $pending = 'pending', $confirming = 'confirming', $finalized = 'finalized', $enrolled = 'enrolled',
        $denied = 'denied';

    public function getNameElementAttribute()
    {
        $classes = 'px-2 py-1 rounded text-white capitalize';
        $bgColor = '';

        switch ($this->attributes['name']) {
            case $this->pending:
                $bgColor = 'bg-yellow-500';
                break;

            case $this->confirming:
                $bgColor = 'bg-green-500';
                break;

            case $this->finalized:
                $bgColor = 'bg-blue-500';
                break;

            case $this->enrolled:
                $bgColor = 'bg-indigo-500';
                break;

            case $this->denied:
                $bgColor = 'bg-red-500';
                break;

            default:
                $bgColor = 'bg-black';
                break;
        }

        $class = $classes.' '.$bgColor;

        return '<span class="'.$class.'">'.$this->attributes['name'].'</span>';
    }

    public function scopeEnrolledAndReleased($query) { return
        $query->whereIn('name', ['enrolled', 'released'])->get();
    }

    public function registrations() { return
        $this->hasMany(Registration::class);
    }
}
