<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models;
use App\Services\Prospectus\ProspectusSubjectService;
use App\Services\Registration\RegistrationService;
use App\Traits;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegistrationAddComponent extends Component
{
    use Traits\WithSweetAlert;

    public Models\Registration $registration;
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

        try {
            $curriculum = Models\Curriculum::findActiveCurriculum($this->programId);

            if (empty($curriculum)) throw new \Exception('No active curriculum! Please wait a moment or contact the admins.');

             $prospectus = Models\Prospectus::select('id')
                ->findSpecificProspectus($this->programId, $this->levelId, $this->termId);

            return redirect()->route('student.registrations.'.$this->classification.'.create', $prospectus->id.'-'.$this->type.'-'.$curriculum->code);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
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
