<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extension extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $with = ['registration'];

    public function registration() { return
        $this->belongsTo(Registration::class, 'extension_id');
    }
}
