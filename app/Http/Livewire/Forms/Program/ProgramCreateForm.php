<?php

namespace App\Http\Livewire\Forms\Program;

use App\Models\Program;
use Livewire\Component;

class ProgramCreateForm extends Component
{
    public $code;
    public $program;
    public $description;

    protected $rules = [
        'code' => ['required', 'string', 'max:255'],
        'program' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
    ];

    public function render() { return 
        view('livewire.forms.program.program-create-form');
    }

    public function save()
    {
        $this->validate();

        Program::create([
            'code' => $this->code,
            'program' => $this->program,
            'description' => $this->description,
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Program Saved',
            'data' => $this->code,
            'message' => ' has been saved.',
        ]);

        return redirect()->to('admin/programs');
    }
}
