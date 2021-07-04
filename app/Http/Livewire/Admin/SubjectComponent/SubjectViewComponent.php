<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Exports\UsersExport;
use App\Models\Program;
use App\Models\SchoolType;
use App\Models\Strand;
use App\Models\Subject;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class SubjectViewComponent extends Component
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

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    protected array $allowedSorts = [
        'code',
        'title',
    ];

    public function render() { return 
        view('livewire.admin.subject-component.subject-view-component', ['subjects' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }    

    public function getRowsQueryProperty() 
    {
        return Subject::search($this->search)
            ->select(['id', 'code', 'title', 'unit'])
            ->latest();
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        return (new UsersExport($this->checkedUsers))->download('users-collection.xlsx');
    }    

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}
