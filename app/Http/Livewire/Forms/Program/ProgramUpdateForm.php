<?php

namespace App\Http\Livewire\Forms\Program;

use App\Models\Program;
use Livewire\Component;

class ProgramUpdateForm extends Component
{
    public Program $program;

    protected $rules = [
        'program.code' => ['required', 'string', 'max:255'],
        'program.program' => ['required', 'string', 'max:255'],
        'program.description' => ['required', 'string'],
    ];
    
    public function render() { return 
        view('livewire.forms.program.program-update-form');
    }

    public function update()
    {
        $this->validate();
        $this->program->update();

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Program Updated',
            'data' => $this->program->code,
            'message' => ' has been updated.',
        ]);

        return redirect()->to('admin/programs');
    }
}
