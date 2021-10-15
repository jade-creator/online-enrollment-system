<?php

namespace App\Policies;

use App\Models\Curriculum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurriculumPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user) { return TRUE;}

    public function block(User $user) { return ! $this->isAdmin($user);;}

    public function create(User $user) { return $this->isAdmin($user);}

    public function update(User $user, Curriculum $curriculum) { return
        $this->isAdmin($user) && (!isset($curriculum->registrations) || $curriculum->registrations->isEmpty());
    }

    public function destroy(User $user, Curriculum $curriculum) { return
        $this->isAdmin($user) && (!isset($curriculum->registrations) || $curriculum->registrations->isEmpty());
    }

    public function activate(User $user, Curriculum $curriculum) { return
        $this->isAdmin($user) && ! $curriculum->isActive;
    }

    public function deactivate(User $user, Curriculum $curriculum) { return
        $this->isAdmin($user) && $curriculum->isActive;
    }

    public function export(User $user) { return
        $this->isAdmin($user);
    }
}
