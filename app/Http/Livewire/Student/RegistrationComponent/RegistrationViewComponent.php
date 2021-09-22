<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models\Registration;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RegistrationViewComponent extends Component
{
    use AuthorizesRequests;

    public Registration $registration;
    public float $totalUnit = 0;
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

        $this->totalUnit = $this->registration->total_unit;
        if (! $this->registration->isExtension && $this->registration->extensions->isNotEmpty()) {
            foreach ($this->registration->extensions as $extension) {
                $this->totalUnit += $extension->registration->total_unit;
            }
        }

        return $this->registration;
    }
}
