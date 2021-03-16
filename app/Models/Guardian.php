<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    public function person(){
        return $this->belongsTo(Person::class);
    }

    protected $fillable = [
        'fullname',
        'relationship',
        'address',
        'mobile_number',
        'person_id',
    ];
}
