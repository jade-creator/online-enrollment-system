<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Fee;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeePolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function export(User $user) { return
        $this->isAdmin($user);
    }

    public function create(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user, Fee $fee) { return
        $this->isAdmin($user);
    }

    public function destroy(User $user, Fee $fee) { return
        $this->isAdmin($user);
    }
}
