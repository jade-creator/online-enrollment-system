<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models\Registration;
use App\Services\Registration\RegistrationService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use PDF;

class RegistrationViewComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public $array = [];
    public Registration $registrationMain;
    public float $totalUnit = 0;
    public $regId;

    protected $listeners = [
        'refresh' => '$refresh',
        'sessionFlashAlert',
    ];

    public function mount() {
        $this->registrationMain = new Registration();
    }

    public function render() { return
        view('livewire.student.registration-component.registration-view-component', ['registration' => $this->getRegistration()]);
    }

    public function getRegistration()
    {
        $this->registrationMain = Registration::with([
                'extensions.registration.grades.prospectus_subject.subject' => function ($query) { $query->withTrashed(); },
                'extensions.registration.classes' => function ($query) {
                    $query->withTrashed()
                        ->with([
                            'prospectusSubject.subject' => function ($query) { $query->withTrashed(); }
                        ]);
                },
            ])
            ->preRegistered($this->regId);

        if ( (auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'registrar')
            && filled($this->registrationMain) && $this->registrationMain->status->name == 'confirming') {

            $this->sessionFlashAlert('unflashed-alert', 'info', 'NOTE: Please review the registrations before confirming.', FALSE);
        }

        if (filled($this->registrationMain) && ! is_null($this->registrationMain->released_at)) {
            $this->sessionFlashAlert('unflashed-alert', 'warning', 'This registration has been archived and it is now "read-only".', FALSE);
        }

        $this->authorize('view', $this->registrationMain);

        $this->totalUnit = (new RegistrationService())->combineTotalUnits($this->registrationMain);

        return $this->registrationMain;
    }

//    public function createPdf()
//    {
//        try {
//            $pdf = PDF::loadView('pdf.registration', [
//                'registration' => $this->registrationMain,
//            ])->output();
//
//            $this->info('Please wait for the file to be downloaded...');
//
//            return response()->streamDownload(
//                fn () => print($pdf),
//                $this->registrationMain->student->user->person->full_name . '-registration.pdf'
//            );
//        } catch (\Exception $e) {
//            $this->error($e->getMessage());
//        }
//    }
}
