<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Person;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FullnameForm extends Component
{
    public $person;
    public $firstname;
    public $middlename;
    public $lastname;
    public $suffix;
    
    protected $rules = [
        'firstname' => [ 'required', 'max:255'],
        'middlename' => [ 'required', 'max:255'],
        'lastname' => [ 'required', 'max:255'],
        'suffix' => ['max:255'],
    ];

    public function render()
    {
        return view('livewire.forms.personal-detail.fullname-form');
    }

    public function mount()
    {
        $this->person = Auth::user()->person;
        if($this->person){
            $this->firstname = $this->person->firstname;
            $this->middlename = $this->person->middlename;
            $this->lastname = $this->person->lastname;
            $this->suffix = $this->person->suffix;
        }
    }

    public function updateOrCreateFullname()
    {
        $this->validate();
        empty(trim($this->suffix)) ? $this->suffix = null : $this->suffix;
        
        if(!Auth::user()->person_id){
            $this->person = Person::create([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
                'suffix' => $this->suffix,
                'isCompleteDetail' => false,
            ]);
            Auth::user()->update([ 'person_id' => $this->person->id]);
        }else{
            Auth::user()->person()->update([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
                'suffix' => $this->suffix,
            ]);
        }
        
        $this->emit('saved');
        $this->emit('proceed', 2);
    }
}
