<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\User;
use App\Models\Person;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PersonalDetailShow extends Component
{
    public $hasPerson;

    public function render()
    {
        return view('livewire.forms.personal-detail.personal-detail-show',  [
            'person' => $this->hasPerson,
        ]);
    }

     /*
        check if user has person record.
    */
    public function mount()
    {
        $this->user_id = Auth::id();
        $this->hasPerson = User::find($this->user_id)->person;
        $this->store();
    }

    /*
        create person record if false,
        populate field if true.
    */
    public function store()
    {
        if(!$this->hasPerson){
            $this->hasPerson = Person::create(['user_id' => $this->user_id]);
        }
    }
}
