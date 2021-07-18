<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistrationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update it's child.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return mixed
     */
    public function updateGrade(User $user, Registration $registration)
    {
        return $user->role->name == 'admin' && $registration->status->name == "enrolled";
    }

    public function viewGrade(User $user, Registration $registration)
    {
        return $registration->status->name == "enrolled" || $registration->status->name == "released";
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return mixed
     */
    public function view(User $user, Registration $registration)
    {
        return $user->role->name == 'admin' || $registration->student->id == $user->student->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->name == 'student';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return mixed
     */
    public function update(User $user, Registration $registration)
    {
        return $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return mixed
     */
    public function delete(User $user, Registration $registration)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return mixed
     */
    public function restore(User $user, Registration $registration)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Registration  $registration
     * @return mixed
     */
    public function forceDelete(User $user, Registration $registration)
    {
        //
    }
}
