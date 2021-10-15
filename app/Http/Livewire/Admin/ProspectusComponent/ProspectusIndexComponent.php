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
    public string $prospectusId = '', $curriculumId = '';
    public $curriculums;

    protected $queryString = ['curriculumId' => [ 'except' => '' ]];

    protected $updatesQueryString = ['curriculumId'];

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $this->prospectus = Models\Prospectus::select(['id', 'level_id', 'program_id', 'term_id'])->findOrFail($this->prospectusId);
        $this->curriculums = Models\Curriculum::where('program_id', $this->prospectus->program_id)->get(['id', 'code', 'isActive']);

        if (empty($this->curriculumId)) $this->curriculumId = $this->curriculums->where('isActive', 1)->first()->id ?? '';

        if (empty($this->curriculumId)) $this->curriculumId = $this->curriculums->first()->id ?? '';
    }

    public function render() { return
        view('livewire.admin.prospectus-component.prospectus-index-component', [
            'allSubjects' => $this->getAllSubjects(),
            'coRequisites' => $this->getProspectusSubjects(),
            'preRequisites' => $this->getPreRequisites(),
        ]);
    }

    //populate table and co-requisites: get all subjects in a given prospectus
    public function getProspectusSubjects()
    {
        return Models\ProspectusSubject::where('curriculum_id', $this->curriculumId)
                ->with(['prerequisites', 'corequisites', 'subject'])
                ->getAllSubjectsInProspectus($this->prospectusId);
    }

    //populate dropdown subjects: get all subjects in program except the subject/s that is already added.
    public function getAllSubjects()
    {
        $subjects = Models\Prospectus::getAllSubjectsInProgram($this->prospectus->program_id, $this->curriculumId);
        return Models\Subject::getAllSubjectsExcept($subjects->pluck('id')->toArray());
    }

    //populate dropdown pre-requisites: get all subject/s that are candidate for a pre-requisite.
    public function getPreRequisites() { return
        Models\Prospectus::getAllSubjectsInPrecedingProspectuses($this->prospectus, $this->curriculumId);
    }
}
