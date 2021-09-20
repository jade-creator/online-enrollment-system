<?php

namespace App\Http\Livewire\Partials;

use App\Models;
use App\Services\Registration\RegistrationStatusService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use PDF;

class RegistrationFormButtons extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Registration $registration;
    public bool $enrollingStudent = false;
    public string $studentId = '';

    protected $listeners = [
        'pending',
        'reject',
        'submitSchedule',
        'finalize',
        'enroll',
    ];

    public function mount() {
        $this->studentId = $this->registration->student->custom_id;
    }

    public function render() { return
        view('livewire.partials.registration-form-buttons', ['sections' => $this->getSections()]);
    }

    public function authorizeAction(string $action, string $message)
    {
        try {
            $this->authorize($action, $this->registration);
            (new RegistrationStatusService())->$action($this->registration);

            $this->enrollingStudent = false;
            $this->success($message);
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function enrollConfirm() { return
        $this->confirm('enroll', "Are you sure?. ");
    }

    public function enroll() {
        $this->authorizeAction('enroll', $this->registration->student->user->person->full_name.' has been enrolled');
    }

    public function finalizeConfirm() { return
        $this->confirm('finalize', "Are you sure? Click 'OK' for assessment.");
    }

    public function finalize() {
        $this->authorizeAction('confirm', $this->registration->student->user->person->full_name."'s registration has been finalized. Please pay the fee/s.");
    }

    public function pendingConfirm() { return
        $this->confirm('pending', "Are you sure? Registration's status will be changed to 'pending'.");
    }

    public function pending() {
        $this->authorizeAction('pending', $this->registration->student->user->person->full_name."'s registration is on pending.");
    }

    //submit confirm student submit reg for assessment.
    public function submit() { return
        $this->confirm('submitSchedule', "Are you sure? Please check the schedule, it will not be submitted if there's a conflict. Section/s cannot be change once submitted.");
    }

    //student submit reg for assessment.
    public function submitSchedule() {
        $this->authorizeAction('submit', "Hi! ".$this->registration->student->user->person->full_name.' your registration is submitted
        please wait for the assessment. Thank you!');
    }

    public function rejectConfirm() { return
        $this->confirm('reject', "Are you sure? Registration's status will be rejected.");
    }

    public function reject() {
        $this->authorizeAction('reject', $this->registration->student->user->person->full_name."'s registration was rejected.");
    }

    public function getSections() { return
        Models\Section::where('prospectus_id', $this->registration->prospectus_id)
            ->get(['id', 'name']);
    }

    public function createPDF()
    {
        $pdf = PDF::loadView('pdf.registration', ['registration' => $this->registration])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $this->registration->student->user->person->full_name . '.pdf'
        );
    }
}
