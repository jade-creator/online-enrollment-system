<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Models\Subject;
use App\Services\SubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SubjectAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Subject $subject;

    public function rules()
    {
        return [
            'subject.code' => ['required', 'string', 'max:100', 'alpha_num', 'unique:subjects,code'],
            'subject.title' => ['required', 'string', 'max:100'],
            'subject.description' => ['required', 'string', 'max:500'],
        ];
    }

    protected $messages = [
        'subject.code.required' => 'The code field cannot be empty.',
        'subject.title.required' => 'The program field cannot be empty.',
        'subject.description.required' => 'The description field cannot be empty.',
    ];

    public function mount() {
        $this->subject = new Subject();
    }

    public function render() { return
        view('livewire.admin.subject-component.subject-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $subject = (new SubjectService())->store($this->subject);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $subject->code.' has been added.',
            ]);
            return redirect(route('admin.subjects.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
