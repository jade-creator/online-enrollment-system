<?php

namespace App\Http\Livewire\Admin\GradeComponent;

use App\Models\Registration;
use App\Services\Schedule\ScheduleService;
use App\Traits\WithSweetAlert;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use PDF;

class GradePdfComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Registration $registration;
    public string $regId = '';
    public array $grades = [], $notComputed = [], $incompleteComputed = [], $professors = [];
    public float $grade = 0;

    protected $listeners = ['createPdf'];

    public function populateGrades(Registration $registration)
    {
        foreach ($registration->grades as $grade) {
            if ($grade->prospectus_subject->isComputed && is_null($grade->value)) {
                $this->incompleteComputed[] = [$grade->prospectus_subject->subject->code, $grade->value];
            } elseif ($grade->prospectus_subject->isComputed) {
                $this->grades[] = [$grade->prospectus_subject->subject->code, $grade->value];
            }
            else {
                $this->notComputed[] = [$grade->prospectus_subject->subject->code, $grade->value];
            }
        }
    }

    public function mount()
    {
        $this->registration =  Registration::preRegistered($this->registration->id);

        $scheduleService = new ScheduleService();
        $this->professors = $scheduleService->populateProfessors($this->registration);

        $this->populateGrades($this->registration);

        foreach ($this->registration->extensions as $extension) {
            $this->professors += $scheduleService->populateProfessors($extension->registration);

            $this->populateGrades($extension->registration);
        }

        $this->compute();
    }

    public function render() { return
        view('livewire.admin.grade-component.grade-pdf-component');
    }

    public function compute()
    {
        if (count($this->incompleteComputed) > 0) return;

        $cwa = 0;

        foreach ($this->grades as $grade) {
            $cwa += $grade[1];
        }

        if ($cwa == 0) return;

        $this->grade = $cwa / count($this->grades);
    }

    public function createPdf()
    {
        try {
            $pdf = PDF::loadView('pdf.grade', [
                'registration' => $this->registration,
                'professors' => $this->professors,
                'computedGrade' => $this->grade,
                'grades' => $this->grades,
                'notComputed' => $this->notComputed,
            ])->output();

            $this->info('Please wait for the file to be downloaded...');

            return response()->streamDownload(
                fn () => print($pdf),
                $this->registration->student->user->person->full_name . '-grade-report.pdf'
            );
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function downloadConfirm() { return
        $this->confirm('createPdf', 'Are you sure? Please click "OK" to confirm.');
    }
}
