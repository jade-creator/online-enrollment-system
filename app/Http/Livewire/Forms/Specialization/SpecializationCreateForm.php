<?php

namespace App\Http\Livewire\Forms\Specialization;

use App\Models\Specialization;
use App\Models\Strand;
use Livewire\Component;

class SpecializationCreateForm extends Component
{
    public $strandId;
    public $specialization;

    protected $rules = [
        'strandId' => ['required', 'integer'],
        'specialization' => ['required', 'string', 'max:255']
    ];

    public function render() { return 
        view('livewire.forms.specialization.specialization-create-form', ['strands' => Strand::get(['id', 'strand'])]);
    }

    public function save()
    {
        $this->validate();

        Specialization::create([
            'specialization' => $this->specialization,
            'strand_id' => $this->strandId,
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Specialization Saved',
            'data' => $this->specialization,
            'message' => ' has been saved.',
        ]);

        return redirect()->to('admin/specializations');
    }
}
