<?php

namespace App\Http\Livewire\Admin\PreEnrollmentComponent;

use App\Models;
use App\Services\Registration\RegistrationIrregularService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class StudentIrregularAddComponent extends Component
{
    use AuthorizesRequests;

    public Models\Curriculum $curriculum;
    public Models\Student $student;
    public ?Models\Registration $registration = null;
    public Models\Prospectus $prospectus;
    public array $selected = [], $origSelectedSubjects = [], $grades = [];
    public string $prospectusSlug = '', $prospectusId = '', $type = '', $curriculumCode = '';
    public $prospectuses;

    public function mount()
    {
        list($this->prospectusId, $this->type, $this->curriculumCode) = explode( '-', $this->prospectusSlug);

        //check if curriculum exists.
        $this->curriculum = Models\Curriculum::where('code', $this->curriculumCode)->firstOrFail();

        //set prospectus, subject prereqs and coreqs.
        $this->prospectus = Models\Prospectus::findOrFail($this->prospectusId);
    }

    public function render() { return
        view('livewire.admin.pre-enrollment-component.student-irregular-add-component', ['prospectuses' => $this->getProspectuses()]);
    }

    public function getProspectuses()
    {
        $this->prospectuses = Models\Prospectus::with([
                'subjects' => function($query) {
                    $query->with([
                        'subject' => function ($query) { $query->withTrashed(); },
                    ])
                        ->where('curriculum_id', $this->curriculum->id)
                        ->get();
                },
                'subjects.prerequisites',
                'subjects.corequisites',
            ])
            ->orderBy('id', 'DESC')->getAllPrecedingProspectuses($this->prospectus, TRUE);

        if (filled($this->selected)) return $this->prospectuses;

        //get all grades.
        $registrations = Models\Registration::where('student_id', $this->student->id)
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

        return $this->prospectuses;
    }

    public function save()
    {
        try {
            //check if subjects in current/latest semester is empty.
            if ( empty($this->selected[0])
                || empty(array_filter($this->selected[0], 'strlen')) ) {
                throw new \Exception('Please select a subject in the latest/current semester.');
            }

            if (filled($this->registration)) $this->authorize('edit', $this->registration);

            $this->authorize('register', $this->prospectus);

            if (is_null($this->registration)) {
                $registration = (new RegistrationIrregularService())->store($this->prospectuses, $this->student->id, $this->curriculum->id, $this->selected);
            } else {
                $registration = (new RegistrationIrregularService())->update($this->registration, $this->prospectuses, $this->curriculum->id, $this->selected);
            };

            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Saved successfully.',
            ]);
//            $this->emit('alert');

            return redirect()->route('pre.registration.view', $registration->id);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);

//            return $this->emit('alert');
        }
    }
}