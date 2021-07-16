<?php

namespace App\Http\Livewire\Student;

use App\Models\Registration;
use App\Models\Section;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PDF;

class PreRegistrationComponent extends Component
{
    use AuthorizesRequests;

    public Registration $registration;
    public $enrollingStudent = false;
    public $regId, $studentId;

    protected $listeners = ['reject', 'toggleEnrollingStudent'];

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
                            'prospectus.fees',
                            'section',
                            'subjects',
                        ])
                        ->findOrFail($this->regId);

        $this->authorize('view', $this->registration);
    }

    public function render() { return 
        view('livewire.student.pre-registration-component');
    }

    public function enroll()
    {
        $this->authorize('update', $this->registration);

        $this->validate();
        $this->registration->status_id = 3;
        $this->registration->save();

        $student = $this->registration->student;

        if (!$student->isStudent) {
            $student->isStudent = true;
            $student->save();
        }

        $this->dispatchBrowserEvent('swal:successEnroll', [ 
            'text' => "The student has been enrolled.",
        ]);
    }

    public function pending()
    {
        $this->authorize('update', $this->registration);

        $this->registration->section_id = null;
        $this->registration->status_id = 2;
        $this->registration->save();

        return redirect(route('pre.registration.view', ['regId' => $this->regId]));
    }

    public function rejectConfirm()
    {
        $this->dispatchBrowserEvent('swal:confirmReject', [ 
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => "This action will remove the student from it's current section.",
        ]);
    }

    public function reject()
    {
        $this->authorize('update', $this->registration);

        $this->registration->section_id = null;
        $this->registration->status_id = 4;
        $this->registration->save();

        return redirect(route('pre.registration.view', ['regId' => $this->regId]));
    }

    public function toggleEnrollingStudent()
    {
        $this->fill([ 'enrollingStudent' => !$this->enrollingStudent ]);
    }

    public function updatedEnrollingStudent() 
    { 
        $this->fill([
            'studentId' => $this->registration->student->custom_student_id,
        ]);
    }

    public function createPDF()
    {
        $pdf = PDF::loadView('pdf.registration', ['registration' => $this->registration])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $this->registration->student->user->person->full_name . '.pdf'
        );
    }

    public function getSectionsProperty() { return 
        Section::where('prospectus_id', $this->registration->prospectus_id)
            ->get(['id', 'name']);
    }
}
