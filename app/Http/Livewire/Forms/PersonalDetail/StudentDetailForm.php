<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Person;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentDetailForm extends Component
{
    public $student;
    public $step = 1;
    protected $listeners = ['proceed', 'completed'];

    public function render()
    {
        return view('livewire.forms.personal-detail.student-detail-form', ['student_id' => $this->student->id]);
    }

    public function mount(){
        $this->create();
    }

    private function create(){
        $this->student = Student::where('user_id', Auth::user()->id)->first();

        if(!$this->student){
            $this->student = Student::create([
                'user_id' => Auth::user()->id,
            ]);

            $custom_id = date("Y"). '-' . $this->student->id;

            $this->student->update([
                'custom_id' => $custom_id,
            ]);
        }
    }

    public function proceed($step){
        $this->step = $step;
    }   

    public function completed(){
        $person = Person::find(Auth::user()->person_id);
        if($person){
            $person->update(['isCompleteDetail' => true]);            
        }
        return redirect('user/personal-details');
    }   

}
