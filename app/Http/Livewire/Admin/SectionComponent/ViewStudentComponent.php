<?php

namespace App\Http\Livewire\Admin\SectionComponent;

use App\Models\Curriculum;
use App\Models\Section;
use App\Services\Prospectus\ProspectusService;
use App\Services\Registration\RegistrationRegularService;
use App\Services\Registration\RegistrationService;
use App\Traits\WithBulkActions;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ViewStudentComponent extends Component
{
    use WithPagination, WithSweetAlert, WithBulkActions;

    public Section $section;
    public int $paginateValue = 10;

    protected $listeners = [
        'bulkStudentsRegistration',
        'DeselectPage' => 'updatedSelectPage',
        'refresh' => '$refresh',
        'sessionFlashAlert'
    ];

    public function render()
    {
        return view('livewire.admin.section-component.view-student-component', [
            'registrations' => $this->rows,
            'curriculum' => Curriculum::findActiveCurriculum($this->section->prospectus->program_id),
        ]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return $this->section->load([
                'prospectus.subjects' => function ($query) {
                    $query->where('curriculum_id', 1);
                },
            ])
            ->registrations()
            ->orderBy('student_id')
            ->enrolled()
            ->with([
                'student.user.person',
                'grades:id,registration_id,subject_id,mark_id,value',
                'grades.mark',
                'section',
                'prospectus.term',
                'classes' => function ($query) {
                    $query->withTrashed()
                        ->with([
                            'employee.user.person'
                        ]);
                },
                'grades.prospectus_subject.subject' => function ($query) { $query->withTrashed(); },
                'extensions.registration.section',
                'extensions.registration.prospectus.term',
                'extensions.registration.classes' => function ($query) {
                    $query->withTrashed()
                        ->with([
                            'employee.user.person'
                        ]);
                },
            ]);
    }

    public function bulkStudentsRegistration()
    {
        try {
            $curriculum = Curriculum::findActiveCurriculum($this->section->prospectus->program_id);

            $studentIds = (new RegistrationRegularService())->filterEligibleStudentIdsForEnrollment($this->selected, $curriculum->id);

            $prospectus = (new ProspectusService())->findNextProspectus($this->section);

            return $this->redirect(route('admin.bulk.students.regular.create', [
                'section' => $this->section,
                'prospectusSlug' => $prospectus->id.'-'.$curriculum->code,
                http_build_query(array(
                    'selected' => $studentIds,
                ))
            ]));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function confirmBulkStudentsRegistration()
    {
        return $this->confirm('bulkStudentsRegistration', "This action will filter students who are eligible for enrollment on the next semester.
         Only those students who have no running balance and don't have any failed subjects will be selected. Click 'OK' to confirm.");
    }
}
