<?php

namespace App\Http\Livewire\Admin\ProgramComponent;

use App\Exports\ProgramsExport;
use App\Models\Program;
use App\Models\Level;
use App\Models\Term;
use App\Models\Prospectus;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public Program $program;
    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingProgram = false;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
    ];

    protected $updatesQueryString = [
        'search',
    ];

    protected array $allowedSorts = [
        'code',
        'program',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    protected $rules = [
        'program.code' => ['required', 'string', 'max:255'],
        'program.program' => ['required', 'string', 'max:255'],
        'program.description' => ['required', 'string'],
        'program.year' => ['required', 'integer', 'min:1'],
    ];

    public function mount() 
    {
        $this->program = new Program();
    }

    public function render() { return 
        view('livewire.admin.program-component.program-view-component', ['programs' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() 
    {
        return Program::search($this->search)
            ->select(['id', 'code', 'program', 'description', 'created_at'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin),
                fn ($query) => $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]));
    }

    public function save() 
    {
        $this->validate();
        $this->program->save();

        $collegeLevels = Level::orderBy('id', 'DESC')->take(4)->get();
        $terms = Term::get(['id']);

        $levelIds = $collegeLevels->pluck('id')->toArray();
        sort($levelIds);

        foreach ($levelIds as $key => $levelId) {

            if ($key >= $this->program->year) {
                break;
            }

            $terms->map(function ($term) use ($levelId) {
                Prospectus::create([
                    'level_id' => $levelId,
                    'program_id' => $this->program->id,
                    'term_id' => $term->id,
                ]);
            });
        }

        $this->fill([ 'addingProgram' => false ]);
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        return (new ProgramsExport($this->selected))->download('programs-collection.xlsx');
    }    

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}
