<?php

namespace App\Http\Livewire\Admin\ProspectusComponent;

use App\Models\ProspectusSubject;
use App\Services\Prospectus\ProspectusSubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProspectusDestroyComponent extends Component
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

    public function removeSubject(ProspectusSubject $prospectusSubject)
    {
        $this->authorize('destroy', $prospectusSubject);

        try {
            (new ProspectusSubjectService())->destroy($prospectusSubject);

            $this->emitUp('refresh');
            $this->success($prospectusSubject->subject->code." has been deleted.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
