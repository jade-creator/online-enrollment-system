<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Person;
use App\Traits\WithSweetAlert;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminDetailForm extends Component
{
    use WithSweetAlert;

    public int $step = 1;
    protected $listeners = ['proceed', 'completed'];

    public function render() { return
        view('livewire.forms.personal-detail.admin-detail-form');
    }

    public function proceed(int $step) { $this->step = $step; }

    public function completed()
    {
        try {
            $person = auth()->user()->person;
            $person->update(['isCompleteDetail' => true]);

            return redirect()->route('user.personal.profile.view', auth()->user()->id);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
