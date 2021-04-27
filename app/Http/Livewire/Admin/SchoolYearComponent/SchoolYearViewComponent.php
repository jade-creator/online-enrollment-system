<?php

namespace App\Http\Livewire\Admin\SchoolYearComponent;

use App\Models\SchoolYear;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolYearViewComponent extends Component
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
        'from_date',
        'to_date',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function render() { return 
        view('livewire.admin.school-year-component.school-year-view-component', ['years' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() 
    {
        return SchoolYear::search($this->search)
            ->select(['id', 'from_date', 'to_date', 'is_active', 'created_at'])
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
