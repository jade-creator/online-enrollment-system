<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Level;
use Livewire\Component;
use App\Models\SchoolType;
use App\Models\AttendedSchool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EducationInfoForm extends Component
{
    use AuthorizesRequests;

    private $role;
    // public $student_id;
    public $student;
    public $attended_school;
    public $types;
    public $levels;
    public $school_name;
    public $prog_track_spec;
    public $date_of_grad;

    public $selectedType = null;
    public $selectedLevel = null;

    protected $rules = [
        'selectedType' => ['required', 'max:255'],
        'selectedLevel' => ['required', 'max:255'],
        'school_name' => ['required', 'max:255'],
        'prog_track_spec' => ['max:255'],
        'date_of_grad' => ['required', 'date'],
    ];

    public function render()
    {
        return view('livewire.forms.personal-detail.education-info-form');
    }

    public function mount(){
        $this->types = SchoolType::all();
        $this->levels = collect();

        // $this->attended_school = AttendedSchool::where('student_id', $this->student_id)->first();
        if($this->student){
            $this->attended_school = $this->student->attendedSchool;
        }

        if($this->attended_school){
            $this->school_name = $this->attended_school->name;
            $this->date_of_grad = $this->attended_school->date_graduated;
            $this->prog_track_spec = $this->attended_school->program;
            $this->selectedType = $this->attended_school->school_type_id;
            $this->levels =  Level::where('school_type_id', $this->attended_school->school_type_id)->get();
            $this->selectedLevel = $this->attended_school->level_id;
        }
    }
    
    public function updatedSelectedType($type){
        $this->levels = Level::where('school_type_id', $type)->get();
        $this->selectedLevel = null;
    }

    public function updateEducationInfo(){
        $this->validate();

        if(!$this->attended_school){
            $this->authorize('create', AttendedSchool::class);
            $this->attended_school = AttendedSchool::create([
                'name' => $this->school_name,
                'date_graduated' => $this->date_of_grad,
                'program' => $this->prog_track_spec,
                'school_type_id' => $this->selectedType,
                'level_id' => $this->selectedLevel,
                'student_id' => $this->student->id,
            ]);
        }else{
            $this->authorize('update', $this->attended_school);
            $this->attended_school->update([
                'name' => $this->school_name,
                'date_graduated' => $this->date_of_grad,
                'program' => $this->prog_track_spec,
                'school_type_id' => $this->selectedType,
                'level_id' => $this->selectedLevel,
            ]);
        }

        $this->emit('saved');
        $this->emit('proceed', 6);

        if(Auth::user()->role->name == 'student'){
            $this->emit('completed');
        };
    }
}
