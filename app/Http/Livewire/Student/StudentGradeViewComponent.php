<?php

namespace App\Http\Livewire\Student;

use App\Models\Status;
use App\Models\SchoolType;
use App\Models\Registration;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithFilters;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\Auth;

class StudentGradeViewComponent extends Component
{
    use WithSorting, WithPagination, WithFilters;

    public int $paginateValue = 10;
    public bool $gradingStudent = false;
    public $typeId = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'typeId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'typeId',
    ];

    protected $allowedSorts = [
        'id',
    ];

    public function render() { return 
        view('livewire.student.student-grade-view-component', ['registrations' => $this->rows]);
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
            ->where('student_id', Auth::user()->student->id)
            ->whereIn('status_id', $statuses)
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
            ->when(!empty($this->typeId), function ($query) {
                return $query->whereHas('prospectus.level.schoolType', function($query) {
                    return $query->where('id', $this->typeId);
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });
    }

    public function getTypesProperty() { return
        SchoolType::get(['id', 'type']);
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function updatingTypeId() { $this->resetPage(); }

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}
