<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function contact(){
        return $this->hasOne(Contact::class, 'person_id');
    }

    public function guardian(){
        return $this->hasOne(Guardian::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'suffix',
        'gender',
        'civil_status',
        'religion',
        'nationality',
        'birthdate',
        'birthplace',
        'user_id',
    ];
}
