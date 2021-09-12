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
//    public bool $selectAll = true;
//    public array $selected = [];
//    public int $steps = 2, $currentStep = 1;
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
        $this->registration = new Models\Registration();
    }

    public function render() { return
        view('livewire.student.registration-component.registration-add-component');
    }

//    public function save()
//    {
//        try {
//            (new RegistrationService())->store($this->selected, $this->registration, $this->prospectus, Auth::user()->student->id);
//            return redirect()->route('student.registrations.index');
//        } catch (\Exception $e) {
//            $this->error($e->getMessage());
//        }
//    }

//    public function previous()
//    {
//        if ($this->currentStep == 1) return;
//
//        $this->currentStep--;
//    }

    /**
     * @throws \Exception
     */
    public function next()
    {
//        if ($this->currentStep == $this->steps) return;

        $this->validate();

        try {
//            $prospectus = (new ProspectusSubjectService())->register($this->programId, $this->levelId, $this->termId);
//            if ($this->selectAll) $this->pluckRows($prospectus->subjects);
//            $this->currentStep++;
             $prospectus = Models\Prospectus::select('id')
                ->findSpecificProspectus($this->programId, $this->levelId, $this->termId);

            return redirect()->route('student.registrations.'.$this->classification.'.create', [$prospectus->id.'-'.$this->type]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

//    public function updatedSelectAll(bool $value)
//    {
//        if ($value) return $this->pluckRows($this->prospectus->subjects);
//
//        $this->updatedSelected();
//        $this->selected = [];
//    }

//    public function pluckRows($data) {
//        $this->selected = $data->pluck('id')->toArray();
//    }

//    public function updatedSelected() {
//        $this->selectAll = false;
//    }

    public function getLevelsProperty()
    {
        $type = Models\SchoolType::filterByType('College');

        return $type->levels;
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }
}
