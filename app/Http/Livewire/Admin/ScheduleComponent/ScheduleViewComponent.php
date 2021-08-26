<?php

namespace App\Http\Livewire\Admin\ScheduleComponent;

use App\Models\Section;
use Livewire\Component;

class ScheduleViewComponent extends Component
{
    public Section $section;

    public function render() { return
        view('livewire.admin.schedule-component.schedule-view-component');
    }
}
