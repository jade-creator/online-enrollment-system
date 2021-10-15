<?php

namespace App\Http\Livewire\Student;

use App\Models;
use Livewire\Component;

class StudentGradeViewComponent extends Component
{
    public ?Models\Curriculum $curriculum = null;
    public Models\Prospectus $prospectus;
    public string $prospectusId = '', $curriculumId = '';
    public array $grades = [];

    public function mount() {
        $this->prospectus = Models\Prospectus::select(['id', 'level_id', 'program_id', 'term_id'])->findOrFail($this->prospectusId);
        $registration = Models\Registration::with(['grades.prospectus_subject.subject', 'grades.mark'])
            ->where([
                ['prospectus_id', '=', $this->prospectus->id],
                ['student_id', '=', auth()->user()->student->id],
                ['isRegular', '=', 1],
            ])
            ->latest('created_at')->first();

        if (filled($registration)) {
            $grades = $registration->grades->map(function ($grade){ return
                ['prospectusSubjectId' => $grade->subject_id, 'mark' => $grade->mark->name, 'value' => $grade->value ?? 'N/A'];
            })->toArray();

            foreach($grades as $grade) {
                $this->grades[$grade['prospectusSubjectId']] = $grade;
            }

            $this->curriculum = isset($registration->curriculum) ?? $registration->curriculum;
        }

        if (empty($this->curriculumId)) {
            $this->curriculum = Models\Curriculum::where([
                ['program_id', $this->prospectus->program_id],
                ['isActive', 1]
            ])->first();
        }
    }

    public function render() { return
        view('livewire.student.student-grade-view-component', [
            'prospectusSubjects' => Models\ProspectusSubject::where('curriculum_id', $this->curriculum->id ?? '')
                ->with(['prerequisites', 'corequisites', 'subject'])->getAllSubjectsInProspectus($this->prospectusId),
        ]);
    }
}
