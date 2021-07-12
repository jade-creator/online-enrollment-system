<?php

namespace App\Http\Livewire\Student;

use App\Models\Registration;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithFilters;
use App\Traits\WithBulkActions;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\Auth;

class RegistrationViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    public Registration $registration;
    public int $paginateValue = 10;
    public bool $confirmingExport = false;
    public $statusId = '';

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'statusId' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
    ];

    protected $allowedSorts = [
        'id',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    public function render() { return 
        view('livewire.student.registration-view-component', ['registrations' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty() 
    {
        return Registration::search($this->search)
            ->select(['id', 'isNew', 'status_id', 'section_id', 'prospectus_id', 'created_at'])
            ->where('student_id', Auth::user()->student->id)
            ->when(!empty($this->statusId), function ($query) {
                return $query->where('status_id', $this->statusId);
            })
            ->with([
                'status:id,name',
                'section:id,name',
                'prospectus:id,level_id',
                'prospectus.level:id,level'
            ])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });
    }

    public function getStatusesProperty() { return
        Status::get(['id', 'name']);
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        // return (new UsersExport($this->checkedUsers))->download('users-collection.xlsx');
    }    

    public function paginationView() { return 
        'partials.pagination-link'; 
    }

}
