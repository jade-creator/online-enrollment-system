<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class PreRequisiteDropdown extends Component
{
    public array $preRequisiteSubjects = [];
    public $preRequisites;

    public function render() { return
        view('livewire.partials.pre-requisite-dropdown');
    }

    public function removeSubject($index)
    {
        unset($this->preRequisiteSubjects[$index]);
        array_values($this->preRequisiteSubjects);
        $this->updatedPreRequisiteSubjects();
    }

    public function addSubject()
    {
        $this->preRequisiteSubjects[] = '';
    }

    public function updatedPreRequisiteSubjects() { return
        $this->emitUp('updatePreRequisiteSubjects', $this->preRequisiteSubjects);
    }
}
