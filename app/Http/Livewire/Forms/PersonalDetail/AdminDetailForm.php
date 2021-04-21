<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminDetailForm extends Component
{
    public int $step = 1;
    protected $listeners = ['proceed', 'completed'];

    public function render() 
    {
        return view('livewire.forms.personal-detail.admin-detail-form');
    }

    public function proceed(int $step) 
    {
        $this->step = $step;
    }

    public function completed() 
    { 
        if ($person = Person::find(Auth::user()->person_id)) {
            $person->update(['isCompleteDetail' => true]);            
        }
        
        return redirect('user/profile');
    }
}
