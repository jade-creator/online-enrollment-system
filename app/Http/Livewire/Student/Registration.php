<?php

namespace App\Http\Livewire\Student;

use App\Models\Level;
use App\Models\Program;
use App\Models\Prospectus;
use App\Models;
use App\Models\Strand;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Registration extends Component
{
    use AuthorizesRequests;

    public Models\Registration $registration;
    public $steps = 2, $currentStep = 1;
    public $prospectus, $levelId, $programId, $strandId, $termId;

    public function rules()
    {
        return [
            'registration.isNew' => ['required'],
        ];
    }

    public function mount() 
    {
        $levels = $this->levels->first();

        $this->fill([ 
            'registration' => new Models\Registration(),
            'levelId' => $levels->id,
        ]);
    }

    public function render() { return 
        view('livewire.student.registration');
    }

    public function next() 
    {
        $this->validate();

        $this->prospectus = Prospectus::select(['id', 'level_id', 'program_id', 'strand_id', 'term_id'])
            ->with('subjects.requisites')
            ->when(!empty($this->levelId), function($query) {
                return $query->where('level_id', $this->levelId);
            })
            ->when(!empty($this->programId), function($query) {
                return $query->where('program_id', $this->programId);
            })
            ->when(!empty($this->strandId), function($query) {
                return $query->where('strand_id', $this->strandId);
            })
            ->when(!empty($this->termId), function($query) {
                return $query->where('term_id', $this->termId);
            })
            ->first();

        if (!$this->prospectus) {
            return \Debugbar::info([
                'error' => 'Unable to proceed.'
            ]);
        }

        if (!$this->prospectus->subjects()->exists()) {
            return \Debugbar::info([
                'error' => 'Unable to proceed. Has no subject yet.'
            ]);
        }

        \Debugbar::info([
            'first' => $this->prospectus
        ]);

        if ($this->currentStep == $this->steps) {
            return;
        }

        $this->currentStep++;
    }

    public function save()
    {
        $this->authorize('create', Registration::class);

        $this->registration->student_id = Auth::user()->student->id;
        $this->registration->prospectus_id = $this->prospectus->id;
        $this->registration->save();

        // $student = Student::find(Auth::user()->student->id);

        // if (!$student->isStudent) {
        //     $student->isStudent = true;
        //     $student->save();
        // }

        return redirect(route('student.registration'));
    }

    public function previous() 
    {
        if ($this->currentStep == 1) {
            return;
        }

        $this->currentStep--;
    }
    
    public function updatedLevelId()
    {
        $this->fill([
            'programId' => '',
            'strandId' => '',
            'termId' => '',
        ]);
    }

    public function getLevelsProperty() { return
        Level::get(['id', 'level']);
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'code']);
    }

    public function getStrandsProperty() { return
        Strand::get(['id', 'code']);
    }
}