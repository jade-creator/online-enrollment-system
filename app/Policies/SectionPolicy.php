<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role->name == 'admin';
    }

    public function release(User $user, Section $section)
    {
        return $user->role->name == 'admin' && $section->registrations->count() != 0;
    }
}
