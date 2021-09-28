<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Models\Subject;
use App\Services\SubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SubjectDestroyComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

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

    public function removeConfirm(Subject $subject) { return
        $this->confirm('removeSubject', 'Are you sure you want this deleted?', $subject);
    }

    public function removeSubject(Subject $subject)
    {
        try {
            $this->authorize('destroy', $subject);
            $subject = (new SubjectService())->destroy($subject);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $subject->code.' has been deleted.',
            ]);
            return redirect(route('admin.subjects.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
