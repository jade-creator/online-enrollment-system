<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'person_id',
        'approved_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function scopeStudent($query) { return
        $query->whereHas('role', function($query) {
            return $query->where('name', 'student');
        });
    }

    public function scopeNone($query) { return
        $query->student()
            ->whereHas('person.detail', function($query) {
                return $query->where('gender', 'Prefer not to say');
            })
            ->get(['id', 'role_id', 'person_id']);
    }

    public function scopeOther($query) { return
        $query->student()
            ->whereHas('person.detail', function($query) {
                return $query->where('gender', 'Other');
            })
            ->get(['id', 'role_id', 'person_id']);
    }

    public function scopeFemale($query) { return
        $query->student()
            ->whereHas('person.detail', function($query) {
                return $query->where('gender', 'Female');
            })
            ->get(['id', 'role_id', 'person_id']);
    }

    public function scopeMale($query) { return
        $query->student()
            ->whereHas('person.detail', function($query) {
                return $query->where('gender', 'Male');
            })
            ->get(['id', 'role_id', 'person_id']);
    }

    public function scopeDateFiltered($query, $dateMin, $dateMax) { return
        (new BaseModel())->scopeDateFiltered($query, $dateMin, $dateMax);
    }

    public function scopeMatchWithRole($query, $roleId) { return
        $query->when(filled($roleId), fn ($query) => $query->where('role_id', $roleId));
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function employee() { return
        $this->hasOne(Employee::class);
    }

    public function student(){
        return $this->hasOne(Student::class);
    }

    public function studentGuardian(){
        return $this->hasOneThrough(Guardian::class, Student::class);
    }

    public static function search(?string $search)
    {
        $search = '%'.$search.'%';

        return empty($search) ? static::query()
            : static::where(function ($query) use ($search){
                return $query
                ->where('name', 'LIKE', $search)
                ->orWhere('email', 'LIKE', $search);
            });
    }
}
