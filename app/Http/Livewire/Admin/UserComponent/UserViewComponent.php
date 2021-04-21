<?php

namespace App\Http\Livewire\Admin\UserComponent;

use App\Models\User;
use Livewire\Component;
use App\Exports\UsersExport;
use Livewire\WithPagination;

class UserViewComponent extends Component
{
    use WithPagination;
    
    public ?string $sortField = null;
    public string $search = '';
    public string $role = '';
    public int $paginateValue = 10;
    public bool $sortAsc = false;
    public bool $selectPage = false;
    public bool $selectAll = false;
    public bool $confirmingExport = false;
    public array $checkedUsers = [];

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
        return User::search($this->search)->select(['id','name', 'email', 'role_id', 'profile_photo_path'])
                ->with('role')
                ->when(!empty($this->role), function ($query) {
                    return $query->where('role_id', $this->role);
                })
                ->when(!is_null($this->sortField), function ($query) {
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

    public function updatedSelectPage(bool $value)
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

    public function sortFieldSelected(?string $field)
    {
        $this->sortField = $field;

        $this->sortAsc = !$this->sortAsc;

        $this->resetPage();
    }

    public function isSelected(int $value)
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