<?php

namespace App\Http\Livewire\Admin\ProgramComponent;

use App\Models\Program;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public int $paginateValue = 10;
    public bool $confirmingExport = false;

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
