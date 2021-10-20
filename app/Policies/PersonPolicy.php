<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Person;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Person  $registration
     * @return mixed
     */
    public function view(User $user, Person $person) { return
        $this->isAuthorized('person', 'view', $user) || $person->id == $user->person_id;
    }

    public function update(User $user, Person $person) { return
        $person->id == $user->person_id;
    }

    public function email(User $user, Person $person) { return
        $person->id != $user->person_id;
    }
}
