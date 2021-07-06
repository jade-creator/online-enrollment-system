<?php

namespace App\Http\Livewire\Admin\TrackComponent;

use App\Models\Track;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithFilters;
use App\Traits\WithBulkActions;
use App\Traits\WithSorting;

class TrackViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public Track $track;
    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingTrack = false;

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
        'track',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function rules() 
    {
        return [
            'track.track' => ['required', 'string'],
            'track.description' => ['required', 'string'],
        ];
    }

    public function mount() 
    {
        $this->fill([ 'track' => new Track() ]);
    }

    public function render() { return 
        view('livewire.admin.track-component.track-view-component', ['tracks' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() 
    {
        return Track::search($this->search)
            ->select(['id', 'track', 'description', 'created_at'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });
    }

    public function save() 
    {
        $this->validate();
        $this->track->save();

        $this->fill([ 'addingTrack' => false ]);
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
