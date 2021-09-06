<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models\Registration;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RegistrationViewComponent extends Component
{
    use AuthorizesRequests;

    public Registration $registration;
    public $regId;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount() {
        $this->registration = new Registration();
    }

    public function render() { return
        view('livewire.student.registration-component.registration-view-component', ['registration' => $this->getRegistration()]);
    }

    public function getRegistration()
    {
        $this->registration = Registration::preRegistered($this->regId);
        $this->authorize('view', $this->registration);

        return $this->registration;
    }
}
