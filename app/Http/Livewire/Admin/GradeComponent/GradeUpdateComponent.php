<?php

namespace App\Http\Livewire\Admin\GradeComponent;

use App\Models\Grade;
use App\Services\Grade\GradeService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class GradeUpdateComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Grade $grade;
    public string $code = '';
    public bool $viewingGrade = false;

    protected $listeners = ['modalViewingGrade'];

    public function rules()
    {
        return [
            'grade.value' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function render() { return
        view('livewire.admin.grade-component.grade-update-component');
    }

    public function modalViewingGrade(Grade $grade)
    {
        $this->resetValidation();
        $this->fill([
            'grade' => $grade,
            'code' => $grade->prospectus_subject->subject->code,
        ]);
        $this->toggleModal();
    }

    public function update()
    {
        $this->authorize('update', $this->grade);
        $this->validate();

        try {
            $grade = (new GradeService())->update($this->grade);

            $this->toggleModal();
            $this->emitUp('refresh');
            $this->success('Remark: '.$grade->mark->name);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function toggleModal() : bool { return
        $this->viewingGrade = !$this->viewingGrade;
    }
}
