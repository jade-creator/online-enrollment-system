<?php

namespace App\Http\Livewire\Student\ScheduleComponent;

use App\Models\Registration;
use Livewire\Component;

class ScheduleIndexComponent extends Component
{
    public Registration $registration;

    public function render() { return
        view('livewire.student.schedule-component.schedule-index-component', [
            'prospectus_subjects' =>  $this->registration->classes
                ->sort(function($class) {
                    return [$class->start_time, $class->day_id];
                })
                ->groupBy(['prospectus_subject_id', 'section_id', 'start_time', 'end_time', 'employee_id']),
        ]);
    }
}
