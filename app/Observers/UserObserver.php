<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\User;
use App\Models\Setting;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $setting = Setting::orderby('created_at', 'desc')->first();

        $user->approved_at = now();

        if (! is_null($setting)
            && $setting->auto_account_approval == FALSE) $user->approved_at = null;
    }

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $role = $user->role->name;

        switch ($role) {
            case 'student':
                if (request()->has('student_id')) {
                    $user->student()->create([
                        'custom_id' => request()->get('student_id'),
                    ]);
                }
                break;

            default:
                if (request()->has('employee_id')) {
                    $user->employee()->create([
                        'custom_id' => request()->get('employee_id'),
                    ]);
                }
                break;
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
