<?php

namespace App\Http\Livewire\Admin\ProspectusComponent;

use App\Models\ProspectusSubject;
use App\Services\Prospectus\ProspectusSubjectService;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ProspectusUpdateComponent extends Component
{
    use AuthorizesRequests;
    use WithSweetAlert;

    public ProspectusSubject $prospectusSubject;
    public bool $viewingSubject = false;
    public array $preRequisiteSubjects = [], $coRequisiteSubjects = [];
    public $subjects, $preRequisites, $coRequisites;

    protected $listeners = [
        'modalViewingSubject',
        'updatePreRequisiteSubjects' => 'setPreRequisiteSubjects',
        'updateCoRequisiteSubjects' => 'setCoRequisiteSubjects',
    ];

    public function rules()
    {
        return [
            'prospectusSubject.subject_id' => ['required', 'integer'],
            'prospectusSubject.unit' => ['required', 'integer', 'min:1'],
        ];
    }

    protected $messages = [
        'prospectusSubject.subject_id.required' => 'The subject field cannot be empty.',
        'prospectusSubject.unit.required' => 'The unit field cannot be empty.',
    ];

    public function mount() {
        $this->setSubject(new ProspectusSubject());
    }

    public function render() { return
        view('livewire.admin.prospectus-component.prospectus-update-component');
    }

    public function setCoRequisiteSubjects($value) { $this->coRequisiteSubjects = $value; }

    public function setPreRequisiteSubjects($value) { $this->preRequisiteSubjects = $value; }

    public function update()
    {
        $this->validate();

        try {
            $this->authorize('update', $this->prospectusSubject);
            (new ProspectusSubjectService())->update($this->prospectusSubject, $this->preRequisiteSubjects, $this->coRequisiteSubjects);

            $this->success($this->prospectusSubject->subject->code.' has been updated.');
            $this->toggleViewingSubject();
            $this->emitUp('refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function modalViewingSubject(ProspectusSubject $prospectusSubject)
    {
        $this->setSubject($prospectusSubject);

        $this->preRequisiteSubjects = [];
        $this->coRequisiteSubjects = [];

        // populate dropdown pre-requisites: if subject has at least a pre-requisite.
        if ($prospectusSubject->prerequisites->isNotEmpty()) {
            $preRequisites = $prospectusSubject->prerequisites->pluck('id')->toArray();
            $this->preRequisiteSubjects = array_map(fn($value) => (string)$value, $preRequisites);
        }

        // populate dropdown co-requisites: if subject has at least a co-requisite.
        if ($prospectusSubject->corequisites->isNotEmpty()) {
            $coRequisites = $prospectusSubject->corequisites->pluck('id')->toArray();
            $this->coRequisiteSubjects = array_map(fn($value) => (string)$value, $coRequisites);
        }

        // unset selected subject
        $this->coRequisites = $this->coRequisites->filter(function ($requisite) use ($prospectusSubject) {
            return $requisite->subject->id != $prospectusSubject->subject_id;
        });

        $this->toggleViewingSubject();
    }

    public function toggleViewingSubject()
    {
        $this->resetValidation();
        $this->viewingSubject = !$this->viewingSubject;
    }

    public function setSubject(ProspectusSubject $prospectusSubject) { $this->prospectusSubject = $prospectusSubject; }
}
