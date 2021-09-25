<?php

namespace App\Http\Livewire\Forms\Contact;

use App\Models\Contact;
use App\Rules\MobileNumber;
use App\Traits\WithSweetAlert;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactForm extends Component
{
    use WithSweetAlert;

    public Contact $contact;

    public function rules()
    {
        return [
            'contact.address' => [ 'required', 'string', 'max:255' ],
            'contact.mobile_number' => [ 'required', 'string', new MobileNumber],
        ];
    }

    public function render() { return
        view('livewire.forms.contact.contact-form');
    }

    public function mount()
    {
        $contact = Contact::select('id','address', 'mobile_number')
            ->where('person_id', Auth::user()->person_id)
            ->first();

        $this->contact = $contact ?? new Contact();
    }

    public function updateContact()
    {
        $this->validate();

        try {
            if (! $this->contact->exists) {
                $this->contact->person_id = Auth::user()->person_id;
                $this->contact->save();
            } else {
                $this->contact->update();
            }

            $this->emit('saved');
            $this->emit('proceed', 4);

            if (Auth::user()->role->name == 'admin') $this->emit('completed');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
