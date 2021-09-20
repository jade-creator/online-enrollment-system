<?php

namespace App\Http\Livewire\Admin\FeeComponent;

use App\Exports\FeesExport;
use App\Models;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class FeeIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert;

    public string $programId = '', $categoryId = '';
    public int $paginateValue = 10;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'programId' => [ 'except' => '' ],
        'categoryId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [ 'search' ];

    protected array $allowedSorts = [
        'id',
        'amount',
    ];

    protected $listeners = [
        'refresh' => '$refresh',
        'fileExport',
    ];

    public function render() { return
        view('livewire.admin.fee-component.fee-index-component', ['fees' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Fee::search($this->search)
            ->select(['id', 'category_id', 'program_id', 'price', 'description', 'created_at'])
            ->filterByCategory($this->categoryId)
            ->filterByProgram($this->programId)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }

    public function getCategoriesProperty() { return
        Models\Category::get(['id', 'name']);
    }

    public function fileExport()
    {
        try {
            $this->modal('Downloading...','info','Please wait for the file to be downloaded.');
            return $this->excelFileExport((new FeesExport($this->selected)), 'fee-collection.xlsx');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
