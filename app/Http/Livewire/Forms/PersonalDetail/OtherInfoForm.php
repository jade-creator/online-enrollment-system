<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Detail;
use App\Models\Country;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OtherInfoForm extends Component
{
    use WithSweetAlert;

    public Detail $detail;
    public ?iterable $countries = null;

    protected $rules = [
        'detail.gender' => [ 'required', 'string', 'max:255', 'in:Other,Male,Female,Prefer not to say'],
        'detail.civil_status' => [ 'required', 'string', 'max:255', 'in:Single,Married,Divorced,Widowed,Prefer not to say'],
        'detail.religion' => [ 'required', 'string', 'max:255', 'in:Other,Catholic Christianity,Protestant Christianity,Islam,Tribal,None'],
        'detail.country_id' => [ 'required', 'integer'],
        'detail.birthdate' => [ 'required', 'date'],
        'detail.birthplace' => [ 'required', 'string', 'max:255'],
    ];

    public function render() { return
        view('livewire.forms.personal-detail.other-info-form');
    }

    public function mount()
    {
        $this->countries = Country::get(['id', 'name']);

        $detail = Detail::select([
                'id',
                'gender',
                'civil_status',
                'religion',
                'country_id',
                'birthdate',
                'birthplace',
            ])
            ->where('person_id', Auth::user()->person_id)
            ->first();

        $this->detail = $detail ?? new Detail();
    }

    public function updateOtherInfo()
    {
        $this->validate();

        try {
            if (!$this->detail->exists) {
                $this->detail->person_id = Auth::user()->person_id;
                $this->detail->save();
            } else {
                $this->detail->update();
            }

            $this->emit('saved');
            $this->emit('proceed', 3);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
