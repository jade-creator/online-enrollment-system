<?php

namespace App\Http\Livewire\Admin\GradeComponent;

use App\Models\Registration;
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
    public bool $selectAll = TRUE;
    public array $grades = [];
    public float $grade = 0;

    public function mount()
    {
        $this->registration =  Registration::preRegistered($this->regId);

        $this->authorize('exportGrade', $this->registration);

        foreach ($this->registration->grades as $grade) {
            $this->grades[] = [TRUE, $grade->value ?? 0];
        }

        $this->compute();
    }

    public function render() { return
        view('livewire.admin.grade-component.grade-pdf-component');
    }

    public function compute()
    {
        $this->grade = 0;
        $count = 0;

        foreach ($this->grades as $grade) {
            if ($grade[0]) {
                $this->grade += $grade[1];
                $count++;
            }
        }

        if ($this->grade == 0) return;

        $this->grade = $this->grade / $count;
    }

    public function updatedGrades()
    {
        $this->compute();

        $this->selectAll = FALSE;
    }

    public function updatedSelectAll($value)
    {
        if (! $value) {
            $this->grades = array_map(function($grade) {
                return [FALSE, $grade[1] ?? 0];
            }, $this->grades);
        } else {
            $this->grades = array_map(function($grade) {
                return [TRUE, $grade[1] ?? 0];
            }, $this->grades);
        }

        $this->compute();
    }

    public function createPdf()
    {
        $collectionGrades = new Collection();

        foreach ($this->registration->grades as $key => $grade) {
            if ($this->grades[$key][0]) {
                $collectionGrades->push($grade);
            }
        }

        try {
            $pdf = PDF::loadView('pdf.grade', [
                'registration' => $this->registration,
                'collectionGrades' => $collectionGrades,
                'computedGrade' => $this->grade,
            ])->output();

            $this->info('Please wait for the file to be downloaded...');

            return response()->streamDownload(
                fn () => print($pdf),
                $this->registration->student->user->person->full_name . '-grade.pdf'
            );
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
