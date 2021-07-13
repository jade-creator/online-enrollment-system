<?php

namespace App\Http\Livewire\Admin\UserComponent;

use App\Models\User;
use Livewire\Component;
use App\Traits\WithSorting;
use App\Exports\UsersExport;
use App\Models\Role;
use Livewire\WithPagination;
use App\Rules\GmailId;
use App\Traits\WithBulkActions;
use App\Traits\WithFilters;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\PasswordValidationRules;

class UserViewComponent extends Component
{
    use WithBulkActions, WithSorting, WithPagination, WithFilters;

    use PasswordValidationRules;
    
    public int $paginateValue = 10;
    public bool $confirmingExport = false, $addingUser = false;
    public $role;
    public $name;
    public $email;
    public $password;   
    public $password_confirmation; 
 
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

    public function rules()
    {
        return [
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new GmailId],
            'password' => $this->passwordRules(),  
        ];
    }

    public function mount()
    {
        $this->fill([ 'user' => new User() ]);
    }

    public function render() { return
        view('livewire.admin.user-component.user-view-component', [ 'users' => $this->rows ]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

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

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->role,
        ]);

        $this->fill([ 'addingUser' => false ]);

        $this->dispatchBrowserEvent('swal:success', [ 
            'text' => "The user has been added.",
        ]);
    }

    public function getRolesProperty() { return
        Role::get(['id', 'name']);
    }

    public function updatingRole() { $this->resetPage(); }

    public function updatingAddingUser()
    {
        $this->fill([
            'role' => '',
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $this->resetValidation();
    }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport()
    {
        $this->confirmingExport = false;
        return (new UsersExport($this->selected))->download('users-collection.xlsx');
    }

    public function paginationView() { return 
        'partials.pagination-link'; 
    }
}