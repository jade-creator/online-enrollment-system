<?php

namespace App\Http\Livewire\Admin;

use App\Models;
use App\Models\Registration;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Status;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'users' => Models\User::get('id')->count(),
            'registrations' => Models\Registration::get('id')->count(),
            'sections' => Models\Section::get('id')->count(),
            'subjects' => Models\Subject::get('id')->count(),
            'female' => Models\User::female()->count(),
            'male' => Models\User::male()->count(),
            'other' => Models\User::other()->count(),
            'prefer' => Models\User::none()->count(),
            'admin' => Models\User::get(['id', 'role_id'])->where('role_id', 1)->count(),
            'student' => Models\User::get(['id', 'role_id'])->where('role_id', 2)->count(),
            'registrar' => Models\User::get(['id', 'role_id'])->where('role_id', 3)->count(),
            'dean' => Models\User::get(['id', 'role_id'])->where('role_id', 4)->count(),
            'faculty' => Models\User::get(['id', 'role_id'])->where('role_id', 5)->count(),
            'enrolled' => Models\Registration::enrolled()->get()->count(),
            'finalized' => Models\Registration::finalized()->count(),
            'confirming' => Models\Registration::confirming()->count(),
            'pending' => Models\Registration::pending()->count(),
            'bsit' => Models\Registration::filterByProgram(1)->count(),
            'bscs' => Models\Registration::filterByProgram(2)->count(),
            'bsba' => Models\Registration::filterByProgram(3)->count(),
            'bshm' => Models\Registration::filterByProgram(4)->count(),
            'bsce' => Models\Registration::filterByProgram(5)->count(),
            'bacomm' => Models\Registration::filterByProgram(6)->count(),
        ]);
    }

    public function getRecentlyEnrolleesProperty() {
        $status = Status::where('name', 'enrolled')->firstOrFail();

        return Registration::with('student.user.person')
            ->where('status_id', $status->id)
            ->latest()
            ->take(5)
            ->get();
    }
}
