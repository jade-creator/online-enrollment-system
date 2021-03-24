<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Person;
use Livewire\Component;
use App\Models\Guardian;
use App\Rules\MobileNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GuardianInfoForm extends Component
{
    use AuthorizesRequests;

    public $guardian;
    public $person;
    public $contact;
    public $student;
    public $firstname;
    public $middlename;
    public $lastname;
    public $suffix;
    public $relationship;   
    public $address;
    public $mobile_number;

    public function rules(){
        return [
            'firstname' => [ 'required', 'max:255'],
            'middlename' => [ 'required', 'max:255'],
            'lastname' => [ 'required', 'max:255'],
            'suffix' => ['max:255'],
            'relationship' => [ 'required', 'max:255'],
            'address' => [ 'required', 'max:255' ],
            'mobile_number' => [ 'required', new MobileNumber],
        ];
    }

    public function mount(){
        
        if ($this->student) {
            $this->guardian = $this->student->guardian;
        }

        if ($this->guardian) {
            $this->person = $this->guardian->person;
            $this->firstname = $this->person->firstname;
            $this->middlename = $this->person->middlename;
            $this->lastname = $this->person->lastname;
            $this->suffix = $this->person->suffix;

            $this->relationship = $this->guardian->relationship;

            $this->contact = $this->person->contact;
            $this->address = $this->contact->address;
            $this->mobile_number = $this->contact->mobile_number;
        }
    }

    public function render()
    {
        return view('livewire.forms.personal-detail.guardian-info-form');
    }

    public function updateGuardian(){
        $this->validate();
        empty(trim($this->suffix)) ? $this->suffix = null : $this->suffix;

        if(!$this->guardian){
            $this->authorize('create', Guardian::class);
            $this->person = Person::create([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
                'suffix' => $this->suffix,
                'isCompleteDetail' => true,
            ]);
            
            $this->contact = $this->person->contact()->create([
                'address' => $this->address,
                'mobile_number' => $this->mobile_number,
            ]);

            $this->guardian = $this->person->guardian()->create([
                'relationship' => $this->relationship,
                'student_id' => $this->student->id,
            ]);
        }else{
            $this->authorize('update', $this->guardian);
            $this->person->update([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
                'suffix' => $this->suffix,
                'isCompleteDetail' => true,
            ]);

            $this->contact->update([
                'address' => $this->address,
                'mobile_number' => $this->mobile_number,
            ]);

            $this->guardian->update([
                'relationship' => $this->relationship,
            ]);
        }

        $this->emit('saved');
        $this->emit('proceed', 5);
    }
}
