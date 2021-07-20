<?php

namespace App\Http\Livewire\Student;

use App\Models\Registration;
use App\Models\Section;
use App\Models\Status;
use App\Services\Sections;
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
                            'grades:id,registration_id,subject_id',
                            'grades.subject:id,code,title,unit',
                            'grades.subject.requisites',
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

        $isSectionFull = (new Sections())->isFull($this->registration->section_id);

        if ($isSectionFull) {
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Oops Sorry..",
                'type' => "error",
                'text' => "Sorry but this section is already full.",
            ]);
        }

        $this->validate();

        $status = Status::where('name', 'enrolled')->firstOrFail();
        $this->registration->released_at = null;
        $this->registration->status_id = $status->id;
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

        $status = Status::where('name', 'pending')->firstOrFail();

        $this->registration->section_id = null;
        $this->registration->status_id = $status->id;
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

        $status = Status::where('name', 'denied')->firstOrFail();

        $this->registration->section_id = null;
        $this->registration->status_id = $status->id;
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
            'studentId' => $this->registration->student->custom_id,
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
