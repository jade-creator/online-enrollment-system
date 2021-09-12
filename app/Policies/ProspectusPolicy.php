<?php

namespace App\Policies;

use App\Models\Prospectus;
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

    public function register(User $user, Prospectus $prospectus) { return
        $user->role->name == 'student' && $prospectus->subjects->isNotEmpty();
    }
}
