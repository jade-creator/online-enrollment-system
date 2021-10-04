<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class File extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'file_name',
        'hashed_name',
    ];

    public function user() { return
        $this->belongsTo(User::class);
    }
}
