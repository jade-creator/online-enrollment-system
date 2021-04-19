<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use App\Models\Country;
use App\Models\Detail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OtherInfoForm extends Component
{
    public $detail = null;
    public $gender;
    public $civil_status;
    public $religion;
    public $nationality;
    public $birthdate;
    public $birthplace;
    public $countries;

    protected $rules = [
        'gender' => [ 'required', 'max:255', 'in:Other,Male,Female,Prefer not to say'],
        'civil_status' => [ 'required', 'max:255', 'in:Single,Married,Divorced,Widowed,Prefer not to say'],
        'religion' => [ 'required', 'max:255', 'in:Other,Catholic Christianity,Protestant Christianity,Islam,Tribal,None'],
        'nationality' => [ 'required', 'max:255'],
        'birthdate' => [ 'required', 'date'],
        'birthplace' => [ 'required', 'max:255'],
    ];

    public function render() 
    {
        return view('livewire.forms.personal-detail.other-info-form');
    }

    public function mount() 
    {
        $this->countries = Country::get(['id', 'name']);
        
        $this->detail = Detail::select([
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
        
        if (!is_null($this->detail)) {
            $this->gender = $this->detail->gender ?? '';
            $this->civil_status = $this->detail->civil_status ?? '';
            $this->religion = $this->detail->religion ?? '';
            $this->nationality = $this->detail->country_id ?? '';
            $this->birthdate = $this->detail->birthdate ?? '';
            $this->birthplace = $this->detail->birthplace ?? '';
        }
    }

    public function updateOtherInfo() 
    {
        $this->validate();

        if (is_null($this->detail)) {
            Detail::create([
                'gender' => $this->gender,
                'civil_status' => $this->civil_status,
                'religion' => $this->religion,
                'birthdate' => $this->birthdate,
                'birthplace' => $this->birthplace,
                'person_id' => Auth::user()->person_id,
                'country_id' => $this->nationality,
            ]);
        } else {
            $this->detail->update([
                'gender' => $this->gender,
                'civil_status' => $this->civil_status,
                'religion' => $this->religion,
                'birthdate' => $this->birthdate,
                'birthplace' => $this->birthplace,
                'country_id' => $this->nationality,
            ]);
        }

        $this->emit('saved');
        
        $this->emit('proceed', 3);
    }
}
