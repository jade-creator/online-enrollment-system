<?php

namespace App\Http\Livewire\Forms\Guardian;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Guardian;
use App\Rules\MobileNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GuardianForm extends Component
{
    use AuthorizesRequests;

    public $student = null;
    public $student_id;
    public $guardian = null;
    public $person = null;
    public $contact = null;
    public $firstname;
    public $middlename;
    public $lastname;
    public $suffix;
    public $relationship;   
    public $address;
    public $mobile_number;

    public function rules() 
    {
        return [
            'firstname' => [ 'required', 'max:255'],
            'middlename' => [ 'required', 'max:255'],
            'lastname' => [ 'required', 'max:255'],
            'suffix' => [ 'nullable', 'max:255'],
            'relationship' => [ 'required', 'max:255'],
            'address' => [ 'required', 'max:255' ],
            'mobile_number' => [ 'required', new MobileNumber],
        ];
    }

    public function mount() 
    {    
        if (is_null($this->student)) {
            $this->student_id = Auth::user()->student->id;
        } else {
            $this->student_id =  $this->student->id;
        }

        $this->guardian = Guardian::select('id', 'relationship', 'person_id', 'student_id')
            ->where('student_id', $this->student_id)
            ->with([
                'person' => function ($query){
                    $query->select('id','firstname','middlename','lastname','suffix');
                },
                'person.contact' => function ($query){
                    $query->select('id','address','mobile_number','person_id');
                },
            ])
            ->first();

        if (!is_null($this->guardian)) {
            $this->person = $this->guardian->person;
            $this->firstname = $this->person->firstname ?? '';
            $this->middlename = $this->person->middlename ?? '';
            $this->lastname = $this->person->lastname ?? '';
            $this->suffix = $this->person->suffix ?? '';

            $this->relationship = $this->guardian->relationship ?? '';

            $this->contact = $this->person->contact;
            $this->address = $this->contact->address ?? '';
            $this->mobile_number = $this->contact->mobile_number ?? '';
        }
    }

    public function render()
    {
        return view('livewire.forms.guardian.guardian-form');
    }

    public function insert()
    {
        $this->authorize('create', Guardian::class);

        DB::beginTransaction();

        try {
            $person_id = DB::table('people')->insertGetId([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
                'suffix' => $this->suffix,
                'isCompleteDetail' => true,
                "created_at" =>  Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('contacts')->insert([
                'address' => $this->address,
                'mobile_number' => $this->mobile_number,
                'person_id' => $person_id,
                "created_at" =>  Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('guardians')->insert([
                'relationship' => $this->relationship,
                'person_id' => $person_id,
                'student_id' => $this->student_id,
                "created_at" =>  Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return false;
        }
    }

    public function update()
    {
        $this->authorize('update', $this->guardian);

        DB::beginTransaction();

        try {
            DB::table('people')
                ->where('id', $this->person->id)
                ->update([
                    'firstname' => $this->firstname,
                    'middlename' => $this->middlename,
                    'lastname' => $this->lastname,
                    'suffix' => $this->suffix,
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('contacts')
                ->where('id', $this->contact->id)
                ->update([
                    'address' => $this->address,
                    'mobile_number' => $this->mobile_number,
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('guardians')
                ->where('id', $this->guardian->id)
                ->update([
                    'relationship' => $this->relationship,
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return false;
        }
    }

    public function updateOrCreateGuardian() 
    {
        $this->validate();

        if (empty(trim($this->suffix))) {
            $this->suffix = null;
        }

        $response = null;

        if (is_null($this->guardian)) {
            $response = $this->insert();
        } else {   
            $response = $this->update();
        }

        if (!is_null($response)) {
            return $this->emit('error');
        }

        $this->emit('saved');

        $this->emit('proceed', 5);
    }
}