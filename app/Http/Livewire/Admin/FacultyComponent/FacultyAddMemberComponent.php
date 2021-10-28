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
        return User::select(['id', 'name', 'role_id', 'person_id'])
            ->with([
                'person',
                'employee',
                'role',
            ])
            ->when(filled($this->search), function ($query) {
                $query->whereHas('person', function ($query) {
                    $query->where('firstname', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('middlename', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('lastname', 'LIKE', '%'.$this->search.'%');
                });
            })
            ->whereHas('employee', function ($query) { $query->whereNull('faculty_id'); })
            ->whereIn('role_id', [4,5]);
    }

    public function save()
    {
        if (empty($this->selected)) return $this->emit('no-selected');

        $this->toggleAddingMembers();
        try {
            (new FacultyMemberService())->add($this->faculty->id, $this->selected);

            $this->emitUp('sessionFlashAlert', 'alert', 'success', $this->faculty->name.' has been updated.');
        } catch (\Exception $e) {
            $this->emitUp('sessionFlashAlert', 'alert', 'danger', $e->getMessage());
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
