<?php

namespace App\Http\Livewire\Forms\Education;

use App\Models\Level;
use App\Models\SchoolType;
use App\Models\AttendedSchool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EducationForm extends Component
{
    use AuthorizesRequests;

    public $student = null;
    public $student_id = null;
    public $attended_school = null;
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
        return view('livewire.forms.education.education-form');
    }

    public function mount()
    {
        if (is_null($this->student)) {
            $this->student_id = Auth::user()->student->id;
        } else {
            $this->student_id =  $this->student->id;
        }

        $this->types = SchoolType::all();

        $this->levels = collect();

        $this->attended_school = AttendedSchool::select([
                'id',
                'name',
                'date_graduated',
                'program',
                'school_type_id',
                'level_id',
            ])
            ->where('student_id', $this->student_id)
            ->first();

        if(!is_null($this->attended_school)){
            $this->school_name = $this->attended_school->name ?? '';
            $this->date_of_grad = $this->attended_school->date_graduated ?? '';
            $this->prog_track_spec = $this->attended_school->program ?? '';
            $this->selectedType = $this->attended_school->school_type_id ?? '';
            $this->levels =  Level::where('school_type_id', $this->attended_school->school_type_id)->get();
            $this->selectedLevel = $this->attended_school->level_id ?? '';
        }
    }
    
    public function updatedSelectedType($type)
    {
        $this->levels = Level::where('school_type_id', $type)->get();

        $this->selectedLevel = null;
    }

    public function updateEducationInfo()
    {
        $this->validate();

        if (is_null($this->attended_school)) {
            $this->authorize('create', AttendedSchool::class);
            $this->attended_school = AttendedSchool::create([
                'name' => $this->school_name,
                'date_graduated' => $this->date_of_grad,
                'program' => $this->prog_track_spec,
                'school_type_id' => $this->selectedType,
                'level_id' => $this->selectedLevel,
                'student_id' => $this->student_id,
            ]);
        } else {
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

        if (Auth::user()->role->name == 'student') {
            $this->emit('completed');
        };
    }
}
