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
        $this->isAuthorized('section', 'create', $user);
    }

    public function update(User $user, Section $section) { return
        $this->isAuthorized('section', 'update', $user);
    }

    public function destroy(User $user, Section $section) { return
        $this->isAuthorized('section', 'destroy', $user);
    }

    public function release(User $user, Section $section) { return
        $this->isAuthorized('section', 'release', $user) && $section->registrations->count() != 0;
    }

    public function createClass(User $user) { return
        $this->isAuthorized('section', 'createClass', $user);
    }
}
