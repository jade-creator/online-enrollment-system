<?php

namespace App\Http\Livewire\Admin\ProgramComponent;

use App\Models\Program;
use App\Services\ProgramService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProgramDestroyComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    protected $listeners = [
        'removeProgram',
        'removeConfirm',
    ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeConfirm(Program $program) {
        $this->confirm('removeProgram', 'Are you sure you want this deleted?', $program);
    }

    public function removeProgram(Program $program)
    {
        try {
            $this->authorize('destroy', $program);
            $program = (new ProgramService())->destroy($program);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $program->program.' has been deleted.',
            ]);
            return redirect(route('admin.programs.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
