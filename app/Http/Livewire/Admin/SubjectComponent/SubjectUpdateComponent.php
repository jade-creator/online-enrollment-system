<?php

namespace App\Http\Livewire\Admin\SubjectComponent;

use App\Models\Subject;
use App\Services\SubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SubjectUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Subject $subject;
    public $route;

    public function rules()
    {
        return [
            'subject.code' => ['required', 'string', 'max:100', 'alpha_num', 'unique:subjects,code,'.$this->subject->id],
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
        $this->route = url()->previous();
    }

    public function render() { return
        view('livewire.admin.subject-component.subject-update-component');
    }

    public function update()
    {
        $this->validate();

        try {
            $subject = (new SubjectService())->update($this->subject);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $subject->code.' has been updated.',
            ]);

            return redirect($this->route);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
