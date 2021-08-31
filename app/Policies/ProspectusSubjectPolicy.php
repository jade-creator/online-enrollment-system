<?php

namespace App\Policies;

use App\Models\ProspectusSubject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProspectusSubjectPolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function create(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user, ProspectusSubject $prospectusSubject) { return
        $this->isAdmin($user);
    }

    public function destroy(User $user, ProspectusSubject $prospectusSubject) { return
        $this->isAdmin($user);
    }
}
