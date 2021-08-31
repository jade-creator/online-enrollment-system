<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProspectusPolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function create(User $user) { return
        $this->isAdmin($user);
    }
}
