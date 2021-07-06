<?php

namespace App\Http\Livewire\Admin\SpecializationComponent;

use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Specialization;
use App\Traits\WithFilters;
use App\Traits\WithBulkActions;
use App\Traits\WithSorting;

class SpecializationViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public Specialization $specialization;
    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingSpecialization = false;
    public $programId = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'programId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'programId',
    ];

    protected array $allowedSorts = [
        'title',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function rules() 
    {
        return [
            'specialization.title' => ['required', 'string'],
            'specialization.description' => ['required', 'string'],
        ];
    }

    public function mount() 
    {
        $this->fill([ 'specialization' => new Specialization() ]);
    }

    public function render() { return 
        view('livewire.admin.specialization-component.specialization-view-component', ['specializations' => $this->rows]);
    }    

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() 
    {
        return Specialization::search($this->search)
            ->select(['id', 'title', 'description', 'program_id', 'created_at'])
            ->with(['program:id,code'])
            ->when(!empty($this->programId), function($query) {
                return $query->where('program_id', $this->programId);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'code']);
    }

    public function save() 
    {
        $this->validate();

        $this->specialization->program_id = $this->programId;
        $this->specialization->save();

        $this->fill([ 'addingSpecialization' => false ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
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