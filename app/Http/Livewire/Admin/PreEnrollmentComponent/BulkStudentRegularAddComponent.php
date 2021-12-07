<?php

namespace App\Http\Livewire\Admin\PreEnrollmentComponent;

use App\Models;
use App\Services\Registration\RegistrationRegularService;
use App\Services\Registration\RegistrationService;
use App\Traits\WithBulkActions;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Livewire\WithPagination;

class BulkStudentRegularAddComponent extends Component
{
    use WithSweetAlert, WithBulkActions, WithPagination;

    public Models\Section $section;
    public ?Models\Section $assignedSection = null;
    public Models\Prospectus $prospectus;
    public Models\Curriculum $curriculum;
    public string $prospectusSlug = '', $prospectusId = '', $type = 'Regular', $curriculumCode = '', $sectionId = '';
    public int $paginateValue = 10;
    public array $originalSelected = [];
    public bool $selectingSection = false;
    public $sections;
    public $route;

    protected $queryString = [
        'selected' => [
            'except' => [],
            'as' => 's',
        ],
    ];

    protected $listeners = [
        'DeselectPage' => 'updatedSelectPage',
        'refresh' => '$refresh',
        'sessionFlashAlert',
        'selectSection'
    ];

    protected $messages = [
        'sectionId.required' => 'The section field cannot be empty.',
    ];

    public function rules() {
        return [
            'sectionId' => ['required']
        ];
    }

    public function mount()
    {
        list($this->prospectusId, $this->curriculumCode) = explode( '-', $this->prospectusSlug);

        $this->curriculum = Models\Curriculum::where('code', $this->curriculumCode)->firstOrFail();

        $this->fill([
            'route' => url()->previous(),
            'originalSelected' => $this->selected,
            'prospectus' => Models\Prospectus::with([
                    'program:id,code',
                    'level:id,level',
                    'term:id,term',
                    'subjects' => function($query) {
                        $query->where('curriculum_id', $this->curriculum->id);
                    },
                    'subjects.prerequisites',
                    'subjects.corequisites',
                ])->findOrFail($this->prospectusId),
        ]);

        $this->sections = $this->prospectus->sections;
    }

    public function render()
    {
        return view('livewire.admin.pre-enrollment-component.bulk-student-regular-add-component', [
            'students' => $this->rows,
        ]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Student::with('user.person')->whereIn('id', $this->originalSelected);
    }

    public function toggleModal()
    {
        $this->fill(['selectingSection' => ! $this->selectingSection]);
    }

    public function proceed()
    {
        $this->validate();

        $this->fill([
            'assignedSection' => $this->sections->first(function ($section) {
                return (int) $section->id === (int) $this->sectionId;
            })
        ]);

        $this->toggleModal();

        $this->save();
    }

    public function selectSection()
    {
        $this->toggleModal();
    }

    public function checkSubjectsAvailability()
    {
        $this->fill([
            'assignedSection' => $this->sections->first(function ($section) {
                return $section->name === $this->section->name;
            })
        ]);

        return (new RegistrationService())->arrayMatches($this->prospectus->subjects->pluck('id')->toArray(),
            $this->assignedSection->schedules->pluck('prospectus_subject_id')->toArray());
    }

    public function save()
    {
        try {
            if (! $this->checkSubjectsAvailability()) {
                $message = is_null($this->assignedSection) ? 'No section found. ' : 'Some subjects are not available in '.$this->assignedSection->name.'. ';
                return $this->confirm('selectSection', $message.'Do you want to assign the students to another section?');
            }

            $batch = (new RegistrationRegularService())->registerRegularStudents($this->prospectus, $this->assignedSection, auth()->user()->id,
                $this->curriculum->id, $this->selected);

            $this->emit('updateBatchId', $batch->id);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->fill([
            'selected' => array(),
            'originalSelected' => array()
        ]);
    }
}
