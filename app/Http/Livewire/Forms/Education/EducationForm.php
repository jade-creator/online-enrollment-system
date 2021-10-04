<?php

namespace App\Http\Livewire\Forms\Education;

use App\Models\Level;
use App\Models\SchoolType;
use App\Models\AttendedSchool;
use App\Traits\WithSweetAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EducationForm extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public ?int $studentId = null;
    public ?iterable $types = null;
    public ?iterable $levels = null;
    public AttendedSchool $attended;

    protected $rules = [
        'attended.school_type_id' => ['required', 'integer', 'max:255'],
        'attended.level_id' => ['required', 'integer', 'max:255'],
        'attended.name' => ['required', 'string', 'max:255'],
        'attended.program' => ['required', 'string', 'max:255'],
        'attended.date_graduated' => ['required', 'string', 'date'],
    ];

    public function render() { return
        view('livewire.forms.education.education-form');
    }

    public function mount()
    {
        $this->studentId ??= auth()->user()->student->id;

//        $this->types = SchoolType::all();

//        $this->levels = collect();

        $attended = AttendedSchool::select([
                'id',
                'name',
                'date_graduated',
                'program',
                'school_type_id',
                'level_id',
                'student_id',
            ])
            ->where('student_id', $this->studentId)
            ->first();

        if(! is_null($attended)) {
            $this->attended = $attended;
//            $this->levels =  Level::where('school_type_id', $this->attended->school_type_id)->get();
        } else {
            $this->attended = new AttendedSchool();
        }
    }

//    public function updatedAttendedSchoolTypeId($type)
//    {
//        $this->levels = Level::where('school_type_id', $type)->get();
//
//        $this->attended->level_id = null;
//    }

    public function updateEducationInfo()
    {
        $this->validate();

        try {
            if (! $this->attended->exists) {
                $this->attended->student_id = $this->studentId;
                $this->attended->save();
            } else {
                $this->attended->update();
            }

            $this->emit('saved');
            $this->emit('proceed', 6);

            if (auth()->user()->role->name == 'student') $this->emit('completed');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
