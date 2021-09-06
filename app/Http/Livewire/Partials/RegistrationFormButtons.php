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
    ];

    public function rules()
    {
        return ['registration.section_id' => ['required', 'integer']];
    }

    public function mount() {
        $this->studentId = $this->registration->student->custom_id;
    }

    public function render() { return
        view('livewire.partials.registration-form-buttons', ['sections' => $this->getSections()]);
    }

    public function authorizeAction(string $action, string $message)
    {
        $this->authorize($action, $this->registration);

        try {
            (new RegistrationStatusService())->$action($this->registration);

            $this->enrollingStudent = false;
            $this->emitUp('refresh');
            $this->success($message);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function rejectConfirm() { return
        $this->confirm('reject', "Are you sure? Registration's status will be rejected.");
    }

    public function reject() {
        $this->authorizeAction('reject', $this->registration->student->user->person->full_name."'s registration was rejected.");
    }

    public function pendingConfirm() { return
        $this->confirm('pending', "Are you sure? Registration's status will be on pending.");
    }

    public function pending() {
        $this->authorizeAction('pending', $this->registration->student->user->person->full_name."'s registration is on pending.");
    }

    public function enroll()
    {
        $this->validate();
        $this->authorizeAction('enroll', $this->registration->student->user->person->full_name.' has been enrolled');
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
