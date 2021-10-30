<?php

namespace App\Http\Livewire\Admin\ProspectusComponent;

use App\Models;
use App\Traits;
use Cassandra\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProspectusIndexComponent extends Component
{
    use AuthorizesRequests;
    use Traits\WithSweetAlert;

    public ?Models\Program $program = NULL;
    public ?Models\Level $level = NULL;
    public ?Models\Term $semester = NULL;
    public ?Models\Curriculum $curriculum = NULL;
    public Models\Prospectus $prospectus;
    public string $programId = '', $levelId = '', $semesterId = '', $prospectusId = '', $curriculumId = '';
    public $curriculums;

    protected $queryString = [
        'programId' => [ 'except' => '' ],
        'levelId' => [ 'except' => '' ],
        'semesterId' => [ 'except' => '' ],
        'curriculumId' => [ 'except' => '' ]
    ];

    protected $updatesQueryString = [
        'programId',
        'levelId',
        'semesterId',
        'curriculumId'
    ];

    protected $listeners = [
        'refresh' => '$refresh',
        'sessionFlashAlert'
    ];

    //find or get the first model from a collection.
    public function findModel(string $property, string $modelInstance, string $modelId = '', $collection = NULL)
    {
        if (empty($collection)) $collection = $this->$property;

        $this->$modelInstance = $collection->find($modelId);

        if (filled($collection) && empty($this->$modelInstance)) $this->$modelInstance = $collection->first();

        return $this->$modelInstance->id ?? '';
    }

    public function mount()
    {
        $this->programId = $this->findModel('programs', 'program', $this->programId);

        //create new collection from program's levels.
        $levels = new \Illuminate\Database\Eloquent\Collection();
        foreach ($this->getProgramLevels()->pluck('level') as $level) {
            $levels->push($level);
        }

        $this->levelId = $this->findModel('levels', 'level', $this->levelId, $levels);
        $this->semesterId = $this->findModel('terms', 'semester', $this->semesterId);

        //if curriculumId is empty find the active curriculum.
        $this->curriculums = Models\Curriculum::where('program_id', $this->programId)->get(['id', 'code', 'program_id', 'isActive']);
        $curriculumIds = $this->curriculums->pluck('id')->toArray();

        if (filled($this->curriculums) && (empty($this->curriculumId) || ! in_array($this->curriculumId, $curriculumIds)) ) {
            $curriculum = $this->curriculums->filter(function ($curriculum) {
               return $curriculum->isActive;
            })->first();
            $this->curriculum = $this->curriculums->where('isActive', 1)->first() ?? NULL;
            $this->curriculumId = $this->curriculum->id ?? '';
        } else {
            $this->curriculumId = $this->findModel('curriculums', 'curriculum', $this->curriculumId);
        }

        $this->prospectus = Models\Prospectus::where([
                ['program_id', $this->programId],
                ['level_id', $this->levelId],
                ['term_id', $this->semesterId],
            ])->firstOrFail();
    }

    public function render() { return
        view('livewire.admin.prospectus-component.prospectus-index-component', [
            'allSubjects' => $this->getAllSubjects(),
            'coRequisites' => $this->getProspectusSubjects(),
            'preRequisites' => $this->getPreRequisites(),
        ]);
    }

    public function add()
    {
        try {
            if (empty($this->curriculumId)) throw new \Exception('No curriculum found. Click <a href="'.route('admin.curricula.create').'" class="underline">add</a> now.');

            $this->emit('modalAddingSubject');
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'info',
                'message' => $e->getMessage(),
            ]);
        }
    }

    //populate table and co-requisites: get all subjects in a given prospectus
    public function getProspectusSubjects()
    {
        return Models\ProspectusSubject::where('curriculum_id', $this->curriculumId)
                ->with(['prerequisites', 'corequisites', 'subject'])
                ->getAllSubjectsInProspectus($this->prospectus->id);
    }

    //populate dropdown subjects: get all subjects in program except the subject/s that is already added.
    public function getAllSubjects()
    {
        $subjects = Models\Prospectus::getAllSubjectsInProgram($this->programId, $this->curriculumId);
        return Models\Subject::getAllSubjectsExcept($subjects->pluck('id')->toArray());
    }

    //populate dropdown pre-requisites: get all subject/s that are candidate for a pre-requisite.
    public function getPreRequisites() { return
        Models\Prospectus::getAllSubjectsInPrecedingProspectuses($this->prospectus, $this->curriculumId);
    }

    public function getProgramsProperty() { return
        Models\Program::get();
    }

    public function getLevelsProperty() { return
        Models\Level::get();
    }

    public function getProgramLevels() { return
        Models\Prospectus::select(['level_id', 'program_id'])
            ->where('program_id', $this->programId)
            ->groupBy(['level_id', 'program_id'])
            ->get();
    }

    public function getTermsProperty() { return
        Models\Term::get(['id', 'term']);
    }
}
