<?php

namespace App\Http\Livewire\Admin\PreEnrollmentComponent;

use App\Exports\RegistrationsExport;
use App\Models\Level;
use App\Models\Status;
use App\Models\Registration;
use App\Models\SchoolType;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithFilters;
use App\Traits\WithBulkActions;
use App\Traits\WithSorting;

class PreEnrollmentViewComponent extends Component
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
        'statusId',
    ];

    protected $allowedSorts = [
        'id',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage', 'removeItem'];

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
        return Registration::search($this->search)
            ->select(['id', 'isNew', 'status_id', 'section_id', 'student_id', 'isRegular', 'prospectus_id', 'created_at', 'released_at'])
            ->with([
                'student.user.person',
                'status:id,name',
                'section:id,name',
                'prospectus:id,level_id,program_id,term_id',
                'prospectus.level:id,level',
                'prospectus.program:id,code,program',
                'prospectus.term:id,term',
            ])
//            ->when(!empty($this->search), function($query) {
//                return $query->orWhereHas('student', function($query) {
//                            return $query->where('custom_id', 'LIKE', '%'.$this->search.'%');
//                        })
//                        ->orWhereHas('student.user.person', function($query) {
//                            return $query->where('firstname', 'LIKE', '%'.$this->search.'%')
//                                ->orWhere('middlename', 'LIKE', '%'.$this->search.'%')
//                                ->orWhere('lastname', 'LIKE', '%'.$this->search.'%');
//                        });
//            })
            ->where('isExtension', 0)
            ->whereNull('released_at')
//            ->when(!empty($this->statusId), function ($query) {
//                return $query->where('status_id', $this->statusId);
//            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->when(!is_null($this->dateMin), function($query) {
                return $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]);
            });
    }

    public function removeConfirm(Registration $registration) {
        $this->registration = $registration;

        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'Please note that upon deletion it cannot be retrievable.',
        ]);
    }

    public function removeItem()
    {
        $this->registration->delete();
    }

    public function getStatusesProperty() { return
        Status::get(['id', 'name']);
    }

    public function getLevelsProperty() { return
        Level::get(['id', 'level']);
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function updatingStatusId() { $this->resetPage(); }

    public function updatingTypeId() { $this->resetPage(); }

    public function fileExport()
    {
        $this->confirmingExport = false;
        return (new RegistrationsExport($this->selected))->download('registrations-collection.xlsx');
    }

    public function paginationView() { return
        'partials.pagination-link';
    }
}
