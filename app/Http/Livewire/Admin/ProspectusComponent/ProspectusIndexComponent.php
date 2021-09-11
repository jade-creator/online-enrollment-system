<?php

namespace App\Http\Livewire\Admin\ProspectusComponent;

use App\Models;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProspectusIndexComponent extends Component
{
    use AuthorizesRequests;
    use Traits\WithSweetAlert;

    public Models\Prospectus $prospectus;
    public string $prospectusId = '';

    protected $listeners = [
        'refresh' => '$refresh',
        'removeConfirm',
    ];

    public function mount() {
        $this->prospectus = Models\Prospectus::select(['id', 'level_id', 'program_id'])->findOrFail($this->prospectusId);
    }

    public function render() { return
        view('livewire.admin.prospectus-component.prospectus-index-component', [
            'allSubjects' => $this->getAllSubjects(),
            'preRequisites' => $this->getPreRequisites(),
        ]);
    }

    public function removeConfirm(Models\ProspectusSubject $prospectusSubject) {
        $this->confirmDelete('removeSubject', $prospectusSubject, $prospectusSubject->subject->code);
    }

    //populate table: get all subjects in a given prospectus
    public function getProspectusSubjects() { return
        Models\ProspectusSubject::with('prerequisites')->getAllSubjectsInProspectus($this->prospectusId);
    }

    //populate dropdown subjects: get all subjects in program except the subject/s that is already added.
    public function getAllSubjects()
    {
        $subjects = Models\Prospectus::getAllSubjectsInProgram($this->prospectus->program_id);
        return Models\Subject::getAllSubjectsExcept($subjects->pluck('id')->toArray());
    }

    //populate dropdown pre-requisites: get all subject/s that are candidate for a pre-requisite.
    public function getPreRequisites() { return
        Models\Prospectus::getAllSubjectsInPrecedingProspectuses($this->prospectus);
    }
}
