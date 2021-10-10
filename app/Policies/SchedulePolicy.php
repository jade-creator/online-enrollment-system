<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function view(User $user) { return true; }

//    public function create(User $user) { return
//        $this->isAuthorized('section', 'createClass', $user);
//    }

    public function update(User $user, Schedule $schedule) { return
        $this->isAuthorized('schedule', 'update', $user);
    }

    public function destroy(User $user, Schedule $schedule) { return
        $this->isAuthorized('schedule', 'destroy', $user);
    }
}
