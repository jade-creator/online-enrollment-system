<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Auth\Access\HandlesAuthorization;

class GradePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user) { return true; }

    public function update(User $user, Grade $grade) { return
        $this->isAuthorized('grade', 'update', $user);
    }

    public function export(User $user) { return
        $this->isAuthorized('grade', 'export', $user);
    }
}
