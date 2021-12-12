<?php

namespace App\Observers;

use App\Models\Registration;

class RegistrationObserver
{
    public function creating(Registration $registration)
    {
        $registration->registrar_id = auth()->user()->role->name == 'student' ? null : auth()->user()->id;
    }
}
