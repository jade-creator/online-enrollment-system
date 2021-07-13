<?php

namespace App\Http\Livewire\Admin\ProgramComponent;

use App\Exports\ProgramsExport;
use App\Models\Program;
use App\Models\Level;
use App\Models\Term;
use App\Models\Prospectus;
use App\Models\SchoolType;
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
    public bool $confirmingExport = false, $addingProgram = false, $viewingProgram = false;

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

    public function updateProgram()
    {
        $this->validate();
        $this->program->save();

        $this->fill([ 'viewingProgram' => false ]);

        $this->dispatchBrowserEvent('swal:success', [ 
            'text' => "The program has been updated.",
        ]);
    }

    public function removeConfirm() {
        return $this->dispatchBrowserEvent('swal:modal', [ 
            'title' => "Unable Action!",
            'type' => "error",
            'text' => "The system detected that this program is already added in a prospectus. There maybe students enrolled under it, this
            action can produce inconsistent data.",
        ]);
    }

    public function viewProgram(Program $program)
    {
        $this->fill([
            'program' => $program,
            'viewingProgram' => true,
        ]);
    }

    public function save() 
    {
        $this->validate();

        $type = SchoolType::where('type', 'College')
            ->with('levels')
            ->first();
        
        if (!$type) {
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Oops Sorry..",
                'type' => "error",
                'text' => "Internal Server Error 404.",
            ]);
        }

        $this->program->save();
        $terms = Term::get(['id']);

        $levelIds = $type->levels->pluck('id')->toArray();
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

    public function resetFields()
    {
        $this->fill([ 'program' => new Program() ]);
        $this->resetValidation();
    }

    public function updatedViewingProgram($value)
    {
        if (!$value) {
            $this->resetFields();
        }
    }

    public function updatedAddingProgram()
    {
        $this->resetFields();
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
