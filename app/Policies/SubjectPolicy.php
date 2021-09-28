<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function create(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user, Subject $subject) { return
        $this->isAdmin($user);
    }

    public function destroy(User $user, Subject $subject) { return
        $this->isAdmin($user);
    }

    public function export(User $user) { return
        $this->isAdmin($user);
    }
}
