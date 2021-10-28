<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Exports\SubjectsExport;
use App\Models\Subject;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class SubjectIndexComponent extends Livewire\Component
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

    protected $updatesQueryString = [ 'search' ];

    protected $listeners = [
        'refresh' => '$refresh',
        'DeselectPage' => 'updatedSelectPage',
        'alertParent',
        'fileExport'
    ];

    protected array $allowedSorts = [
        'id',
        'code',
        'title',
    ];

    public function render() { return
        view('livewire.admin.subject-component.subject-index-component', ['subjects' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Subject::search($this->search)
            ->select(['id', 'code', 'title', 'description', 'created_at'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function alertParent(string $type = '', string $message = '')
    {
        session()->flash('alert', [
            'type' => $type,
            'message' => $message,
        ]);

        $this->emit('alert');
    }

    public function fileExport() { return
        $this->excelFileExport((new SubjectsExport($this->selected)), 'subject-collection.xlsx');
    }
}
