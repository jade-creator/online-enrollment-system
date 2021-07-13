<?php

namespace App\Http\Livewire\Admin\FeeComponent;

use App\Exports\FeesExport;
use App\Models\Fee;
use App\Models\Level;
use App\Models\Program;
use App\Models\Prospectus;
use App\Models\Strand;
use Livewire\Component;
use App\Traits\WithBulkActions;

class FeeViewComponent extends Component
{
    public Fee $fee;
    public $search = '', $paginateValue = 1;
    public bool $applyToAll = false, $confirmingExport = false, $addingFees = false, $viewingFee = false;
    public $prospectus, $levelId, $programId, $strandId, $termId;

    use WithBulkActions;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'levelId' => [ 'except' => '' ],
        'programId' => [ 'except' => '' ],
        'strandId' => [ 'except' => '' ],
        'termId' => [ 'except' => '' ],
    ];
    
    protected $updatesQueryString = [
        'search',
        'levelId',
        'programId',
        'strandId',
        'termId',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage', 'removeItem'];

    public function rules() 
    {
        return [
            'fee.name' => ['required', 'string'],
            'fee.price' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function mount() 
    {
        $level = $this->levels->first();

        $this->fill([ 
            'fee' => new Fee(),
            'levelId' => $level->id, 
        ]);
    }
    
    public function render() { return 
        view('livewire.admin.fee-component.fee-view-component', ['prospectus' => $this->rows]);
    }

    public function getRowsProperty() { return 
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        $this->prospectus = Prospectus::select(['id', 'level_id', 'program_id', 'strand_id', 'term_id'])
            ->with('fees')
            ->when(!empty($this->levelId), function($query) {
                return $query->where('level_id', $this->levelId);
            })
            ->when(!empty($this->programId), function($query) {
                return $query->where('program_id', $this->programId);
            })
            ->when(!empty($this->strandId), function($query) {
                return $query->where('strand_id', $this->strandId);
            })
            ->when(!empty($this->termId), function($query) {
                return $query->where('term_id', $this->termId);
            })
            ->first();

        return $this->prospectus;
    }

    public function removeConfirm(Fee $fee) {
        $this->fee = $fee;

        $this->dispatchBrowserEvent('swal:confirmDelete', [ 
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'Please note that upon deletion it cannot be retrievable.',
        ]);
    }

    public function removeItem()
    {   
        $this->fee->delete();
    }

    public function updateFee()
    {
        $this->validate();
        $this->fee->save();
        $this->fill([ 'viewingFee' => false ]);

        $this->dispatchBrowserEvent('swal:success', [ 
            'text' => "The fee has been updated.",
        ]);
    }

    public function viewFee(Fee $fee)
    {
        $this->fill([
            'fee' => $fee,
            'viewingFee' => true,
        ]);
    }

    public function save()
    {
        $this->validate();

        $this->fee->save();

        if ($this->applyToAll) {
            $prospectuses = $this->prospectuses->pluck('id')->toArray();
            $this->fee->prospectuses()->attach($prospectuses);
        } else {
            $this->prospectus->fees()->attach($this->fee->id);
        }

        $this->fill([
            'fee' => new Fee(),
            'addingFees' => false,
        ]);

        $this->resetValidation();
    }

    public function getProspectusesProperty() { return
        Prospectus::get('id');
    }

    public function getLevelsProperty() { return
        Level::get(['id', 'level']);
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'code']);
    }

    public function getStrandsProperty() { return
        Strand::get(['id', 'code']);
    }

    public function resetFields()
    {
        $this->fill([ 'fee' => new Fee() ]);
        $this->resetValidation();
    }

    public function updatedViewingFee($value)
    {
        if (!$value) {
            $this->resetFields();
        }
    }

    public function updatedAddingFees()
    {
        $this->resetFields();
    }

    public function updatedLevelId() 
    {
        $this->fill([
            'programId' => '',
            'strandId' => '',
            'termId' => '',
        ]);
    }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        return (new FeesExport($this->selected))->download('fees-collection.xlsx');
    }    
}
