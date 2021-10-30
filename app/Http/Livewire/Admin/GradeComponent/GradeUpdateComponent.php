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

    public ?Grade $grade = NULL;
    public string $code = '', $type = 'scale';
    public ?string $value = '';
    public bool $viewingGrade = FALSE;

    protected $listeners = ['modalViewingGrade'];

    protected $messages = [
        'type.required' => 'The type field cannot be empty.',
        'value.required_if' => 'The value field cannot be empty.',
    ];

    public function rules()
    {
        return [
            'type' => ['required'],
            'value' => ['required_if:type,scale'],
        ];
    }

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

        $this->toggleModal();

        try {
            $this->authorize('update', $this->grade);
            $this->grade->value = $this->value;
            $grade = (new GradeService())->update($this->grade, $this->type);

            $this->emitUp( 'sessionFlashAlert', 'alert', 'success', 'Sem Grade updated: '.$grade->fresh()->mark->name);
        } catch (\Exception $e) {
            $this->emitUp( 'sessionFlashAlert', 'alert', 'danger', $e->getMessage());
        }
    }

    public function toggleModal() : bool { return
        $this->viewingGrade = !$this->viewingGrade;
    }

    public function updatedViewingGrade($value) {
        if (! $value) $this->reset('grade');
    }
}
