<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models;
use App\Services\Registration\RegistrationIrregularService;
use App\Services\Registration\RegistrationService;
use App\Traits\WithSweetAlert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class IrregularAddComponent extends Component
{
    use AuthorizesRequests, WithSweetAlert;

    public Models\Curriculum $curriculum;
    public Models\Registration $registration;
    public Models\Prospectus $prospectus;
    public array $selected = [], $selectAll = [];
    public string $prospectusSlug, $type = '', $curriculumCode = '';
    public int $prospectusId;
    public $prospectuses;

    public function mount(RegistrationService $registrationService)
    {
        list($this->prospectusId, $this->type, $this->curriculumCode) = explode( '-', $this->prospectusSlug);

        $this->curriculum = Models\Curriculum::where('code', $this->curriculumCode)->firstOrFail();

        $this->prospectus = Models\Prospectus::findOrFail($this->prospectusId);
        $this->prospectuses = Models\Prospectus::with([
                'subjects' => function($query) {
                    return $query->where('curriculum_id', $this->curriculum->id)->get();
                },
                'subjects.prerequisites',
                'subjects.corequisites',
            ])
            ->orderBy('id', 'DESC')->getAllPrecedingProspectuses($this->prospectus, TRUE);

        foreach ($this->prospectuses as $prospectus) {
            $this->selected[] = $registrationService->pluckSubjectsId($prospectus->subjects);
            $this->selectAll[] = TRUE;
        }
    }

    public function render() { return
        view('livewire.student.registration-component.irregular-add-component');
    }

    public function save()
    {
        $this->authorize('register', $this->prospectus);

        try {
            $registration = (new RegistrationIrregularService())->store($this->prospectuses, auth()->user()->student->id, $this->curriculum->id, $this->selected);

            return redirect()->route('pre.registration.view', $registration->id);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function updatedSelected($value, $key) {
        $this->selectAll[$key[0]] = FALSE;
        $this->selected[$key[0]] = array_filter($this->selected[$key[0]]);
    }

    public function updatedSelectAll($value, $key) {
        if (! $value) return $this->selected[$key] = [];

        foreach ($this->prospectuses as $index => $prospectus) {
            if ($key == $index) $this->selected[$key] = (new RegistrationService())->pluckSubjectsId($prospectus->subjects);
        }
    }
}
