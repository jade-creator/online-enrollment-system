<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Models\Subject;
use App\Services\SubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SubjectDestroyComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    protected $listeners = [ 'removeSubject' ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeSubject(Subject $subject)
    {
        $this->authorize('destroy', $subject);

        try {
            (new SubjectService())->destroy($subject);

            $this->emitUp('refresh');
            $this->success($subject->code." has been deleted.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
