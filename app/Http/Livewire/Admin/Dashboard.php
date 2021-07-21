<?php

namespace App\Http\Livewire\Admin;

use App\Models\Registration;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render() { return 
        view('livewire.admin.dashboard');
    }

    public function getUsersProperty() { return
        User::get('id');
    }

    public function getRegistrationsProperty() { return
        Registration::get('id');
    }

    public function getSectionsProperty() { return
        Section::get('id');
    }

    public function getSubjectsProperty() { return
        Subject::get('id');
    }

    public function getRecentlyEnrolleesProperty() { 
        $status = Status::where('name', 'enrolled')->firstOrFail();
        
        return Registration::with('student.user.person')
            ->where('status_id', $status->id)
            ->latest()
            ->take(5)
            ->get();
    }

    public function getAllRegistrationsProperty()
    {
        return Registration::with([
                'student.user.person',
                'status',
                'section',
                'prospectus.level',
            ])
            ->latest()
            ->take(10)
            ->get();
    }
}
