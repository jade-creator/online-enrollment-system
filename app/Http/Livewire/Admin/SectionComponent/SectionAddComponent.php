<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models;
use Livewire\Component;

class SectionAddComponent extends Component
{
    public Models\Section $section;
    public Models\Prospectus $prospectus;
    public bool $addingSection = false;

    public function render() { return
        view('livewire.admin.section-component.section-add-component');
    }
}
