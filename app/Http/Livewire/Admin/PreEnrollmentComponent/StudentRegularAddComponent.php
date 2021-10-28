<?php

namespace App\Http\Livewire\Admin\PreEnrollmentComponent;

use App\Models;
use App\Services\Registration\RegistrationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class StudentRegularAddComponent extends Component
{
    use AuthorizesRequests;

    public Models\Curriculum $curriculum;
    public Models\Student $student;
    public ?Models\Registration $registration = null;
    public Models\Prospectus $prospectus;
    public string $prospectusSlug = '', $prospectusId = '', $type = '', $curriculumCode = '';

    public function mount()
    {
        list($this->prospectusId, $this->type, $this->curriculumCode) = explode( '-', $this->prospectusSlug);

        $this->curriculum = Models\Curriculum::where('code', $this->curriculumCode)->firstOrFail();
    }

    public function render() { return
        view('livewire.admin.pre-enrollment-component.student-regular-add-component', ['prospectus' => $this->getProspectus()]);
    }

    public function getProspectus() {
        $this->prospectus = Models\Prospectus::with([
                'subjects' => function($query) {
                    $query->with([
                        'subject' => function ($query) { $query->withTrashed(); },
                    ])
                    ->where('curriculum_id', $this->curriculum->id)
                    ->get();
                },
                'subjects.prerequisites',
                'subjects.corequisites',
            ])->findOrFail($this->prospectusId);

        return $this->prospectus;
    }

    public function save(RegistrationService $registrationService)
    {
        try {
            if (filled($this->registration)) $this->authorize('edit', $this->registration);

            $this->authorize('register', $this->prospectus);

            if (is_null($this->registration)) $this->registration = new Models\Registration();

            $this->fill([
                'registration.section_id' => null,
                'registration.isNew' => $this->type === 'new' ? 1 : 0,
                'registration.prospectus_id' => $this->prospectusId,
                'registration.student_id' => $this->student->id,
                'registration.total_unit' => $this->prospectus->subjects->sum('unit'),
                'registration.curriculum_id' => $this->curriculum->id,
            ]);

            $subjectsId = $registrationService->pluckSubjectsId($this->prospectus->subjects);
            $registration = $registrationService->update($subjectsId, $this->registration);

            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Saved successfully.',
            ]);

            return redirect()->route('pre.registration.view', $registration->id);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
