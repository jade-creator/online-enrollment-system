<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Guardian;
use App\Models\Person;
use Livewire\Component;

class GuardianInfoForm extends Component
{
    public $guardian;
    public $person;
    public $fullname;
    public $relationship;   
    public $address;
    public $mobile_number;

    protected $rules = [
        'fullname' => [ 'required', 'max:255'],
        'relationship' => [ 'required', 'max:255'],
        'address' => [ 'required', 'max:255' ],
        'mobile_number' => [ 'required', 'regex:/(09)[0-9]{9}/'],
    ];

    protected $messages = [
        'mobile_number.regex' => 'The mobile number is invalid. (valid format: 09*********)',
    ];

    public function mount()
    {
        $this->guardian = Person::find($this->person->id)->guardian;
        $this->store();
    }

    public function store(){
        if(!$this->guardian){
            $this->guardian = Guardian::create(['person_id' => $this->person->id]);
        }

        $this->fullname = $this->guardian->fullname;
        $this->relationship = $this->guardian->relationship;
        $this->address = $this->guardian->address;
        $this->mobile_number = $this->guardian->mobile_number;
    }

    public function render()
    {
        return view('livewire.forms.personal-detail.guardian-info-form');
    }

    public function updateGuardian(){
        $this->validate();
        $this->guardian->update([
            'fullname' => $this->fullname,
            'relationship' => $this->relationship,
            'address' => $this->address,
            'mobile_number' => $this->mobile_number,
        ]);
        $this->emit('saved');
    }
}
