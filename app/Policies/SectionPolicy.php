<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    public function user(User $user) { return
        $user->role->name == 'admin';
    }

    public function view(User $user) { return true; }

    public function create(User $user) { return
        $this->user($user);
    }

    public function update(User $user, Section $section) { return
        $this->user($user);
    }

    public function destroy(User $user, Section $section) { return
        $this->user($user);
    }

    public function release(User $user, Section $section) { return
        $this->user($user) && $section->registrations->count() != 0;
    }
}
