<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Models\Subject;
use App\Services\SubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SubjectUpdateComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public Subject $subject;
    public bool $viewingSubject = false;

    protected $listeners = [ 'modalViewingSubject' ];

    public function rules()
    {
        return [
            'subject.code' => ['required', 'string', 'max:100'],
            'subject.title' => ['required', 'string', 'max:100'],
            'subject.description' => ['required', 'string', 'max:500'],
        ];
    }

    public function mount() { $this->setSubject(new Subject()); }

    public function render() { return
        view('livewire.admin.subject-component.subject-update-component');
    }

    public function update()
    {
        $this->authorize('update', $this->subject);
        $this->validate();

        try {
            (new SubjectService())->update($this->subject);

            $this->emitUp('refresh');
            $this->success($this->subject->code.' has been updated.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->toggleViewingSubject();
    }

    public function modalViewingSubject(Subject $subject)
    {
        $this->setSubject($subject);
        $this->toggleViewingSubject();
    }

    public function toggleViewingSubject()
    {
        $this->resetValidation();
        $this->viewingSubject = !$this->viewingSubject;
    }

    public function setSubject(Subject $subject) { $this->subject = $subject; }
}
