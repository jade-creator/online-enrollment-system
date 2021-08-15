<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        return $user->role->name == 'admin';
    }

    public function create(User $user) { return true; }

    public function update(User $user, Section $section) { return true; }

    public function release(User $user, Section $section)
    {
        return $section->registrations->count() != 0;
    }
}
