<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'auto_account_approval',
    ];

    protected $casts = [
        'auto_account_approval' => 'boolean',
    ];

    protected $attributes = [
        'auto_account_approval' => true,
    ];
}
