<?php

namespace App\Http\Livewire\Admin\FacultyComponent;

use App\Exports\FacultiesExport;
use App\Models\Faculty;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class FacultyIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert;

    public int $paginateValue = 10;

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
        'id',
        'code',
        'name',
    ];

    protected $listeners = [
        'refresh' => '$refresh',
        'DeselectPage' => 'updatedSelectPage',
        'sessionFlashAlert',
        'fileExport',
    ];

    public function render() { return
        view('livewire.admin.faculty-component.faculty-index-component', ['faculties' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Faculty::search($this->search)
            ->select(['id', 'code', 'name', 'description', 'mission', 'vision', 'created_at'])
            ->with([
                'employees.user.role',
                'employees.user.person',
            ])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function fileExport()
    {
        try {
            return $this->excelFileExport((new FacultiesExport($this->selected)), 'faculty-collection.xlsx');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        return view('livewire.admin.faculty-component.faculty-index-component');
    }
}
