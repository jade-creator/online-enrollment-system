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

    public string $curriculumId = '';

    protected $listeners = [
        'removeSubject',
        'removeConfirm',
    ];

    public function render()
    {
        return <<<'blade'
            <div>
            </div>
        blade;
    }

    public function removeConfirm(ProspectusSubject $prospectusSubject) {
        $this->confirm('removeSubject', 'Are you sure?', $prospectusSubject);
    }

    public function removeSubject(ProspectusSubject $prospectusSubject)
    {
        $this->authorize('destroy', $prospectusSubject);

        try {
            (new ProspectusSubjectService())->destroy($prospectusSubject, $this->curriculumId);

            $this->emitUp('alertParent', 'success', $prospectusSubject->subject->code.' has been deleted.');
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->emitUp('alertParent', 'danger', $e->getMessage());
        }
    }
}
