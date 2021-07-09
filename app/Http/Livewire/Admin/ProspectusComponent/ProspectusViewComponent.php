<?php

namespace App\Http\Livewire\Admin\ProspectusComponent;

use App\Models\Level;
use App\Models\Program;
use App\Models\Prospectus;
use App\Models\Subject;
use App\Models\Strand;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ProspectusViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingSubjects = false;
    public $prospectus, $levelId, $programId, $strandId, $termId;
    public $selectedSubjects = [];

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'levelId' => [ 'except' => '' ],
        'programId' => [ 'except' => '' ],
        'strandId' => [ 'except' => '' ],
        'termId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'levelId',
        'programId',
        'strandId',
        'termId',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    protected array $allowedSorts = [
        'code',
        'title',
    ];

    public function mount() {
        $level = $this->levels->first();

        $this->fill([ 'levelId' => $level->id, ]);
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

    public function dehydrate() {
        $this->fill([
            'programId' => $this->prospectus->program_id,
            'strandId' => $this->prospectus->strand_id,
            'termId' => $this->prospectus->term_id,
        ]);
    }

    public function addSubject()
    {
        $this->prospectus->subjects()->attach($this->selectedSubjects);

        $this->fill([
            'selectedSubjects' => [],
            'addingSubjects' => false,
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

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        // return (new UsersExport($this->checkedUsers))->download('users-collection.xlsx');
    }    

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}
