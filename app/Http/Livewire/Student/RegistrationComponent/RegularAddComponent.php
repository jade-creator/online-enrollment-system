<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models;
use App\Services\Registration\RegistrationService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RegularAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Registration $registration;
    public Models\Prospectus $prospectus;
    public string $prospectusSlug, $prospectusId, $type = '';

    public function mount()
    {
        list($this->prospectusId, $this->type) = explode( '-', $this->prospectusSlug);

        $this->prospectus = Models\Prospectus::with('subjects.prerequisites')->findOrFail($this->prospectusId);
    }

    public function render() { return
        view('livewire.student.registration-component.regular-add-component');
    }

    public function save(RegistrationService $registrationService)
    {
        $this->authorize('register', $this->prospectus);

        try {
            $this->fill([
                'registration' => new Models\Registration(),
                'registration.isNew' => $this->type === 'new' ? 1 : 0,
                'registration.prospectus_id' => $this->prospectusId,
                'registration.student_id' => auth()->user()->student->id,
            ]);

            $subjectsId = $registrationService->pluckSubjectsId($this->prospectus->subjects);
            $registration = $registrationService->store($subjectsId, $this->registration);

            return redirect()->route('pre.registration.view', $registration->id);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
