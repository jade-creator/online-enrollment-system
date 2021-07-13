<?php

namespace App\Http\Livewire\Admin\StrandComponent;

use App\Exports\StrandsExport;
use App\Models\Prospectus;
use App\Models\SchoolType;
use App\Models\Strand;
use App\Models\Term;
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
    public bool $confirmingExport = false, $addingStrand = false, $viewingStrand = false;
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

    public function removeConfirm() {
        return $this->dispatchBrowserEvent('swal:modal', [ 
            'title' => "Unable Action!",
            'type' => "error",
            'text' => "The system detected that this strand is already added in a prospectus. There maybe students enrolled under it, this
            action can produce inconsistent data.",
        ]);
    }

    public function addingStrand()
    {
        if (!$this->trackId) {
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Oops Sorry..",
                'type' => "error",
                'text' => "Please fill up the necessary fields (Track) accordingly.",
            ]);
        }

        $this->fill([ 'addingStrand' => true ]);
    }

    public function viewStrand(Strand $strand)
    {
        $this->fill([
            'strand' => $strand,
            'viewingStrand' => true,
        ]);
    }

    public function updateStrand()
    {
        $this->validate();
        $this->strand->save();

        $this->dispatchBrowserEvent('swal:success', [ 
            'text' => "The strand has been updated.",
        ]);

        $this->fill([ 'viewingStrand' => false ]);
    }

    public function save() 
    {
        $this->validate();

        $type = SchoolType::where('type', 'Senior High School')
            ->with('levels')
            ->first();
        
        if (!$type) {
            return $this->dispatchBrowserEvent('swal:modal', [ 
                'title' => "Oops Sorry..",
                'type' => "error",
                'text' => "Internal Server Error 404.",
            ]);
        }

        $this->strand->track_id = $this->trackId;
        $this->strand->save();
        $terms = Term::get(['id']);

        $levelIds = $type->levels->pluck('id')->toArray();
        sort($levelIds);

        foreach ($levelIds as $key => $levelId) {

            if ($key > 2) {
                break;
            }

            $terms->map(function ($term) use ($levelId) {
                Prospectus::create([
                    'level_id' => $levelId,
                    'strand_id' => $this->strand->id,
                    'term_id' => $term->id,
                ]);
            });
        }

        $this->fill([ 'addingStrand' => false ]);
    }

    public function updatedViewingStrand($value)
    {
        if (!$value) {
            $this->fill([ 'strand' => new Strand() ]);
        }
    }

    public function updatedAddingStrand()
    {
        $this->fill([ 'strand' => new Strand() ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        return (new StrandsExport($this->selected))->download('strands-collection.xlsx');
    }    

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}
