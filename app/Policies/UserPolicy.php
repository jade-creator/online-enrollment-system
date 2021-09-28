<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function view(User $user) { return true; }

    public function export(User $user) { return
        $this->isAdmin($user);
    }

    public function create(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user) { return
        $this->isAdmin($user);
    }

    public function activate(User $user, User $userAccount) { return
        $this->isAdmin($user) && $userAccount->approved_at != null;
    }

    public function deactivate(User $user, User $userAccount) { return
        $this->isAdmin($user) && $userAccount->approved_at == null;
    }
}
