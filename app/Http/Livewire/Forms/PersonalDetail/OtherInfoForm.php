<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use Livewire\Component;

class OtherInfoForm extends Component
{
    public $person;
    public $gender;
    public $civil_status;
    public $religion;
    public $nationality;
    public $birthdate;
    public $birthplace;

    protected $rules = [
        'gender' => [ 'max:255'],
        'civil_status' => [ 'max:255'],
        'religion' => [ 'max:255'],
        'nationality' => [ 'required', 'max:255'],
        'birthdate' => [ 'required', 'date'],
        'birthplace' => [ 'required', 'max:255'],
    ];

    public function render()
    {
        return view('livewire.forms.personal-detail.other-info-form');
    }

    public function mount(){
        // person? populate selects : defaults;
        if($this->person){
            $this->populateSelectFields($this->person->gender, $this->person->civil_status, $this->person->religion);
            $this->nationality = $this->person->nationality;
            $this->birthdate = $this->person->birthdate;
            $this->birthplace = $this->person->birthplace;
        }
    }

    public function updateOtherInfo()
    {
        $this->validate();
        $this->person->update([
            'gender' => $this->gender,
            'civil_status' => $this->civil_status,
            'religion' => $this->religion,
            'nationality' => $this->nationality,
            'birthdate' => $this->birthdate,
            'birthplace' => $this->birthplace,
        ]);
        $this->emit('saved');
    }

    public function populateSelectFields($gender, $civil_status, $religion){
        $this->gender = $gender ? $gender : 'Other';
        $this->civil_status = $civil_status ? $civil_status : 'Single';
        $this->religion = $religion ? $religion : 'None';
    }
}
