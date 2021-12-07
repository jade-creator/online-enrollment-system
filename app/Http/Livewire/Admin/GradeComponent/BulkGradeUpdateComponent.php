<?php

namespace App\Http\Livewire\Admin\GradeComponent;

use App\Models\Grade;
use App\Models\Registration;
use App\Models\Section;
use App\Services\Grade\GradeService;
use App\Traits\WithSweetAlert;
use Livewire\Component;

class BulkGradeUpdateComponent extends Component
{
    use WithSweetAlert;

    public Section $section;
    public bool $viewingBulkGrade = FALSE;
    public string $type = 'scale', $prospectusSubjectId = '';
    public ?string $value = '';
    public array $selected = [];

    protected $messages = [
        'prospectusSubjectId.required' => 'The subject field cannot be empty.',
        'type.required' => 'The type field cannot be empty.',
        'value.required_if' => 'The value field cannot be empty.',
    ];

    public function rules()
    {
        return [
            'prospectusSubjectId' => ['required'],
            'type' => ['required'],
            'value' => ['required_if:type,scale'],
        ];
    }

    protected $listeners = ['modalViewingBulkGrade' => 'toggleModal'];

    public function render()
    {
        return view('livewire.admin.grade-component.bulk-grade-update-component');
    }

    public function update()
    {
        $this->validate();

        try {
            (new GradeService())->bulkUpdateThroughRegistrations($this->selected, $this->prospectusSubjectId, $this->type, $this->value);

            $this->toggleModal();
            $this->emitUp( 'sessionFlashAlert', 'alert', 'success', "Students' Grade Successfully updated.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function toggleModal() : bool { return
        $this->viewingBulkGrade = !$this->viewingBulkGrade;
    }

    public function updatedViewingGrade($value) {
        if (! $value) $this->reset('type', 'value');
    }
}
