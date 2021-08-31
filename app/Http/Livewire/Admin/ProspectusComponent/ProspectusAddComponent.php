<?php

namespace App\Http\Livewire\Admin\ProspectusComponent;

use App\Models\ProspectusSubject;
use App\Services\Prospectus\ProspectusSubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProspectusAddComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public ProspectusSubject $prospectusSubject;
    public bool $addingSubject = false;
    public string $prospectusId = '';
    public array $preRequisiteSubjects = [];
    public $subjects, $preRequisites;

    protected $listeners = [
        'modalAddingSubject',
        'updatePreRequisiteSubjects' => 'setPreRequisiteSubjects'
    ];

    public function rules()
    {
        return [
            'prospectusSubject.subject_id' => ['required', 'integer'],
            'prospectusSubject.unit' => ['required', 'integer', 'min:1'],
        ];
    }

    public function render() { return
        view('livewire.admin.prospectus-component.prospectus-add-component');
    }

    public function modalAddingSubject()
    {
        $this->resetValidation();
        $this->fill([
            'prospectusSubject' => new ProspectusSubject(),
            'addingSubject' => !$this->addingSubject,
            'preRequisiteSubjects' => [],
        ]);
    }

    public function setPreRequisiteSubjects($value) {
        $this->preRequisiteSubjects = $value;
    }

    public function save()
    {
        $this->authorize('create', ProspectusSubject::class);
        $this->validate();

        try {
            (new ProspectusSubjectService())->store($this->prospectusSubject, $this->prospectusId, $this->preRequisiteSubjects);

            $this->emitUp('refresh');
            $this->success($this->prospectusSubject->subject->code.' has been added.');
        }catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
