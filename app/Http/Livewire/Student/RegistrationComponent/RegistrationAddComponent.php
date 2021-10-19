<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models;
use App\Services\Prospectus\ProspectusSubjectService;
use App\Services\Registration\RegistrationService;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegistrationAddComponent extends Component
{
    use AuthorizesRequests, Traits\WithSweetAlert;

    public Models\Registration $registration;
    public ?Models\Setting $setting = null;
    public string $classification = '', $type = '', $levelId = '', $programId = '', $termId = '';

    public function rules()
    {
        return [
            'classification' => ['required', 'string'],
            'type' => ['required', 'string'],
            'programId' => ['required'],
            'levelId' => ['required'],
            'termId' => ['required'],
        ];
    }

    public function mount() {
        $this->fill([
            'registration' => new Models\Registration(),
            'programId' => auth()->user()->student->program_id,
            'classification' => auth()->user()->student->isRegular ? 'regular' : 'irregular',
            'type' => auth()->user()->student->isNew ? 'new' : 'old',
        ]);
    }

    public function render() { return
        view('livewire.student.registration-component.registration-add-component');
    }

    /**
     * @throws \Exception
     */
    public function next()
    {
        $this->validate();

        $this->setting = Models\Setting::latest()->get()->first();

        try {
            //check if irregular students are allowed to enroll.
            if ($this->classification == 'irregular' && filled($this->setting)) $this->authorize('view', $this->setting);

            //check if curriculum exists.
            $curriculum = auth()->user()->student->curriculum;
            if (empty($curriculum)) throw new \Exception('No curriculum found! Please wait a moment or contact the admins.');

            //search for duplicate regular registration.
            $prospectus = Models\Prospectus::select('id')
                ->findSpecificProspectus($this->programId, $this->levelId, $this->termId);
            (new RegistrationService())->searchDuplicate($prospectus->id, auth()->user()->student->id);

            return redirect()->route('student.registrations.'.$this->classification.'.create', $prospectus->id.'-'.$this->type.'-'.$curriculum->code);
        } catch (\Exception $e) {
            $this->emit('error');

            return session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getLevelsProperty()
    {
        $type = Models\SchoolType::filterByType('College');

        return $type->levels;
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }
}
