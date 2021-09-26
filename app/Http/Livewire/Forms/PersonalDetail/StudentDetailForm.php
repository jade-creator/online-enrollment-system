<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Person;
use App\Models\Student;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentDetailForm extends Component
{
    use WithSweetAlert;

    public $student = null;
    public $step = 1;
    protected $listeners = ['proceed', 'completed'];

    public function render() { return
        view('livewire.forms.personal-detail.student-detail-form');
    }

    public function mount()
    {
        $this->student = Auth::user()->student()
            ->firstOr(function () {
                return Student::create([
                    'user_id' => auth()->user()->id,
                ]);
            });
    }

    public function proceed($step) { $this->step = $step; }

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
