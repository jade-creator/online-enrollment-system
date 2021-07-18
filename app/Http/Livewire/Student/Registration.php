<?php

namespace App\Http\Livewire\Student;

use App\Models;
use App\Models\Grade;
use App\Models\Level;
use App\Models\Mark;
use App\Models\Program;
use App\Models\Prospectus;
use App\Models\Strand;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Registration extends Component
{
    use AuthorizesRequests;

    public Models\Registration $registration;
    public $steps = 2, $currentStep = 1;
    public $prospectus, $levelId, $programId, $strandId, $termId;
    public bool $selectAll = true;
    public array $selected = [];

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
        if ($this->currentStep == $this->steps) return;

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
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Error!",
                'type' => "error",
                'text' => "Internal Error. Please contact the admin.",
            ]);
        }

        if (!$this->prospectus->subjects()->exists()) {
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Unable Action!",
                'type' => "error",
                'text' => "There are no subjects under this prospectus. Please fill out the fields accordingly. If error persists please contact the admin.",
            ]);
        }

        if ($this->selectAll) $this->pluckRows($this->prospectus->subjects);

        $this->currentStep++;
    }

    public function updatedSelected()
    {
        $this->selectAll = false;
    }

    public function updatedSelectAll(bool $value)
    {
        if ($value) return $this->pluckRows($this->prospectus->subjects);
        
        $this->updatedSelected();
        $this->selected = [];
    }

    public function pluckRows($data)
    {
        $this->selected = $data->pluck('id')->toArray();
    }

    public function save()
    {
        if (empty($this->selected)) {
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Error!",
                'type' => "error",
                'text' => "No Selected Subject/s.",
            ]);
        }

        $this->authorize('create', Registration::class);

        $this->registration->student_id = Auth::user()->student->id;
        $this->registration->prospectus_id = $this->prospectus->id;

        $status = Status::where('name', 'pending')->firstOrFail();
        $this->registration->status_id = $status->id;
        $this->registration->save();

        $mark = Mark::where('name', 'tba')->firstOrFail();
        $grades = [];

        foreach ($this->selected as $id) {
            $grades[] = new Grade([
                'subject_id' => $id,
                'mark_id' => $mark->id,
            ]);
        }

        $this->registration->grades()->saveMany($grades);


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