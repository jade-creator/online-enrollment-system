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
    public string $code = '', $type = 'scale';
    public ?string $value = '';
    public bool $viewingGrade = false;

    protected $listeners = ['modalViewingGrade'];

    public function rules()
    {
        return [
            'type' => ['required'],
            'value' => ['required_if:type,scale'],
        ];
    }

    protected $messages = [
        'value.required_if' => 'The value is required.',
    ];

    public function render() { return
        view('livewire.admin.grade-component.grade-update-component');
    }

    public function modalViewingGrade(Grade $grade)
    {
        if ($grade->isScale) {
            $this->type = 'scale';
        } else {
            $this->type = $grade->mark->name ?? '';
        }

        $this->resetValidation();
        $this->fill([
            'grade' => $grade,
            'code' => $grade->prospectus_subject->subject->code,
        ]);
        $this->toggleModal();
    }

    public function update()
    {
        $this->validate();

        try {
            $this->authorize('update', $this->grade);
            $this->grade->value = $this->value;
            $grade = (new GradeService())->update($this->grade, $this->type);

            $this->success('Equivalent: '.$grade->value.' ('.$grade->mark->name.')');
            $this->toggleModal();
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function toggleModal() : bool { return
        $this->viewingGrade = !$this->viewingGrade;
    }
}
