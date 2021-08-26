<?php

namespace App\Http\Livewire\Partials;

use App\Models;
use Livewire\Component;

class ProspectusFilter extends Component
{
    public bool $confirmingTerm = false;
    public $programId, $prospectusId = '', $prospectusCollection;

    protected $queryString = [
        'prospectusId' => [ 'except' => '' ],
        'programId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'prospectusId',
        'programId',
    ];

    public function mount()
    {
        $this->fill([
            'programId' => '',
            'prospectusCollection' => $this->prospectuses
        ]);
    }

    public function render() { return
        view('livewire.partials.prospectus-filter');
    }

    public function getProspectusId($value) { $this->emitUp('setProspectusId', $value); }

    public function updatedProspectusId()
    {
        $this->getProspectusId($this->prospectusId);
        $this->fill([ 'confirmingTerm' => !$this->confirmingTerm ]);
    }

    public function updatedProgramId()
    {
        if (empty($this->programId)) return $this->getProspectusId('');

        $this->prospectusCollection = $this->prospectuses->where('program_id', $this->programId);
        $this->getProspectusId($this->prospectusCollection->first()->id);
    }

    public function getProgramsProperty() { return
        Models\Program::select(['id', 'code'])
            ->get();
    }

    public function getProspectusesProperty() { return
        Models\Prospectus::select(['id', 'level_id', 'program_id', 'term_id'])
            ->with([
                'level:id,level',
                'term:id,term',
            ])
            ->get();
    }
}
