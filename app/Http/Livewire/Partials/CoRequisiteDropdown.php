<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class CoRequisiteDropdown extends Component
{
    public array $coRequisiteSubjects = [];
    public $coRequisites;

    public function render() { return
        view('livewire.partials.co-requisite-dropdown');
    }

    public function removeSubject($index)
    {
        unset($this->coRequisiteSubjects[$index]);
        array_values($this->coRequisiteSubjects);
        $this->updatedCoRequisiteSubjects();
    }

    public function addSubject()
    {
        $this->coRequisiteSubjects[] = '';
    }

    public function updatedCoRequisiteSubjects() { return
        $this->emitUp('updateCoRequisiteSubjects', $this->coRequisiteSubjects);
    }
}
