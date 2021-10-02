<?php

namespace App\Policies;

use App\Models\Advice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvicePolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function create(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user, Advice $advice) { return
        $this->isAdmin($user);
    }

    public function destroy(User $user, Advice $advice) { return
        $this->isAdmin($user);
    }

    public function view(User $user) { return
        TRUE;
    }

    public function export(User $user) { return
        $this->isAdmin($user);
    }
}
