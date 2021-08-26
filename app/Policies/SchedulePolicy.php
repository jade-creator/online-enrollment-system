<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;

    public function user(User $user) { return
        $user->role->name == 'admin';
    }

    public function view(User $user) { return true; }

    public function update(User $user, Schedule $schedule) { return
        $this->user($user);
    }
}
