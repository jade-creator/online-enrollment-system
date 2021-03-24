<?php

namespace App\Policies;

use App\Models\AttendedSchool;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendedSchoolPolicy
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
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendedSchool  $attendedSchool
     * @return mixed
     */
    public function view(User $user, AttendedSchool $attendedSchool)
    {
        //
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
     * @param  \App\Models\AttendedSchool  $attendedSchool
     * @return mixed
     */
    public function update(User $user, AttendedSchool $attendedSchool)
    {
        return $user->student->id === $attendedSchool->student_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendedSchool  $attendedSchool
     * @return mixed
     */
    public function delete(User $user, AttendedSchool $attendedSchool)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendedSchool  $attendedSchool
     * @return mixed
     */
    public function restore(User $user, AttendedSchool $attendedSchool)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendedSchool  $attendedSchool
     * @return mixed
     */
    public function forceDelete(User $user, AttendedSchool $attendedSchool)
    {
        //
    }
}
