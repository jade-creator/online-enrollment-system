<?php

namespace App\Http\Livewire\Admin\PreEnrollmentComponent;

use App\Exports\RegistrationsExport;
use App\Models\Program;
use App\Models\Registration;
use App\Models\Student;
use App\Traits;
use Livewire;

class PreEnrollmentViewComponent extends Livewire\Component
{
    use Traits\WithBulkActions, Traits\WithSorting, Livewire\WithPagination, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert, Traits\WithArchiving;

    public Registration $registration;
    public int $paginateValue = 10;
    public $statusId = '', $programId = '', $levelId = '', $termId = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'statusId' => [ 'except' => '' ],
        'isArchived' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'statusId',
        'isArchived'
    ];

    protected $allowedSorts = [
        'id',
    ];

    protected $listeners = [
        'DeselectPage' => 'updatedSelectPage',
        'fileExport',
    ];

    public function mount()
    {
        $this->fill([ 'registration' => new Registration() ]);
    }

    public function render() { return
        view('livewire.admin.pre-enrollment-component.pre-enrollment-view-component', ['registrations' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        $query = Registration::search($this->search)
            ->select(['id', 'isNew', 'status_id', 'section_id', 'student_id', 'isRegular', 'prospectus_id', 'custom_id', 'created_at', 'released_at'])
            ->with([
                'student.user.person',
                'status:id,name',
                'section:id,name',
                'prospectus:id,level_id,program_id,term_id',
                'prospectus.level:id,level',
                'prospectus.program:id,code,program',
                'prospectus.term:id,term',
                'assessment'
            ])
            ->when(filled($this->search), function($query) {
                return $query->orWhereHas('student', function($query) {
                            return $query->where('custom_id', 'LIKE', '%'.$this->search.'%');
                        })
                        ->orWhereHas('student.user.person', function($query) {
                            return $query->where('firstname', 'LIKE', '%'.$this->search.'%')
                                ->orWhere('middlename', 'LIKE', '%'.$this->search.'%')
                                ->orWhere('lastname', 'LIKE', '%'.$this->search.'%');
                        });
            })
            ->where('isExtension', 0)
//            ->whereNull('released_at')
            ->filterByStatus($this->statusId)
            ->filterByProgram($this->programId)
            ->filterByLevel($this->levelId)
            ->filterByTerm($this->termId)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });

        return $this->archivingQuery($query, 'released_at');
    }

    public function createNewRegistration()
    {
        $students = Student::all();

        if ($students) {
            session()->flash('alert', [
                'type' => 'info',
                'message' => "Please select a student. Click the option and choose 'register'.",
            ]);
        } else {
            session()->flash('alert', [
                'type' => 'info',
                'message' => 'No student found as of '.date('M d Y'),
            ]);
        }

        return $this->redirect(route('users.students.index'));
    }

    public function getProgramsProperty() { return
        Program::get(['id', 'code']);
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function updatingStatusId() { $this->resetPage(); }

    public function updatingProgramId() { $this->resetPage(); }

    public function updatingLevelId() { $this->resetPage(); }

    public function updatingTermId() { $this->resetPage(); }

    public function fileExport()
    {
        try {
            return $this->excelFileExport((new RegistrationsExport($this->selected)), 'registrations-collection.xlsx');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
