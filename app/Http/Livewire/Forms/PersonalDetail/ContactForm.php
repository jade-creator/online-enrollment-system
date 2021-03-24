<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Contact;
use Livewire\Component;
use App\Rules\MobileNumber;
use Illuminate\Support\Facades\Auth;

class ContactForm extends Component
{
    public $contact;
    public $person_id;
    public $address;
    public $mobile_number;

    public function rules(){
        return [
            'address' => [ 'required', 'max:255' ],
            'mobile_number' => [ 'required', new MobileNumber],
        ];
    }

    public function render()
    {
        return view('livewire.forms.personal-detail.contact-form');
    }

    public function mount()
    {
        $this->person_id = Auth::user()->person_id;
        if($this->person_id){
            $this->contact = Auth::user()->person->contact;
        }

        if($this->contact){
            $this->address = $this->contact->address;
            $this->mobile_number = $this->contact->mobile_number;
        }
    }

    public function updateContact(){
        $this->validate();

        if(!$this->contact){
            $this->contact = Contact::create([
                'address' => $this->address,
                'mobile_number' => $this->mobile_number,
                'person_id' => $this->person_id,
            ]);
        }else{
            $this->contact->update([
                'address' => $this->address,
                'mobile_number' => $this->mobile_number,
            ]);
        }

        $this->emit('saved');
        $this->emit('proceed', 4);
        
        if(Auth::user()->role->name == 'admin'){
            $this->emit('completed');
        };
    }  
}
