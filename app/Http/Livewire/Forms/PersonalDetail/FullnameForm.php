<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use Livewire\Component;

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
        if($this->person){
            $this->firstname = $this->person->firstname;
            $this->middlename = $this->person->middlename;
            $this->lastname = $this->person->lastname;
            $this->suffix = $this->person->suffix;
        }
    }

    public function updateFullname()
    {
        $this->validate();
        empty(trim($this->suffix)) ? $this->suffix = null : $this->suffix;
        $this->person->update([
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'suffix' => $this->suffix,
        ]);
        $this->emit('saved');
    }
}
