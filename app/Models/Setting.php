<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'auto_account_approval',
        'allow_irregular_student_to_enroll',
    ];

    protected $casts = [
        'auto_account_approval' => 'boolean',
        'allow_irregular_student_to_enroll' => 'boolean',
    ];

    protected $attributes = [
        'auto_account_approval' => true,
        'allow_irregular_student_to_enroll' => true,
    ];
}
