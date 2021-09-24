<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function create(User $user) { return
        $user->role->name == 'student';
    }

    public function view(User $user) { return
        $this->isAdmin();
    }
}
