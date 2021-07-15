<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Person;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Person  $registration
     * @return mixed
     */
    public function view(User $user, Person $person)
    {
        return $user->role->name == 'admin' || $person->id == $user->person_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Person  $registration
     * @return mixed
     */
    public function update(User $user, Person $person)
    {
        return $person->id == $user->person_id;
    }
}
