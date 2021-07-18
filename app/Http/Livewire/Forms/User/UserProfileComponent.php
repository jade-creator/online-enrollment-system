<?php

namespace App\Http\Livewire\Forms\User;

use App\Models\AttendedSchool;
use App\Models\Contact;
use App\Models\Detail;
use App\Models\Guardian;
use App\Models\Person;
use App\Models\Registration;
use App\Models\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserProfileComponent extends Component
{
    use AuthorizesRequests;

    public User $user;
    public Person $person;
    public Detail $detail;
    public Contact $contact;
    public Guardian $guardian;
    public AttendedSchool $education;
    public $userId, $country, $guardianPerson, $guardianContact;

    public function rules()
    {
        return [
            'person.firstname' => ['string'],
            'person.middlename' => ['string'],
            'person.lastname' => ['string'],
            'person.suffix' => ['string'],
            'detail.gender' => ['string'],
            'detail.civil_status' => ['string'],
            'detail.religion' => ['string'],
            'detail.birthdate' => ['string'],
            'detail.birthplace' => ['string'],
            'contact.address' => ['string'],
            'contact.mobile_number' => ['string'],
            'guardianPerson.firstname' => ['string'],
            'guardianPerson.middlename' => ['string'],
            'guardianPerson.lastname' => ['string'],
            'guardianPerson.suffix' => ['string'],
            'guardianContact.address' => ['string'],
            'guardianContact.mobile_number' => ['string'],
            'education.name' => ['string'],
            'education.date_graduated' => ['string'],
            'education.program' => ['string'],
            'education.school_type_id' => ['string'],
            'education.level_id' => ['string'],
        ];
    }

    public function mount($userId)
    {
        $this->userId = $userId;

        $this->user = User::with('person')
            ->findOrFail($userId);
        
        $this->authorize('view', $this->user->person);

        $this->person = $this->user->person;
        $this->detail = $this->person->detail;
        $this->country = $this->person->detail->country->name;
        $this->contact = $this->person->contact;
        
        if ($this->user->role_id == 2) {
            $this->guardian  = $this->user->student->guardian ?? 'N/A';
            $this->guardianPerson  = $this->user->student->guardian->person ?? 'N/A';
            $this->guardianContact  = $this->user->student->guardian->person->contact ?? 'N/A';
            $this->education  = $this->user->student->attendedSchool ?? 'N/A';
            $this->education->program  = $this->education->program ?? 'N/A';
            $this->education->school_type_id  = $this->education->schoolType->type ?? 'N/A';
            $this->education->level_id  = $this->education->level->level ?? 'N/A';
        }
    }
    
    public function render() { return 
        view('livewire.forms.user.user-profile-component');
    }

    public function getRegistrationsProperty()
    {
        return Registration::where('student_id', $this->user->student->id)->latest()->take(3)->get();
    }
}
