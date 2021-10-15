<?php

namespace App\Http\Livewire\Admin\CurriculumComponent;

use App\Models\Curriculum;
use App\Services\CurriculumService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CurriculumDestroyComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    protected $listeners = [
        'removeCurriculum',
        'removeConfirm',
    ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeConfirm(Curriculum $curriculum)
    {
        $this->confirm('removeCurriculum', 'Are you sure you want this deleted?', $curriculum);
    }

    public function removeCurriculum(Curriculum $curriculum)
    {
        try {
            $this->authorize('destroy', $curriculum);
            $curriculum = (new CurriculumService())->destroy($curriculum);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $curriculum->code.' has been deleted',
            ]);
            return redirect(route('admin.curricula.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
