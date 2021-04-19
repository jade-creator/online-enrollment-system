<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PersonalDetailShow extends Component
{
    public $student = null;

    public function render() 
    {
        return view('livewire.forms.personal-detail.personal-detail-show');
    }

    public function mount() 
    {
        if (Auth::user()->role->name == 'student') {
            $this->student = Auth::user()->student;
        }
    }
}
