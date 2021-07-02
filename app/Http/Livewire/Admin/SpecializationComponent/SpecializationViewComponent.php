<?php

namespace App\Http\Livewire\Admin\SpecializationComponent;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Specialization;
use App\Traits\WithFilters;
use App\Traits\WithBulkActions;
use App\Traits\WithSorting;

class SpecializationViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public int $paginateValue = 10;
    public bool $confirmingExport = false;
    public string $trackId = '';
    public string $strandId = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'trackId' => [ 'except' => '' ],
        'strandId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'trackId',
        'strandId',
    ];

    protected array $allowedSorts = [
        'specialization',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function render() { return 
        view('livewire.admin.specialization-component.specialization-view-component', ['specializations' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }    

    public function getRowsQueryProperty() 
    {
        return Specialization::search($this->search)
            ->select(['id', 'specialization', 'strand_id', 'created_at'])
            ->with(['strand', 'strand.track'])
            ->whereHas('strand', function ($query) {
                return $query->when(!empty($this->trackId), 
                    fn ($query) => $query->where('track_id', $this->trackId));
            })
            ->when(!empty($this->strandId), 
                    fn ($query) => $query->where('strand_id', $this->strandId))
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