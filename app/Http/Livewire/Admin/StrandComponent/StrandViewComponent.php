<?php

namespace App\Http\Livewire\Admin\StrandComponent;

use App\Models\Strand;
use App\Models\Track;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithFilters;
use App\Traits\WithBulkActions;
use App\Traits\WithSorting;

class StrandViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public Strand $strand;
    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingStrand = false;
    public $trackId = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'trackId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'trackId',
    ];

    protected array $allowedSorts = [
        'code',
        'strand',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function rules() 
    {
        return [
            'strand.code' => ['required', 'string', 'max:255'],
            'strand.strand' => ['required', 'string'],
        ];
    }

    public function mount() 
    {
        $this->fill([ 'strand' => new Strand() ]);
    }

    public function render() { return 
        view('livewire.admin.strand-component.strand-view-component', ['strands' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() 
    {
        return Strand::search($this->search)
            ->select(['id', 'code', 'strand', 'track_id', 'created_at'])
            ->when(!empty($this->trackId), function ($query) {
                return $query->where('track_id', $this->trackId);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });
    }

    public function getTracksProperty() { return
        Track::get(['id', 'track']);
    }

    public function save() 
    {
        $this->validate();

        $this->strand->track_id = $this->trackId;
        $this->strand->save();

        $this->fill([ 'addingStrand' => false ]);
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
