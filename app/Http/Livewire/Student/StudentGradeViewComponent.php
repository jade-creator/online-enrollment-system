<?php

namespace App\Http\Livewire\Student;

use App\Models;
use Livewire\Component;

class StudentGradeViewComponent extends Component
{
    public Models\Prospectus $prospectus;
    public string $prospectusId = '';

    public function mount() {
        $this->prospectus = Models\Prospectus::select(['id', 'level_id', 'program_id', 'term_id'])->findOrFail($this->prospectusId);
    }

    public function render() { return
        view('livewire.student.student-grade-view-component', ['registrations' => $this->getAllRegistrations()]);
    }

    public function getAllRegistrations() { return
        Models\Registration::filterByStudent(auth()->user()->student->id)
            ->with([
                'grades:id,registration_id,subject_id,mark_id,value',
                'grades.mark',
                'grades.prospectus_subject',
                'grades.prospectus_subject.subject:id,code,title',
                'grades.prospectus_subject.prerequisites',
                'grades.prospectus_subject.corequisites',
            ])
            ->where('prospectus_id', $this->prospectus->id)
            ->get();
    }
}
