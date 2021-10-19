<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

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
        'isCompleteDetail',
    ];

    public function getFullNameAttribute() { return
        "{$this->firstname} {$this->middlename} {$this->lastname} {$this->suffix}";
    }

    public function getShortFullNameAttribute() { return
        "{$this->firstname} {$this->lastname}";
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function contact(){
        return $this->hasOne(Contact::class, 'person_id');
    }

    public function guardian(){
        return $this->hasOne(Guardian::class);
    }

    public function detail(){
        return $this->hasOne(Detail::class);
    }
}
