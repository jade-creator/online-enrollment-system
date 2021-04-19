<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FullnameForm extends Component
{
    public $person = null;
    public $firstname;
    public $middlename;
    public $lastname;
    public $suffix;
    
    protected $rules = [
        'firstname' => [ 'required', 'max:255'],
        'middlename' => [ 'required', 'max:255'],
        'lastname' => [ 'required', 'max:255'],
        'suffix' => [ 'nullable', 'max:255'],
    ];

    public function render() 
    {
        return view('livewire.forms.personal-detail.fullname-form');
    }

    public function mount() 
    {
        $user = Auth::user()->load('person:id,firstname,middlename,lastname,suffix');
        $this->person = $user->person;

        if (!is_null($this->person)) {
            $this->firstname = $this->person->firstname ?? '';
            $this->middlename = $this->person->middlename ?? '';
            $this->lastname = $this->person->lastname ?? '';
            $this->suffix = $this->person->suffix ?? '';
        }
    }

    public function insert()
    {
        DB::beginTransaction();

        try {
            $person_id = DB::table('people')->insertGetId([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
                'suffix' => $this->suffix,
                'isCompleteDetail' => false,
                "created_at" =>  Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('users')
                ->where('id', auth()->user()->id)
                ->update([  
                    'person_id' => $person_id,
                    "updated_at" => Carbon::now()->toDateTimeString()    
                ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function updateOrCreateFullname() 
    {
        $this->validate();
        
        if (empty(trim($this->suffix))) {
            $this->suffix = null;
        }

        $response = null;

        if (is_null($this->person)) {
            $response = $this->insert();
        } else {
            $this->person->update([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
                'suffix' => $this->suffix,
            ]);
        }
        
        if (!is_null($response)) {
            return $this->emit('error');
        }

        $this->emit('saved');

        $this->emit('proceed', 2);
    }
}