<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models;
use App\Services\Registration\RegistrationIrregularService;
use App\Services\Registration\RegistrationService;
use App\Traits\WithSweetAlert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class IrregularAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Curriculum $curriculum;
    public Models\Registration $registration;
    public Models\Prospectus $prospectus;
    public array $selected = [], $origSelectedSubjects = [], $grades = [];
    public string $prospectusSlug, $type = '', $curriculumCode = '';
    public int $prospectusId;
    public $prospectuses;

    public function mount(RegistrationService $registrationService)
    {
        //check if irregular students are allowed to enroll.
        $setting = Models\Setting::latest()->get()->first();
        if (filled($setting)) $this->authorize('view', $setting);

        list($this->prospectusId, $this->type, $this->curriculumCode) = explode( '-', $this->prospectusSlug);

        //check if curriculum exists.
        $this->curriculum = Models\Curriculum::where('code', $this->curriculumCode)->firstOrFail();

        //set prospectus, subject prereqs and coreqs.
        $this->prospectus = Models\Prospectus::findOrFail($this->prospectusId);
        $this->prospectuses = Models\Prospectus::with([
                'subjects' => function($query) {
                    return $query->where('curriculum_id', $this->curriculum->id)->get();
                },
                'subjects.prerequisites',
                'subjects.corequisites',
            ])
            ->orderBy('id', 'DESC')->getAllPrecedingProspectuses($this->prospectus, TRUE);

        //get all grades.
        $registrations = Models\Registration::where('student_id', auth()->user()->student->id)
            ->whereIn('status_id', [4,6])
            ->get();
        $registrationsIds = $registrations->pluck('id')->toArray();

        $grades = Models\Grade::whereIn('registration_id', $registrationsIds)->get();

        if (filled($registrations) && filled($grades)) {
            foreach ($grades as $grade) {
                $this->grades[$grade->prospectus_subject->subject->id] = ['prospectusSubjectId' => $grade->prospectus_subject->subject->id, 'mark' => $grade->mark->name_element,
                    'value' => $grade->value ?? 'N/A', 'is_passed' => $grade->mark_id==4];
            }
        }

        //get all subjects eligible for enrollment/retake.
        foreach ($this->prospectuses as $prospectus) {
            $subjects = [];

            foreach ($prospectus->subjects as $subject) {
                $subjects[] = $subject->id;

                //remove if subject is taken but failed.
                if (array_key_exists($subject->id, $this->grades)
                        && $this->grades[$subject->id]['is_passed'] == TRUE) {
                    unset($subjects[array_search($subject->id, $subjects)]);
                }

                //remove subject if one of pre-requisites is failed.
                $preRequisiteIsFailed = FALSE;
                foreach ($subject->prerequisites as $requisite) {
                    if ( array_key_exists($requisite->id, $this->grades) && $this->grades[$requisite->id]['is_passed'] == FALSE) {
                        $preRequisiteIsFailed = TRUE;
                    }
                }

                if ($preRequisiteIsFailed) unset($subjects[array_search($subject->id, $subjects)]);
            }

            $this->selected[] = $subjects;
        }

        $this->origSelectedSubjects = $this->selected;
    }

    public function render() { return
        view('livewire.student.registration-component.irregular-add-component');
    }

    public function save()
    {
        $this->authorize('register', $this->prospectus);

        try {
            $registration = (new RegistrationIrregularService())->store($this->prospectuses, auth()->user()->student->id, $this->curriculum->id, $this->selected);

            return redirect()->route('pre.registration.view', $registration->id);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
