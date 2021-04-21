<?php

namespace App\Http\Livewire\Forms\PersonalDetail;

use Exception;
use Carbon\Carbon;
use App\Models\Person;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FullnameForm extends Component
{
    public Person $person;
    
    protected $rules = [
        'person.firstname' => [ 'required', 'string', 'max:255'],
        'person.middlename' => [ 'required', 'string', 'max:255'],
        'person.lastname' => [ 'required', 'string', 'max:255'],
        'person.suffix' => [ 'nullable', 'string', 'max:255'],
    ];

    public function render() 
    {
        return view('livewire.forms.personal-detail.fullname-form');
    }

    public function mount() 
    {
        $user = Auth::user()->load('person:id,firstname,middlename,lastname,suffix');

        $this->person = $user->person ?? new Person();
    }

    public function insert()
    {
        DB::beginTransaction();

        try {
            $person_id = DB::table('people')->insertGetId([
                'firstname' => $this->person->firstname,
                'middlename' => $this->person->middlename,
                'lastname' => $this->person->lastname,
                'suffix' => $this->person->suffix,
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

            throw new Exception("error");
        }
    }

    public function updateOrCreateFullname() 
    {
        $this->validate();
        
        if (empty(trim($this->person->suffix))) { $this->person->suffix = null; }

        try {
            if (!$this->person->exists) {
                $this->insert();
            } else {
                $this->person->update();
            }
        } catch (Exception $e) {
            return $this->emit($e->getMessage());
        }

        $this->emit('saved');

        $this->emit('proceed', 2);
    }
}