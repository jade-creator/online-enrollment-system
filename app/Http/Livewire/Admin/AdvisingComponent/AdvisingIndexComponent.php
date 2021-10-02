<?php

namespace App\Http\Livewire\Admin\AdvisingComponent;

use App\Models;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class AdvisingIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert;

    public int $paginateValue = 10;
    public string $programId = '', $levelId = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'programId' => [ 'except' => '' ],
        'levelId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'programId',
        'levelId',
    ];

    protected array $allowedSorts = ['id'];

    protected $listeners = [
        'DeselectPage' => 'updatedSelectPage',
        'fileExport',
    ];

    public function render() { return
        view('livewire.admin.advising-component.advising-index-component', ['advice' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Advice::search($this->search)
            ->select(['id', 'date', 'time', 'program_id', 'level_id', 'link', 'remarks', 'created_at'])
            ->when(filled($this->programId), function ($query) {
                return $query->where('program_id', $this->programId);
            })
            ->when(filled($this->levelId), function ($query) {
                return $query->where('level_id', $this->levelId);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }
}
