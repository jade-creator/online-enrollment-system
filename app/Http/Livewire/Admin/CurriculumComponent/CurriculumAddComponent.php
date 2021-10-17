<?php

namespace App\Http\Livewire\Admin\CurriculumComponent;

use App\Models;
use App\Services\CurriculumService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CurriculumAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Curriculum $curriculum;

    public function rules()
    {
        return [
            'curriculum.code' => ['required', 'string', 'max:100', 'alpha_num', 'unique:curricula,code'],
            'curriculum.program_id' => ['required'],
            'curriculum.description' => ['nullable', 'string'],
            'curriculum.isActive' => ['required'],
            'curriculum.start_date' => ['required', 'date'],
            'curriculum.end_date' => ['required', 'date', 'after:curriculum.start_date'],
        ];
    }

    protected $messages = [
        'curriculum.code.required' => 'The code field cannot be empty.',
        'curriculum.code.alpha_num' => 'The code may only contain letters, numbers with no spaces.',
        'curriculum.program_id.required' => 'The program field cannot be empty.',
        'curriculum.isActive.required' => 'The state field cannot be empty.',
        'curriculum.start_date.required' => 'The start date field cannot be empty.',
        'curriculum.end_date.required' => 'The end date field cannot be empty.',
    ];

    public function mount() {
        $this->curriculum = new Models\Curriculum();
    }

    public function render() { return
        view('livewire.admin.curriculum-component.curriculum-add-component');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->authorize('create', Models\Curriculum::class);
            $curriculum = (new CurriculumService())->store($this->curriculum);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $curriculum->code.' has been added.',
            ]);
            return redirect(route('admin.curricula.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'code']);
    }
}
