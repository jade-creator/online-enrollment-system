<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistrationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function action(User $user, Registration $registration) { return
        is_null($registration->released_at);
    }

    public function edit(User $user, Registration $registration) { return
        $this->action($user, $registration) && $this->isAuthorized('registration', 'edit', $user)
            && ($registration->status->name == 'pending' || $registration->status->name == 'confirming');
    }

    public function reject(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'reject', $user) && ($registration->status->name == 'finalized' ||
            $registration->status->name == 'enrolled');
    }

    public function pending(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'pending', $user) && ($registration->status->name == 'confirming' ||
            $registration->status->name == 'denied');
    }

    public function enroll(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'enroll', $user) && $registration->status->name == 'finalized' &&
            filled($registration->assessment);
        //&& $registration->assessment->grand_total > $registration->assessment->balance option
    }

    public function finalize(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'finalize', $user) && $registration->status->name == 'finalized';
    }

    public function confirm(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'confirm', $user) && ($registration->status->name == 'confirming' ||
            $registration->status->name == 'denied');
    }

    /*Paypal Payment Controller*/
    public function pay(User $user, Registration $registration) { return
        $user->role->name == 'student' && ($registration->status->name == 'enrolled' || $registration->status->name == 'finalized') &&
            filled($registration->assessment) && $user->student->id == $registration->student->id;
    }

    /*student submitted registration for assessment.*/
    public function submitted(User $user, Registration $registration) { return
        $user->role->name == 'student' && $registration->status->name !== 'pending';
    }

    /*student submitting registration for assessment.*/
    public function submit(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'selectSection', $user) && ($registration->status->name == 'pending' || $registration->status->name == 'confirming');
    }

    /*student selecting a section*/
    public function selectSection(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'selectSection', $user) && $registration->status->name == 'pending';
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

    public function view(User $user, Registration $registration)
    {
        switch ($user->role->name) {
            case 'student':
                return $registration->student->id == $user->student->id;
                break;

            default:
                return TRUE;
                break;
        }
    }

    public function create(User $user) { return
        $this->isAuthorized('registration', 'create', $user);
    }

    public function exportGrade(User $user, Registration $registration) { return
        $registration->isRegular;
    }

    /* > registration view component
     * */
    public function exportRegistration(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'exportRegistration', $user) && $registration->status->name == 'enrolled';
    }

    public function export(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user, Registration $registration) { return
        $this->isAuthorized('registration', 'update', $user) && $registration->status->name != 'released';
    }

    public function archive(User $user) { return
        $this->isAuthorized('registration', 'archive', $user);
    }

    public function unarchive(User $user) { return
        $this->isAuthorized('registration', 'unarchive', $user);
    }

    public function destroy(User $user, Registration $registration) { return
        $this->isAdmin($user);
    }
}
