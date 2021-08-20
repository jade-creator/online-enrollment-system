<?php

namespace App\Http\Livewire\Admin\GradeComponent;

use App\Models\Grade;
use App\Models\Registration;
use App\Models\SchoolType;
use App\Models\Status;
use App\Services\Remarks;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class GradeViewComponent extends Component
{
    use WithSorting, WithPagination, WithFilters;

    public Grade $grade;
    public int $paginateValue = 10;
    public bool $gradingStudent = false;
    public int $subjectGrade = 0;
    public string $subjectCode = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
    ];

    protected $updatesQueryString = [
        'search',
    ];

    protected $allowedSorts = [
        'id',
    ];

    public function rules()
    {
        return [
            'grade.value' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function mount()
    {
        $this->fill(['grade' => new Grade()]);
    }

    public function render() { return
        view('livewire.admin.grade-component.grade-view-component', ['registrations' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        $statuses = Status::whereIn('name', ['enrolled', 'released'])->get();
        $statuses = $statuses->pluck('id')->toArray();

        return Registration::search($this->search)
            ->select(['id', 'isNew', 'status_id', 'section_id', 'student_id', 'prospectus_id', 'created_at'])
            ->with([
                'student.user.person',
                'status:id,name',
                'section:id,name',
                'prospectus:id,level_id',
                'prospectus.level:id,level,school_type_id',
                'prospectus.level.schoolType:id',
                'grades:id,registration_id,subject_id,mark_id,value',
                'grades.subject:id,code,title',
                'grades.mark:id,name',
            ])
            ->when(!empty($this->search), function($query) {
                return $query->orWhereHas('student', function($query) {
                            return $query->where('custom_id', 'LIKE', '%'.$this->search.'%');
                        })
                        ->orWhereHas('student.user.person', function($query) {
                            return $query->where('firstname', 'LIKE', '%'.$this->search.'%')
                                ->orWhere('middlename', 'LIKE', '%'.$this->search.'%')
                                ->orWhere('lastname', 'LIKE', '%'.$this->search.'%');
                        });
            })
            ->whereIn('status_id', $statuses)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });
    }

    public function save()
    {
        $this->validate();

        $this->grade->mark_id = (new Remarks())->getMark($this->grade->value);
        $this->grade->save();
        $this->fill(['gradingStudent' => false]);

        $this->dispatchBrowserEvent('swal:success', [
            'text' => "The student's grade has been updated.",
        ]);
    }

    public function addGrade(Grade $grade)
    {
        $this->resetValidation();
        $this->fill([
            'subjectCode' => $grade->subject->code,
            'grade' => $grade,
            'gradingStudent' => true,
        ]);
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function updatingTypeId() { $this->resetPage(); }

    public function paginationView() { return
        'partials.pagination-link';
    }
}
