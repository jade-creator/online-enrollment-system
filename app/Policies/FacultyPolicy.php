<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacultyPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function isMember(User $user, Faculty $faculty) {
        switch ($user->role->name) {
            case 'admin':
                return TRUE;
                break;

            case 'dean':
                return $user->employee->faculty_id == $faculty->id;
                break;

            default:
                return FALSE;
                break;
        }
    }

    public function view(User $user) { return true; }

    public function leave(User $user, Faculty $faculty) { return
        $faculty->employees->contains('id', $user->employee->id);
    }

    public function addMember(User $user, Faculty $faculty) { return
        $this->isMember($user, $faculty);
    }

    public function removeMember(User $user, Faculty $faculty) { return
        $this->isMember($user, $faculty);
    }

    public function export(User $user) { return
        $this->isAdmin($user);
    }

    public function create(User $user) { return
        $this->isAdmin($user);
    }

    public function update(User $user, Faculty $faculty) { return
        $this->isMember($user, $faculty);
    }

    public function destroy(User $user, Faculty $faculty) { return
        $this->isAdmin($user);
    }

    public function masterlist(User $user) { return
        $this->isAuthorized('faculty', 'masterlist', $user);
    }
}
