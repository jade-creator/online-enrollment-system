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

    public Models\Curriculum $curriculum;
    public Models\Registration $registration;
    public Models\Prospectus $prospectus;
    public string $prospectusSlug, $prospectusId, $type = '', $curriculumCode = '';

    public function mount()
    {
        list($this->prospectusId, $this->type, $this->curriculumCode) = explode( '-', $this->prospectusSlug);

        $this->curriculum = Models\Curriculum::where('code', $this->curriculumCode)->firstOrFail();

        $this->prospectus = Models\Prospectus::with([
            'subjects' => function($query) {
                return $query->where('curriculum_id', $this->curriculum->id)->get();
            },
            'subjects.prerequisites',
            'subjects.corequisites',
        ])->findOrFail($this->prospectusId);
    }

    public function render() { return
        view('livewire.student.registration-component.regular-add-component');
    }

    public function save(RegistrationService $registrationService)
    {
        try {
            //search for duplicate regular registration.
            (new RegistrationService())->searchDuplicate($this->prospectusId, auth()->user()->student->id);

            $this->authorize('register', $this->prospectus);

            $this->fill([
                'registration' => new Models\Registration(),
                'registration.isNew' => $this->type === 'new' ? 1 : 0,
                'registration.prospectus_id' => $this->prospectusId,
                'registration.student_id' => auth()->user()->student->id,
                'registration.total_unit' => $this->prospectus->subjects->sum('unit'),
                'registration.curriculum_id' => $this->curriculum->id,
            ]);

            $subjectsId = $registrationService->pluckSubjectsId($this->prospectus->subjects);
            $registration = $registrationService->store($subjectsId, $this->registration);

            return redirect()->route('pre.registration.view', $registration->id);
        } catch (\Exception $e) {
            $this->emit('error');

            return session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
