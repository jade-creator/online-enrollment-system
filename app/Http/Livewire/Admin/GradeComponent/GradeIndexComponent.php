<?php

namespace App\Http\Livewire\Admin\GradeComponent;

use App\Models;
use App\Traits;
use Livewire;

class GradeIndexComponent extends Livewire\Component
{
    use Livewire\WithPagination, Traits\WithSorting, Traits\WithFilters, Traits\WithSweetAlert;

    public int $paginateValue = 10;

    protected $queryString = [
        'search' => [ 'except' => '' ],
        'dateMin' => [ 'except' => null ],
        'dateMax',
        'sortBy' => [ 'except' => 'created_at' ],
        'sortDirection' => [ 'except' => 'desc' ],
    ];

    protected $updatesQueryString = ['search'];

    protected array $allowedSorts = ['id'];

    protected $listeners = [
        'refresh' => '$refresh',
        'alertParent'
    ];

    public function render() { return
        view('livewire.admin.grade-component.grade-index-component', ['registrations' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        $statuses = Models\Status::enrolledAndReleased()->pluck('id')->toArray();

        return Models\Registration::search($this->search)
            ->with(['extensions.registration.grades', 'prospectus.term:id,term'])
            ->where('isExtension', 0)
            ->withGrades($statuses)
            ->searchByStudent($this->search)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function alertParent(string $type = '', string $message = '')
    {
        session()->flash('alert', [
            'type' => $type,
            'message' => $message,
        ]);

        $this->emit('alert');
    }

    public function updatingPaginateValue() { $this->resetPage(); }
}
