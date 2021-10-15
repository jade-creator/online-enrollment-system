<?php

namespace App\Http\Livewire\Admin\CurriculumComponent;

use App\Models;
use App\Services\CurriculumService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CurriculumUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Curriculum $curriculum;

    public function rules()
    {
        return [
            'curriculum.code' => ['required', 'string', 'max:100', 'alpha_num', 'unique:curricula,code,'.$this->curriculum->id],
            'curriculum.program_id' => ['required'],
            'curriculum.description' => ['nullable', 'string'],
            'curriculum.start_date' => ['required', 'date'],
            'curriculum.end_date' => ['required', 'date', 'after:curriculum.start_date'],
        ];
    }

    protected $messages = [
        'curriculum.code.required' => 'The code field cannot be empty.',
        'curriculum.code.alpha_num' => 'The code may only contain letters, numbers with no spaces.',
        'curriculum.program_id.required' => 'The program field cannot be empty.',
        'curriculum.start_date.required' => 'The start date field cannot be empty.',
        'curriculum.end_date.required' => 'The end date field cannot be empty.',
    ];

    public function render() { return
        view('livewire.admin.curriculum-component.curriculum-update-component');
    }

    public function update()
    {
        $this->validate();

        try {
            $this->authorize('update', $this->curriculum);
            $curriculum = (new CurriculumService())->update($this->curriculum);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $curriculum->code.' has been updated.',
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
