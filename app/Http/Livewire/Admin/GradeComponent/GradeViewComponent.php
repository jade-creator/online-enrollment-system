<?php

namespace App\Http\Livewire\Admin\GradeComponent;

use App\Models\Registration;
use Livewire\Component;

class GradeViewComponent extends Component
{
    public Registration $registration;

    public function render() { return
        view('livewire.admin.grade-component.grade-view-component');
    }
}
