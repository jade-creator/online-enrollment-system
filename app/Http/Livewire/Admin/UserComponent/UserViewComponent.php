<?php

namespace App\Http\Livewire\Admin\UserComponent;

use App\Models\User;
use Livewire\Component;
use App\Exports\UsersExport;
use Livewire\WithPagination;

class UserViewComponent extends Component
{
    use WithPagination;
    
    public $search = '';
    public $role = '';
    public $paginateValue = 10;
    public $sortField = null;
    public $sortAsc = false;
    public $usersList;
    public $selectPage = false;
    public $selectAll = false;
    public $checkedUsers = [];
    public $confirmingExport = false;

    protected $listeners = ['sortFieldSelected', 'fileExport', 'DeselectPage' =>'updatedSelectPage'];

    public function render()
    {       
        return view('livewire.admin.user-component.user-view-component', [ 'users' => $this->users ]);
    }

    public function getUsersProperty()
    {
        return $this->usersQuery->paginate($this->paginateValue);
    }

    public function getUsersQueryProperty()
    {
        $role = $this->role;

        $sortField = $this->sortField;

        return User::search($this->search)->select(['id','name', 'email', 'role_id', 'profile_photo_path'])
                ->with('role')
                ->when(!empty($role), function ($query) use ($role) {
                    return $query->where('role_id', $role);
                })
                ->when(!is_null($sortField), function ($query) use ($sortField) {
                    return $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                }, function ($query) {
                    return $query->latest();
                });
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaginateValue()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function updatedCheckedUsers()
    {
        $this->selectPage = false;

        $this->selectAll = false;
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selectAll = false;

            $this->checkedUsers = $this->users->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->checkedUsers = [];

            $this->selectPage = false;

            $this->selectAll = false;
        }
    }

    public function sortFieldSelected($field)
    {
        $this->sortField = $field;

        $this->sortAsc = !$this->sortAsc;

        $this->resetPage();
    }

    public function isSelected($value)
    {
        return in_array($value, $this->checkedUsers);
    }

    public function selectAll()
    {
        $this->selectPage = false;

        $this->selectAll = true;

        $this->checkedUsers = $this->usersQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function fileExport() 
    {
        $this->confirmingExport = false;

        return (new UsersExport($this->checkedUsers))->download('users-collection.xlsx');
    }    

    public function paginationView()
    {
        return 'partials.pagination-link';
    }
}
