<?php

namespace App\Http\Livewire\Admin\ProgramComponent;

use App\Exports\ProgramsExport;
use App\Models\Program;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class ProgramIndexComponent extends Livewire\Component
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
        'program',
    ];

    protected $listeners = [
        'refresh' => '$refresh',
        'DeselectPage' => 'updatedSelectPage',
        'fileExport',
    ];

    public function render() { return
        view('livewire.admin.program-component.program-index-component', ['programs' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Program::search($this->search)
            ->with('faculty')
            ->select(['id', 'faculty_id', 'code', 'program', 'description', 'year', 'created_at'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function fileExport()
    {
        try {
            return $this->excelFileExport((new ProgramsExport($this->selected)), 'program-collection.xlsx');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
