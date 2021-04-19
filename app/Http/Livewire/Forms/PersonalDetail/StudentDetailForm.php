<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Person;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentDetailForm extends Component
{
    public $student = null;
    public $step = 1;
    protected $listeners = ['proceed', 'completed'];

    public function render() 
    {
        return view('livewire.forms.personal-detail.student-detail-form');
    }

    public function mount() 
    {
        $this->student = Auth::user()->student()
            ->firstOr(function () {
                $this->student = Student::create([
                    'user_id' => Auth::user()->id,
                ]);

                $this->student->update([
                    'custom_id' => date("Y"). '-' . $this->student->id,
                ]);

                return $this->student;
            });
    }

    public function proceed($step) 
    {
        $this->step = $step;
    }   

    public function completed() 
    {
        if ($person = Auth::user()->person) {
            $person->update(['isCompleteDetail' => true]);            
        }
        
        return redirect('user/profile');
    }   
}
