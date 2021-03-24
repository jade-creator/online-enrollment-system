<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PersonalDetailShow extends Component
{
    public $student;
    public $person;
    public $detail;

    public function render()
    {
        return view('livewire.forms.personal-detail.personal-detail-show');
    }

     /*
        check if user has person record.
    */
    public function mount()
    {
        if(Auth::user()->role->name == 'student'){
            $this->student = Student::where('user_id', Auth::user()->id)->first();
        }
    }
}
