<?php

namespace App\Http\Livewire\Forms\Contact;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactShow extends Component
{
    public function render()
    {
        return view('livewire.forms.contact.contact-show');
    }
}
