<?php

namespace App\Http\Livewire\Forms\Guardian;

use App\Traits\WithSweetAlert;
use Exception;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Contact;
use Livewire\Component;
use App\Models\Guardian;
use App\Rules\MobileNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GuardianForm extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public ?int $studentId = null;
    public Guardian $guardian;
    public Person $person;
    public Contact $contact;

    public function rules()
    {
        return [
            'person.firstname' => [ 'required', 'string', 'max:255'],
            'person.middlename' => [ 'required', 'string', 'max:255'],
            'person.lastname' => [ 'required', 'string', 'max:255'],
            'person.suffix' => [ 'nullable', 'string', 'max:255'],
            'guardian.relationship' => [ 'required', 'string', 'max:255'],
            'contact.address' => [ 'required', 'string', 'max:255' ],
            'contact.mobile_number' => [ 'required', 'string', new MobileNumber],
        ];
    }

    public function mount()
    {
        $guardian = Auth::user()->studentGuardian;

        if (! is_null($guardian)) {
            $guardian->load([
                'person' => function ($query){
                    $query->select(['id', 'firstname', 'middlename', 'lastname', 'suffix']);
                },
                'person.contact' => function ($query){
                    $query->select(['id', 'address', 'mobile_number', 'person_id']);
                }]);

            $this->studentId ??= $guardian->student_id;

            $this->guardian = $guardian;
        } else {
            $this->guardian = new Guardian();
        }

        $this->person = $guardian->person ?? new Person();
        $this->contact = $guardian->person->contact ?? new Contact();
    }

    public function render() { return
        view('livewire.forms.guardian.guardian-form');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function insert()
    {
        $this->authorize('create', Guardian::class);

        DB::beginTransaction();

        try {
            $personId = DB::table('people')->insertGetId([
                'firstname' => $this->person->firstname,
                'middlename' => $this->person->middlename,
                'lastname' => $this->person->lastname,
                'suffix' => $this->person->suffix,
                'isCompleteDetail' => true,
                "created_at" =>  Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('contacts')->insert([
                'address' => $this->contact->address,
                'mobile_number' => $this->contact->mobile_number,
                'person_id' => $personId,
                "created_at" =>  Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('guardians')->insert([
                'relationship' => $this->guardian->relationship,
                'person_id' => $personId,
                'student_id' => $this->studentId,
                "created_at" =>  Carbon::now()->toDateTimeString(),
                "updated_at" => Carbon::now()->toDateTimeString(),
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception("Internal Error!");
        }
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update()
    {
        $this->authorize('update', $this->guardian);

        DB::beginTransaction();

        try {
            DB::table('people')
                ->where('id', $this->person->id)
                ->update([
                    'firstname' => $this->person->firstname,
                    'middlename' => $this->person->middlename,
                    'lastname' => $this->person->lastname,
                    'suffix' => $this->person->suffix,
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('contacts')
                ->where('id', $this->contact->id)
                ->update([
                    'address' => $this->contact->address,
                    'mobile_number' => $this->contact->mobile_number,
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('guardians')
                ->where('id', $this->guardian->id)
                ->update([
                    'relationship' => $this->guardian->relationship,
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw new Exception("Internal Error!");
        }
    }

    public function updateOrCreateGuardian()
    {
        $this->validate();

        if (empty(trim($this->person->suffix))) { $this->person->suffix = null; }

        try {
            if (!$this->guardian->exists) {
                $this->insert();
            } else {
                $this->update();
            }

            $this->emit('saved');
            $this->emit('proceed', 5);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
