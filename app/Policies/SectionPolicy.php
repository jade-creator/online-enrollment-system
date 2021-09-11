<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function view(User $user) { return true; }

    public function create(User $user) { return
        $this->isAdmin($user);
    }

    public function createClass(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user, Section $section) { return
        $this->isAdmin($user);
    }

    public function destroy(User $user, Section $section) { return
        $this->isAdmin($user);
    }

    public function release(User $user, Section $section) { return
        $this->isAdmin($user) && $section->registrations->count() != 0;
    }
}
