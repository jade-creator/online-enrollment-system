<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssessmentPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function proceedToPayment(User $user, Assessment $assessment) { return
        $user->role->name == 'student' && filled($assessment);
    }

    public function view(User $user) { return
        $this->isAuthorized('assessment', 'view', $user);
    }

    public function create(User $user) { return
        $this->isAuthorized('assessment', 'create', $user);
    }
}
