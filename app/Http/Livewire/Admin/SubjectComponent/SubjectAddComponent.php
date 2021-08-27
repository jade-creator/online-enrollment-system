<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Models\Subject;
use App\Services\SubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SubjectAddComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public Subject $subject;
    public bool $addingSubject = false;

    protected $listeners = [ 'modalAddingSubject' ];

    public function rules()
    {
        return [
            'subject.code' => ['required', 'string', 'max:100'],
            'subject.title' => ['required', 'string', 'max:100'],
            'subject.description' => ['required', 'string', 'max:500'],
        ];
    }

    public function render() { return
        view('livewire.admin.subject-component.subject-add-component');
    }

    public function modalAddingSubject()
    {
        $this->resetValidation();
        $this->fill([
            'subject' => new Subject(),
            'addingSubject' => !$this->addingSubject,
        ]);
    }

    public function save()
    {
        $this->authorize('create', Subject::class);
        $this->validate();

        try {
            (new SubjectService())->store($this->subject);

            $this->emitUp('refresh');
            $this->success($this->subject->code." has been added.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->modalAddingSubject();
    }
}
