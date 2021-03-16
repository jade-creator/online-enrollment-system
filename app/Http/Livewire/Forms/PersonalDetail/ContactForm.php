<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Contact;
use App\Models\Person;
use Livewire\Component;

class ContactForm extends Component
{
    public $contact;
    public $person;
    public $address;
    public $mobile_number;

    protected $rules = [
        'address' => [ 'required', 'max:255' ],
        'mobile_number' => [ 'required', 'regex:/(^09)[0-9]{9}$/'],
    ];

    protected $messages = [
        'mobile_number.regex' => 'The mobile number is invalid. (valid format: 09*********) Note: Remove spaces',
        // 'mobile_number.size' => 'The mobile number should compose of exactly 11 digits.',
    ];

    public function render()
    {
        return view('livewire.forms.personal-detail.contact-form');
    }

    public function mount()
    {
        $this->contact = Person::find($this->person->id)->contact;
        $this->store();
    }

    public function store()
    {
        if(!$this->contact){
            $this->contact = Contact::create(['person_id' => $this->person->id]);
        }

        $this->address = $this->contact->address;
        $this->mobile_number = $this->contact->mobile_number;
    }

    public function updateContact(){
        $this->validate();
        $this->contact->update([
            'address' => $this->address,
            'mobile_number' => $this->mobile_number,
        ]);
        $this->emit('saved');
    }  
}
