<?php

namespace App\Http\Livewire\Admin;

use App\Models;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $userCollection;
    public $registrationCollection;
    public $programs, $programsData;

    public function mount()
    {
        $this->programs = Models\Program::get(['id', 'code']);

        $programIds = $this->programs->pluck('id')->toArray();

        $students = Models\Student::all();

        foreach ($programIds as $id) {
            $this->programsData[] = $students->filter( function ($student) use ($id) {
                return $student->program_id == $id;
            })->count();
        }

        $this->registrationCollection = Models\Registration::get();

        $this->userCollection = Models\User::with(['role', 'person.detail'])->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'users' => $this->userCollection->count(),
            'registrations' => $this->registrationCollection->count(),
            'sections' => Models\Section::get('id')->count(),
            'subjects' => Models\Subject::get('id')->count(),
            'female' => $this->userCollection->filter(function ($user) {
                $gender = $user->person->detail->gender ?? 'N/A';
                return $gender == 'Female';
            })->count(),
            'male' => $this->userCollection->filter(function ($user) {
                $gender = $user->person->detail->gender ?? 'N/A';
                return $gender == 'Male';
            })->count(),
            'other' => $this->userCollection->filter(function ($user) {
                $gender = $user->person->detail->gender ?? 'N/A';
                return $gender == 'Other';
            })->count(),
            'prefer' => $this->userCollection->filter(function ($user) {
                $gender = $user->person->detail->gender ?? 'N/A';
                return $gender == 'Prefer not to say';
            })->count(),
            'admin' => $this->userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'admin';
            })->count(),
            'student' => $this->userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'student';
            })->count(),
            'registrar' => $this->userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'registrar';
            })->count(),
            'dean' => $this->userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'dean';
            })->count(),
            'faculty' => $this->userCollection->filter(function ($user) {
                $role = $user->role->name ?? 'N/A';
                return $role == 'faculty member';
            })->count(),
            'enrolled' => $this->registrationCollection->filter(function ($registration) {
                $status = $registration->status_id ?? 'N/A';
                return $status == 4;
            })->count(),
            'finalized' => $this->registrationCollection->filter(function ($registration) {
                $status = $registration->status_id ?? 'N/A';
                return $status == 3;
            })->count(),
            'confirming' => $this->registrationCollection->filter(function ($registration) {
                $status = $registration->status_id ?? 'N/A';
                return $status == 2;
            })->count(),
            'pending' => $this->registrationCollection->filter(function ($registration) {
                $status = $registration->status_id ?? 'N/A';
                return $status == 1;
            })->count(),
            'programsCode' => $this->programs->pluck('code')->toArray(),
        ]);
    }

    public function getRecentlyEnrolleesProperty() {
        $status = Models\Status::where('name', 'enrolled')->firstOrFail();

        return Models\Registration::with('student.user.person')
            ->where('status_id', $status->id)
            ->latest()
            ->take(5)
            ->get();
    }
}
