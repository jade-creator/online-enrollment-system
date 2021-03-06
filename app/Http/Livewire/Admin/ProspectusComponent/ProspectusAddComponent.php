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
    public string $prospectusId = '', $curriculumId = '';
    public array $preRequisiteSubjects = [], $coRequisiteSubjects = [];
    public $subjects, $preRequisites, $coRequisites;

    protected $listeners = [
        'modalAddingSubject',
        'updatePreRequisiteSubjects' => 'setPreRequisiteSubjects',
        'updateCoRequisiteSubjects' => 'setCoRequisiteSubjects'
    ];

    public function rules()
    {
        return [
            'prospectusSubject.subject_id' => ['required'],
            'prospectusSubject.unit' => ['required', 'integer', 'min:1'],
            'prospectusSubject.isComputed' => ['boolean'],
        ];
    }

    protected $messages = [
        'prospectusSubject.subject_id.required' => 'The subject field cannot be empty.',
        'prospectusSubject.unit.required' => 'The unit field cannot be empty.',
    ];

    public function mount() {
        $this->prospectusSubject = new ProspectusSubject();
    }

    public function render() { return
        view('livewire.admin.prospectus-component.prospectus-add-component');
    }

    public function modalAddingSubject()
    {
        $this->resetValidation();
        $this->fill([
            'prospectusSubject' => new ProspectusSubject(),
            'preRequisiteSubjects' => [],
            'coRequisiteSubjects' => [],
        ]);
        $this->toggleAddingSubject();
    }

    public function setCoRequisiteSubjects($value) { $this->coRequisiteSubjects = $value; }

    public function setPreRequisiteSubjects($value) { $this->preRequisiteSubjects = $value; }

    public function save()
    {
        $this->validate();

        $this->toggleAddingSubject();

        try {
            $prospectusSubject = (new ProspectusSubjectService())->store($this->prospectusSubject, $this->prospectusId, $this->curriculumId, $this->preRequisiteSubjects, $this->coRequisiteSubjects);

            $this->emitUp('sessionFlashAlert', 'alert', 'success', $prospectusSubject->subject->code.' has been added.');
        }catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
        }
    }

    public function toggleAddingSubject()
    {
        $this->resetValidation();
        $this->addingSubject = !$this->addingSubject;
    }
}
