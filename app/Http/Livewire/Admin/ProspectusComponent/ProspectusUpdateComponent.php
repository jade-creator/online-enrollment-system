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
    public array $preRequisiteSubjects = [];
    public $subjects, $preRequisites;

    protected $listeners = [
        'modalViewingSubject',
        'updatePreRequisiteSubjects' => 'setPreRequisiteSubjects'
    ];

    public function rules()
    {
        return [
            'prospectusSubject.subject_id' => ['required', 'integer'],
            'prospectusSubject.unit' => ['required', 'integer', 'min:1'],
        ];
    }

    public function mount() { $this->setSubject(new ProspectusSubject()); }

    public function render() { return
        view('livewire.admin.prospectus-component.prospectus-update-component');
    }

    public function setPreRequisiteSubjects($value) {
        $this->preRequisiteSubjects = $value;\Debugbar::info($value);
    }

    public function update()
    {
        $this->authorize('update', $this->prospectusSubject);
        $this->validate();

        try {
            (new ProspectusSubjectService())->update($this->prospectusSubject, $this->preRequisiteSubjects);

            $this->emitUp('refresh');
            $this->success($this->prospectusSubject->subject->code.' has been updated.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function modalViewingSubject(ProspectusSubject $prospectusSubject)
    {
        $this->setSubject($prospectusSubject);

        $this->preRequisiteSubjects = [];
        // populate dropdown pre-requisites: if subject has at least a pre-requisite.
        if ($prospectusSubject->prerequisites->isNotEmpty()) {
            $preRequisites = $prospectusSubject->prerequisites->pluck('id')->toArray();
            $this->preRequisiteSubjects = array_map(fn($value) => (string)$value, $preRequisites);
        }

        $this->toggleViewingSubject();
    }

    public function toggleViewingSubject()
    {
        $this->resetValidation();
        $this->viewingSubject = !$this->viewingSubject;
    }

    public function setSubject(ProspectusSubject $prospectusSubject) { $this->prospectusSubject = $prospectusSubject; }
}
