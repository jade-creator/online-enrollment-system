<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Curriculum;
use App\Models\Employee;
use App\Models\Faculty;
use App\Models\Person;
use App\Models\Program;
use App\Models\Student;
use App\Traits\WithSweetAlert;
use Exception;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FullnameForm extends Component
{
    use WithSweetAlert;

    public Person $person;
    public Employee $employee;
    public Student $student;

    protected $rules = [
        'employee.faculty_id' => ['nullable'],
        'employee.salutation' => ['required'],
        'student.program_id' => ['required'],
        'person.firstname' => [ 'required', 'string', 'max:255'],
        'person.middlename' => [ 'required', 'string', 'max:255'],
        'person.lastname' => [ 'required', 'string', 'max:255'],
        'person.suffix' => [ 'nullable', 'string', 'max:255'],
    ];

    public function render() { return
        view('livewire.forms.personal-detail.fullname-form');
    }

    public function mount()
    {
        $user = Auth::user()->load(['person:id,firstname,middlename,lastname,suffix', 'employee']);

        $this->person = $user->person ?? new Person();
        $this->employee = $user->employee ?? new Employee();
        $this->student = $user->student ?? new Student();
    }

    /**
     * @throws Exception
     */
    public function insert()
    {
        DB::beginTransaction();

        try {
            $person_id = DB::table('people')->insertGetId([
                'firstname' => $this->person->firstname,
                'middlename' => $this->person->middlename,
                'lastname' => $this->person->lastname,
                'suffix' => $this->person->suffix,
                'isCompleteDetail' => false,
                "created_at" =>  Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('users')
                ->where('id', auth()->user()->id)
                ->update([
                    'person_id' => $person_id,
                    "updated_at" => Carbon::now()->toDateTimeString()
                ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception("Internal Error");
        }
    }

    public function updateOrCreateFullname()
    {
        $validationArray = $this->rules;

        if (auth()->user()->role->name == 'student') {
            unset($validationArray['employee.faculty_id'], $validationArray['employee.salutation']);
            $this->validate($validationArray);
        } else {
            unset($validationArray['student.program_id']);
            $this->validate($validationArray);
        }

        if (empty(trim($this->person->suffix))) $this->person->suffix = null;

        try {
            if (! $this->person->exists) {
                $this->insert();
            } else {
                $this->person->update();
            }

            if (auth()->user()->role->name !== 'student') {
                $this->employee->update();
            } else {
                $curriculum = Curriculum::findActiveCurriculum($this->student->program_id);

                $this->student->curriculum_id = $curriculum->id ?? NULL;
                $this->student->update();
            };

            $this->emit('saved');
            $this->emit('proceed', 2);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'program']);
    }

    public function getFacultiesProperty() { return
        Faculty::get(['id', 'name']);
    }
}
