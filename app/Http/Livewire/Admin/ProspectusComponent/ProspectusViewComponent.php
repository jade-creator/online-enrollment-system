<?php

namespace App\Http\Livewire\Admin\ProspectusComponent;

use App\Models\Level;
use App\Models\Program;
use App\Models\Prospectus;
use App\Models\Subject;
use App\Models\Strand;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProspectusViewComponent extends Component
{
    use AuthorizesRequests;

    public Subject $subject;
    public $addingSubjects = false;
    public $prospectus, $levelId, $programId, $strandId, $termId;
    public $selectedSubjects = [];

    protected $queryString = [
        'levelId' => [ 'except' => '' ],
        'programId' => [ 'except' => '' ],
        'strandId' => [ 'except' => '' ],
        'termId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'levelId',
        'programId',
        'strandId',
        'termId',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage', 'removeItem'];

    public function mount() {
        $level = $this->levels->first();

        $this->fill([ 
            'subject' => new Subject(), 
            'levelId' => $level->id, 
            'programId' => '', 
            'strandId' => '', 
            'termId' => '', 
        ]);
    }
    
    public function render() { return
        view('livewire.admin.prospectus-component.prospectus-view-component', ['prospectus' => $this->rowsQuery]);
    }

    public function getRowsQueryProperty()
    {
        $this->prospectus = Prospectus::select(['id', 'level_id', 'program_id', 'strand_id', 'term_id'])
            ->with('subjects.requisites')
            ->when(!empty($this->levelId), function($query) {
                return $query->where('level_id', $this->levelId);
            })
            ->when(!empty($this->programId), function($query) {
                return $query->where('program_id', $this->programId);
            })
            ->when(!empty($this->strandId), function($query) {
                return $query->where('strand_id', $this->strandId);
            })
            ->when(!empty($this->termId), function($query) {
                return $query->where('term_id', $this->termId);
            })
            ->first();

        return $this->prospectus;
    }

    public function removeConfirm(Subject $subject) {
        $this->subject = $subject;

        $this->dispatchBrowserEvent('swal:confirmDelete', [ 
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'Please note that upon deletion it cannot be retrievable.',
        ]);
    }

    public function removeItem()
    {   
        $this->prospectus->subjects()->detach($this->subject->id);

        $this->fill([ 'subject' => new Subject() ]);
    }

    public function dehydrate() {
        $this->fill([
            'programId' => $this->prospectus->program_id,
            'strandId' => $this->prospectus->strand_id,
            'termId' => $this->prospectus->term_id,
        ]);
    }

    public function addSubject()
    {
        if (empty($this->selectedSubjects)) {
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Unable Action!",
                'type' => "error",
                'text' => "There are no subjects selected.",
            ]);
        }

        $this->authorize('create', Prospectus::class);

        $this->prospectus->subjects()->attach($this->selectedSubjects);

        $this->fill([
            'selectedSubjects' => [],
            'addingSubjects' => false,
        ]);

        $this->dispatchBrowserEvent('swal:success', [ 
            'text' => "The prospectus has been updated.",
        ]);
    }

    public function getLevelsProperty() { return
        Level::get(['id', 'level']);
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'code']);
    }

    public function getStrandsProperty() { return
        Strand::get(['id', 'code']);
    }

    public function getSubjectsProperty() {
        $subjects = $this->prospectus->subjects->pluck('id')->toArray();

        return Subject::select(['id', 'title'])
                ->whereNotIn('id', $subjects)
                ->orderBy('title')
                ->get();
    }

    public function updatingLevelId() {
        $this->fill([
            'programId' => '',
            'strandId' => '',
            'termId' => '',
        ]);
    }
}
