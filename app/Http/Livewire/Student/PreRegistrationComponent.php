<?php

namespace App\Http\Livewire\Student;

use App\Models\Registration;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PreRegistrationComponent extends Component
{
    public Registration $registration;
    public $enrollingStudent = false;
    public $regId, $studentId;

    public function rules()
    {
        return [
            'registration.section_id' => ['required', 'numeric'],
        ];  
    }

    public function mount()
    {
        $this->registration = Registration::with([
                            'student.user.person.contact',
                            'student.user.person.detail.country',
                            'status',
                            'prospectus.level',
                            'prospectus.program',
                            'prospectus.strand.track',
                            'prospectus.term',
                            'prospectus.subjects',
                            'prospectus.fees',
                            'section',
                        ])
                        ->findOrFail($this->regId);
    }

    public function render() { return 
        view('livewire.student.pre-registration-component');
    }

    public function enroll()
    {
        $this->validate();
        $this->registration->status_id = 3;
        $this->registration->save();

        $student = Student::find(Auth::user()->student->id);

        if (!$student->isStudent) {
            $student->isStudent = true;
            $student->save();
        }

        return redirect(route('pre.registration.view', ['regId' => $this->regId]));
    }

    public function pending()
    {
        $this->registration->section_id = null;
        $this->registration->status_id = 2;
        $this->registration->save();

        return redirect(route('pre.registration.view', ['regId' => $this->regId]));
    }

    public function reject()
    {
        $this->registration->section_id = null;
        $this->registration->status_id = 4;
        $this->registration->save();

        return redirect(route('pre.registration.view', ['regId' => $this->regId]));
    }

    public function updatedenrollingStudent() 
    {
        $this->fill([
            'studentId' => Auth::user()->student->custom_student_id,
        ]);
    }

    public function getSectionsProperty() { return 
        Section::where('prospectus_id', $this->registration->prospectus_id)
            ->get(['id', 'name']);
    }
}
