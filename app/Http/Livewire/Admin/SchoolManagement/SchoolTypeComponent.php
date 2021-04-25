<?php

namespace App\Http\Livewire\Admin\SchoolManagement;

use Livewire\Component;
use App\Models\SchoolType;
use Livewire\WithPagination;

class SchoolTypeComponent extends Component
{
    use WithPagination;

    public ?string $sortField = null;
    public string $search = '';
    public int $paginateValue = 10;
    public bool $sortAsc = false;
    public bool $selectPage = false;
    public bool $selectAll = false;
    public bool $confirmingExport = false;
    public array $checkedTypes = [];

    protected $listeners = ['sortFieldSelected', 'fileExport', 'DeselectPage' => 'updatedSelectPage'];

    public function render()
    {
        return view('livewire.admin.school-management.school-type-component', ['types' => $this->types]);
    }

    public function getTypesProperty()
    {
        return $this->typesQuery->paginate($this->paginateValue);
    }

    public function getTypesQueryProperty()
    {
        $sortField = $this->sortField;

        return SchoolType::search($this->search)->select(['id', 'type', 'created_at'])
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

    public function updatedCheckedUsers()
    {
        $this->selectPage = false;

        $this->selectAll = false;
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selectAll = false;

            $this->checkedTypes = $this->types->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->checkedTypes = [];

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
        return in_array($value, $this->checkedTypes);
    }

    public function selectAll()
    {
        $this->selectPage = false;

        $this->selectAll = true;

        $this->checkedTypes = $this->typesQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function fileExport() 
    {
        $this->confirmingExport = false;

        // return (new UsersExport($this->checkedUsers))->download('users-collection.xlsx');
    }    

    public function paginationView()
    {
        return 'partials.pagination-link';
    }
}
