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
    public bool $confirmingExport = false, $viewRegistrationDetails = false;
    public $statusId = '', $status = '';
    public $studentType = ''; 
    public $prospectus = '', $level = '', $program = '', $strand = '', $term = '';

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
        'statusId',
    ];

    protected $listeners = ['DeselectPage' => 'updatedSelectPage'];

    // public function mount()
    // {
    //     $this->fill([
    //         'registration' => new Registration(),
    //     ]);
    // }

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

    public function viewRegistration($regId)
    {
        $this->registration = Registration::with([
                    'status:id,name',
                    'prospectus:id,level_id,program_id,strand_id,term_id',
                    'prospectus.level:id,level',
                    'prospectus.program:id,code',
                    'prospectus.strand:id,code',
                    'prospectus.term:id,term',
                    'prospectus.subjects',
                ])  
                ->find($regId);
            
        $this->level = $this->registration->prospectus->level->level;
        $this->program = $this->registration->prospectus->program->code ?? '';
        $this->strand = $this->registration->prospectus->strand->code ?? '';
        $this->term = $this->registration->prospectus->term->term ?? '';
        $this->program = $this->program ? ' > ' . $this->program : '';
        $this->strand = $this->strand ? ' > ' . $this->strand : '';
        $this->term = $this->term ? ' > ' . $this->term : '';
        $this->prospectus = $this->level . $this->program . $this->strand . $this->term;

        $this->status = $this->registration->status->name;
        $this->studentType = $this->registration->isNew ? 'Old' : 'New';

        $this->fill([ 'viewRegistrationDetails' => true ]);
    }

    public function back()
    {
        $this->fill([
            'registration' => new Registration(),
            'viewRegistrationDetails' => false,
        ]);
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
