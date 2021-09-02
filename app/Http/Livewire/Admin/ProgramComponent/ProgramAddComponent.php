<?php

namespace App\Http\Livewire\Admin\ProgramComponent;

use App\Models\Program;
use App\Services\ProgramService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProgramAddComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public Program $program;
    public bool $addingProgram = false;

    protected $listeners = ['modalAddingProgram'];

    public function rules()
    {
        return [
            'program.code' => ['required', 'string', 'max:100'],
            'program.program' => ['required', 'string', 'max:100'],
            'program.description' => ['required', 'string', 'max:500'],
            'program.year' => ['required', 'integer', 'max:5', 'min:1'],
        ];
    }

    public function render() { return
        view('livewire.admin.program-component.program-add-component');
    }

    public function modalAddingProgram()
    {
        $this->resetValidation();
        $this->program = new Program();
        $this->toggleModal();
    }

    public function save()
    {
        $this->authorize('create', Program::class);
        $this->validate();

        try {
            (new ProgramService())->store($this->program);

            $this->toggleModal();
            $this->emitUp('refresh');
            $this->success($this->program->code.' has been added.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function toggleModal() : bool { return
        $this->addingProgram = !$this->addingProgram;
    }
}
