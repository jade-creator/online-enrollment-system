<?php

namespace App\Http\Livewire\Admin\FacultyComponent;

use App\Models\Faculty;
use App\Models\User;
use App\Services\Faculty\FacultyMemberService;
use App\Traits\WithFilters;
use App\Traits\WithSweetAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class FacultyAddMemberComponent extends Component
{
    use AuthorizesRequests;
    use WithPagination, WithFilters, WithSweetAlert;

    public Faculty $faculty;
    public array $selected = [];
    public int $paginateValue = 10;
    public bool $addingMembers = false;

    protected $listeners = [
        'modalAddingMembers',
    ];

    public function render() { return
        view('livewire.admin.faculty-component.faculty-add-member-component', ['users' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return User::select(['id', 'name', 'role_id'])
            ->with([
                'employee',
                'role',
            ])
            ->whereHas('employee', function ($query){
                return $query->whereNull('faculty_id')
                    ->when(filled($this->search), function ($nestedQuery) {
                        return $nestedQuery->where('custom_id', 'LIKE', '%'.$this->search.'%');
                    });
            })
            ->whereIn('role_id', [4,5]);
    }

    public function save()
    {
        if (empty($this->selected)) return $this->addError('selected', 'Please select a member.');

        try {
            (new FacultyMemberService())->add($this->faculty->id, $this->selected);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $this->faculty->name.`'s members has been updated.`,
            ]);
            return redirect(route('admin.faculties.view'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function modalAddingMembers(Faculty $faculty)
    {
        $this->toggleAddingMembers();
        $this->fill([
            'selected' => [],
            'faculty' => $faculty,
        ]);
    }

    public function toggleAddingMembers() {
        $this->resetValidation();
        $this->addingMembers = !$this->addingMembers;
    }
}
