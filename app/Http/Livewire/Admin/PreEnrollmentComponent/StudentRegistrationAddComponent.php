<?php

namespace App\Http\Livewire\Admin\PreEnrollmentComponent;

use App\Models;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class StudentRegistrationAddComponent extends Component
{
    use AuthorizesRequests;

    public Models\Student $student;
    public ?Models\Registration $registration = null;
    public string $classification = '', $type = '', $levelId = '', $programId = '', $programName =  '', $termId = '';
//    public $levels = null;

    public function rules()
    {
        return [
            'classification' => ['required', 'string'],
            'type' => ['required', 'string'],
            'levelId' => ['required'],
            'programId' => ['required'],
            'termId' => ['required'],
        ];
    }

    protected $messages = [
        'classification.required' => 'The classification field cannot be empty.',
        'type.required' => 'The type field cannot be empty.',
        'levelId.required' => 'The level field cannot be empty.',
        'programId.required' => 'The program field cannot be empty.',
        'termId.required' => 'The term field cannot be empty.',
    ];

    public function mount()
    {
        if (is_null($this->registration)) {
            $this->fill([
                'classification' => $this->student->isRegular == 'Regular' ? 'regular' : 'irregular',
                'type' => $this->student->isNew == 'New' ? 'new' : 'old',
                'programId' => $this->student->program_id ?? '',
                'programName' => $this->student->program->program ?? 'N/A',
            ]);
        } else {
            $this->fill([
                'classification' => $this->registration->classification == 'Regular' ? 'regular' : 'irregular',
                'type' => $this->registration->isNew == 'New' ? 'new' : 'old',
                'programId' => $this->registration->prospectus->program_id ?? '',
                'programName' => $this->registration->prospectus->program->program ?? 'N/A',
                'levelId' => $this->registration->prospectus->level_id ?? '',
                'termId' => $this->registration->prospectus->term_id ?? '',
            ]);
        }
    }

    public function render() { return
        view('livewire.admin.pre-enrollment-component.student-registration-add-component', [
            'levels' => Models\Prospectus::select(['level_id', 'program_id'])
                ->where('program_id', $this->student->program_id)
                ->groupBy(['level_id', 'program_id'])
                ->get(),
        ]);
    }

    public function next()
    {
        $this->validate();

        try {
            if (filled($this->registration)) $this->authorize('edit', $this->registration);

            //check if curriculum exists.
            $curriculum = $this->student->curriculum;
            if (empty($curriculum)) throw new \Exception('No curriculum found! Please wait a moment or contact the admins.');

            //search for duplicate regular registration.
            $prospectus = Models\Prospectus::select('id')
                ->findSpecificProspectus($this->programId, $this->levelId, $this->termId);

            $this->emit('saved');

            return redirect()->route('admin.students.'.$this->classification.'.create', ['student' => $this->student,
                'prospectusSlug' => $prospectus->id.'-'.$this->type.'-'.$curriculum->code, 'registration' => $this->registration]);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);

            return $this->emit('alert');
        }
    }

    public function updatedClassification($value) { if ($value == 'irregular') $this->type = 'old'; }

    public function updatedType($value) { if ($value == 'new') $this->classification = 'regular'; }
}
