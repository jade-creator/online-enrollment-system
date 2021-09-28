<?php

namespace App\Http\Livewire\Admin\ProgramComponent;

use App\Models\Program;
use App\Services\ProgramService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProgramUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Program $program;
    public $years;

    public function rules()
    {
        return [
            'program.code' => ['required', 'string', 'max:100'],
            'program.program' => ['required', 'string', 'max:100'],
            'program.description' => ['required', 'string', 'max:500'],
        ];
    }

    protected $messages = [
        'program.code.required' => 'The code field cannot be empty.',
        'program.program.required' => 'The program field cannot be empty.',
        'program.description.required' => 'The description field cannot be empty.',
    ];

    public function mount() {
        $this->years = $this->program->year;
    }

    public function render() { return
        view('livewire.admin.program-component.program-update-component');
    }

    public function update()
    {
        $this->validate();

        try {
            $this->authorize('update', $this->program);
            $program = (new ProgramService())->update($this->program);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $program->program.' has been updated.',
            ]);
            return redirect(route('admin.programs.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
