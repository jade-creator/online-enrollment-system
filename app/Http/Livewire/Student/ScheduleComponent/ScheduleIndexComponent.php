<?php

namespace App\Http\Livewire\Student\ScheduleComponent;

use App\Models\Registration;
use Livewire\Component;

class ScheduleIndexComponent extends Component
{
    public Registration $registration;

    public function render() { return
        view('livewire.student.schedule-component.schedule-index-component');
    }
}
