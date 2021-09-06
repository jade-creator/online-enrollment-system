<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistrationPolicy
{
    use HandlesAuthorization;

    public function isAdmin(User $user) { return
        $user->role->name == 'admin';
    }

    public function reject(User $user, Registration $registration) { return
        $this->isAdmin($user);
    }

    public function pending(User $user, Registration $registration) { return
        $this->isAdmin($user) && $registration->status->name !== 'pending';
    }

    public function enroll(User $user, Registration $registration) { return
        $this->isAdmin($user) && $registration->status->name == 'pending';
    }

    public function viewSection(User $user, Registration $registration) { return
        $this->isAdmin($user) && $registration->section_id;
    }

    public function updateGrade(User $user, Registration $registration) { return
        $this->isAdmin($user) && $registration->status->name == "enrolled";
    }

    public function viewGrade(User $user, Registration $registration) { return
        $registration->status->name == "enrolled" || $registration->status->name == "released";
    }

    public function view(User $user, Registration $registration) { return
        $this->isAdmin($user) || $registration->student->id == $user->student->id;
    }

    public function create(User $user) { return
        $user->role->name == 'student';
    }

    public function update(User $user, Registration $registration) { return
        $this->isAdmin($user) && $registration->status->name != 'released';
    }

    public function delete(User $user, Registration $registration)
    {
        //
    }
}
