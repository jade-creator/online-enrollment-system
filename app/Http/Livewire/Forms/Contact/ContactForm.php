<?php

namespace App\Http\Livewire\Forms\Contact;

use App\Models\Contact;
use App\Rules\MobileNumber;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactForm extends Component
{
    public $contact = null;
    public $address;
    public $mobile_number;

    public function rules() 
    {
        return [
            'address' => [ 'required', 'max:255' ],
            'mobile_number' => [ 'required', new MobileNumber],
        ];
    }

    public function render()
    {
        return view('livewire.forms.contact.contact-form');
    }

    public function mount() 
    {
        $this->contact = Contact::select('id','address', 'mobile_number')
            ->where('person_id', Auth::user()->person_id)
            ->first();

        if (!is_null($this->contact)) {
            $this->address = $this->contact->address ?? '';
            $this->mobile_number = $this->contact->mobile_number ?? '';   
        }
    }

    public function updateContact() 
    {
        $this->validate();

        if (is_null($this->contact)) {
            Contact::create([
                'address' => $this->address,
                'mobile_number' => $this->mobile_number,
                'person_id' => Auth::user()->person_id,
            ]);
        } else {
            $this->contact->update([
                'address' => $this->address,
                'mobile_number' => $this->mobile_number,
            ]);
        }

        $this->emit('saved');
        
        $this->emit('proceed', 4);

        if (Auth::user()->role->name == 'admin') {
            $this->emit('completed');
        };
    }  
}
