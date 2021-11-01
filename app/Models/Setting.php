<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_photo_path',
        'school_name',
        'school_email',
        'school_address',
        'school_description',
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

    public function defaultPhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->school_name ?? env('APP_NAME', 'University')).'&color=7F9CF5&background=EBF4FF';
    }

    public function getProfilePhotoUrlPreviewAttribute()
    {
        return $this->profile_photo_path ?? $this->defaultPhotoUrl();
    }
}
