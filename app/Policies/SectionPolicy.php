<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user) { return true; }

    public function create(User $user) { return
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

    public function createClass(User $user) { return
        $this->isAuthorized('section', 'createClass', $user);
    }
}
