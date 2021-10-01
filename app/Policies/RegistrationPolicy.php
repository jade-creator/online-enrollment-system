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
        $this->isAdmin($user) && ($registration->status->name == 'finalized' || $registration->status->name == 'enrolled');
    }

    public function pending(User $user, Registration $registration) { return
        $this->isAdmin($user) && ($registration->status->name == 'confirming' || $registration->status->name == 'denied');
    }

    public function enroll(User $user, Registration $registration) { return
        $this->isAdmin($user) && $registration->status->name == 'finalized'; //TODO: CHECK FOR FINAL ASSESSMENT
    }

    public function confirm(User $user, Registration $registration) { return
        $this->isAdmin($user) && ($registration->status->name == 'confirming' || $registration->status->name == 'denied');
    }

    /*student submitted registration for assessment.*/
    public function submitted(User $user, Registration $registration) { return
        $user->role->name == 'student' && $registration->status->name !== 'pending';
    }

    /*student submitting registration for assessment.*/
    public function submit(User $user, Registration $registration) { return
        ($user->role->name == 'student' || $this->isAdmin($user)) && ($registration->status->name == 'pending' || $registration->status->name == 'confirming');
    }

    /*student selecting a section*/
    public function selectSection(User $user, Registration $registration) { return
        ($user->role->name == 'student' || $this->isAdmin($user)) && $registration->status->name == 'pending';
    }

//    public function viewSection(User $user, Registration $registration) { return
//        $this->isAdmin($user) && $registration->section_id;
//    }

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

    public function exportGrade(User $user, Registration $registration) { return
        $registration->isRegular;
    }

    public function export(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user, Registration $registration) { return
        $this->isAdmin($user) && $registration->status->name != 'released';
    }

    public function destroy(User $user, Registration $registration) { return
        $this->isAdmin($user);
    }
}
