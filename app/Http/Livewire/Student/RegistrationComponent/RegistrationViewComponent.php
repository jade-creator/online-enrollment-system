<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models\Registration;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use PDF;

class RegistrationViewComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Registration $registration;
    public float $totalUnit = 0;
    public $regId;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->registration = new Registration();

        $this->authorize('view', $this->registration);
    }

    public function render() { return
        view('livewire.student.registration-component.registration-view-component', ['registration' => $this->getRegistration()]);
    }

    public function getRegistration()
    {
        $this->registration = Registration::preRegistered($this->regId);

        $this->totalUnit = $this->registration->total_unit;
        if (! $this->registration->isExtension && $this->registration->extensions->isNotEmpty()) {
            foreach ($this->registration->extensions as $extension) {
                $this->totalUnit += $extension->registration->total_unit;
            }
        }

        return $this->registration;
    }

    public function createPdf()
    {
        try {
            $pdf = PDF::loadView('pdf.registration', [
                'registration' => $this->registration,
            ])->output();

            $this->info('Please wait for the file to be downloaded...');

            return response()->streamDownload(
                fn () => print($pdf),
                $this->registration->student->user->person->full_name . '-registration.pdf'
            );
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
