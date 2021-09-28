<?php

namespace App\Http\Livewire\Admin\UserComponent;

use App\Exports\UsersExport;
use App\Models;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire;

class UserIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting,
        Traits\WithSweetAlert;

    public string $roleId = '';
    public int $paginateValue = 10;

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

    protected array $allowedSorts = [
        'id',
        'name',
        'email',
    ];

    protected $listeners = [
        'refresh' => '$refresh',
        'DeselectPage' => 'updatedSelectPage',
        'fileExport',
        'activate',
        'deactivate',
    ];

    public function render() { return
        view('livewire.admin.user-component.user-index-component', [ 'users' => $this->rows ]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\User::search($this->search)
            ->select(['id','name', 'email', 'role_id', 'profile_photo_path', 'approved_at'])
            ->with('role')
            ->matchWithRole($this->roleId)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function confirmAction(string $action, Models\User $user) {
        return $this->confirm($action, 'Are you sure?', $user);
    }

    public function activate(Models\User $user)
    {
        try {
            $user->approved_at = now();
            $user->update();

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $user->name.' has been activated.',
            ]);
            return redirect(route('admin.users.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function deactivate(Models\User $user)
    {
        try {
            $user->approved_at = null;
            $user->update();

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $user->name.' has been deactivated.',
            ]);
            return redirect(route('admin.users.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getRolesProperty() { return
        Models\Role::get(['id', 'name']);
    }

    public function updatingRoleId() { $this->resetPage(); }

    public function updatingPaginateValue() { $this->resetPage(); }

    public function fileExport() // TODO:
    {
        try {
            return $this->excelFileExport((new UsersExport($this->selected)), 'user-collection.xlsx');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
