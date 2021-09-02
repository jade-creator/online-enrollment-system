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

    protected $listeners = [ 'removeProgram' ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeProgram(Program $program)
    {
        $this->authorize('destroy', $program);

        try {
            (new ProgramService())->destroy($program);

            $this->emitUp('refresh');
            $this->success($program->code." has been deleted.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
