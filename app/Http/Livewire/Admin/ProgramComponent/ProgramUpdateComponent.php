<?php

namespace App\Http\Livewire\Admin\ProgramComponent;

use App\Models\Program;
use App\Services\ProgramService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProgramUpdateComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public Program $program;
    public bool $viewingProgram = false;

    protected $listeners = ['modalViewingProgram'];

    public function rules()
    {
        return [
            'program.code' => ['required', 'string', 'max:100'],
            'program.program' => ['required', 'string', 'max:100'],
            'program.description' => ['required', 'string', 'max:500'],
        ];
    }

    public function render() { return
        view('livewire.admin.program-component.program-update-component');
    }

    public function modalViewingProgram(Program $program)
    {
        $this->resetValidation();
        $this->program = $program;
        $this->toggleModal();
    }

    public function update()
    {
        $this->authorize('update', $this->program);
        $this->validate();

        try {
            (new ProgramService())->update($this->program);

            $this->toggleModal();
            $this->emitUp('refresh');
            $this->success($this->program->code.' has been updated.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function toggleModal() : bool { return
        $this->viewingProgram = !$this->viewingProgram;
    }
}
