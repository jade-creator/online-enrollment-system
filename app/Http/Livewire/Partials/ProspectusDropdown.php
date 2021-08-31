<?php

namespace App\Http\Livewire\Partials;

use App\Models\Program;
use Livewire\Component;

class ProspectusDropdown extends Component
{
    public function render() { return
        view('livewire.partials.prospectus-dropdown', [ 'programs' => $this->programs ]);
    }

    public function getProgramsProperty()
    {
        return Program::with([
                'prospectuses:id,level_id,program_id,term_id',
                'prospectuses.level:id,level',
                'prospectuses.term:id,term',
            ])
            ->get([ 'id', 'code' ]);
    }
}
