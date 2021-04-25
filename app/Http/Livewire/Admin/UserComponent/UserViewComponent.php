<?php

namespace App\Http\Livewire\Admin\UserComponent;

use App\Models\User;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Exports\UsersExport;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;

class UserViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;
    
    public int $paginateValue = 10;
    public string $role = '';
    public bool $confirmingExport = false;
 
    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
        'role' => [ 'except' => '' ],
    ];

    protected $updatesQueryString = [
        'search',
        'role',
    ];

    protected array $allowedSorts = [
        'name',
        'email',
        'created_at',
    ];

    protected $listeners = ['DeselectPage' =>'updatedSelectPage'];

    public function render()
    {       
        return view('livewire.admin.user-component.user-view-component', [ 'users' => $this->rows ]);
    }

    public function getRowsProperty() { return $this->rowsQuery->paginate($this->paginateValue); }

    public function getRowsQueryProperty()
    {
        return User::search($this->search)
                ->select(['id','name', 'email', 'role_id', 'profile_photo_path'])
                ->with('role')
                ->when(!empty($this->role), 
                    fn ($query) => $query->where('role_id', $this->role))
                ->orderBy($this->sortBy, $this->sortDirection)
                ->when(!is_null($this->dateMin),
                    fn ($query) => $query->whereBetween('created_at', [$this->dateMin, $this->dateMax]));
    }

    public function updatingRole() { $this->resetPage(); } 

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() 
    {
        $this->confirmingExport = false;
        return (new UsersExport($this->selected))->download('users-collection.xlsx');
    }    

    public function paginationView() { return 'partials.pagination-link'; }
}