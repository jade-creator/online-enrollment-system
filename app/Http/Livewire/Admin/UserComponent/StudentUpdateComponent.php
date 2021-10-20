<?php

namespace App\Http\Livewire\Admin\UserComponent;

use App\Models;
use App\Traits\WithSweetAlert;
use Livewire\Component;

class StudentUpdateComponent extends Component
{
    use WithSweetAlert;

    public Models\Student $student;
    public string $curriculumId = '';

    public function rules()
    {
        return [
            'student.custom_id' => ['required', 'unique:students,custom_id,'.$this->student->id, 'alpha_num', 'max:100'],
            'student.program_id' => ['required'],
            'student.curriculum_id' => ['required'],
            'student.isRegular' => ['required', 'boolean'],
            'student.isNew' => ['required', 'boolean'],
        ];
    }

    protected $messages = [
        'student.custom_id.required' => 'The student id field cannot be empty.',
        'student.custom_id.unique' => 'The student id has already been taken.',
        'student.program_id.required' => 'The program field cannot be empty.',
        'student.curriculum_id.required' => 'The curriculum field cannot be empty.',
        'student.isRegular.required' => 'The classification field cannot be empty.',
        'student.isNew.required' => 'The type field cannot be empty.',
    ];

    public function mount() { $this->curriculumId = $this->student->curriculum_id ?? ''; }

    public function render() { return
        view('livewire.admin.user-component.student-update-component', ['curriculums' => $this->getCurriculums()]);
    }

    public function update()
    {
        $this->validate();

        try {
            $this->student->update();

            $this->emit('saved');

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $this->student->user->person->full_name.`'s detail has been updated.`,
            ]);
            return redirect(route('users.students.index'));
        } catch (\Exception $e) {
            $this->emit('error');

            $this->error($e->getMessage());
        }
    }

    public function getProgramsProperty() { return
        Models\Program::get(['id', 'program']);
    }

    public function getCurriculums() { return
        Models\Curriculum::when(filled($this->student->program_id), function ($query) {
            return $query->where('program_id', $this->student->program_id);
        })->get(['id', 'code', 'program_id']);
    }

    public function updatedStudentProgramId()
    {
        $curriculumIds = $this->getCurriculums()->pluck('id')->toArray();

        if (count($curriculumIds) > 0 && is_array($curriculumIds)
            && filled($this->student->curriculum_id) && ! in_array($this->student->curriculum_id, $curriculumIds)) {
            $this->student->curriculum_id = '';
        } else {
            $this->student->curriculum_id = $this->curriculumId;
        }
    }
}
