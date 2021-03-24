<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminDetailForm extends Component
{
    public $step = 1;
    protected $listeners = ['proceed', 'completed'];

    public function render()
    {
        return view('livewire.forms.personal-detail.admin-detail-form');
    }

    public function proceed($step){
        $this->step = $step;
    }

    public function completed(){
        $person = Person::find(Auth::user()->person_id);
        if($person){
            $person->update(['isCompleteDetail' => true]);            
        }
        return redirect('user/personal-details');
    }
}
