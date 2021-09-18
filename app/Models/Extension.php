<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    use HasFactory;

    public $with = ['registration'];

    public function registration() { return
        $this->belongsTo(Registration::class, 'extension_id');
    }
}
