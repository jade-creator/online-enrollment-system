<?php

namespace App\Http\Livewire\Admin\GradeComponent;

use Livewire\Component;

class RowBladeComponent extends Component
{
    public $registration;
    public $grades;

    public function render() { return
        view('livewire.admin.grade-component.row-blade-component');
    }
}
