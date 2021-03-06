<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender',
        'civil_status',
        'religion',
        'birthdate',
        'birthplace',
        'person_id',
        'country_id',
    ];

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
