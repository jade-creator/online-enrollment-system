<?php

namespace App\Http\Livewire\Student\RegistrationComponent;

use App\Models;
use App\Traits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire;

class RegistrationIndexComponent extends Livewire\Component
{
    use AuthorizesRequests;
    use Livewire\WithPagination, Traits\WithBulkActions, Traits\WithSorting, Traits\WithFilters, Traits\WithExporting;

    public string $statusId = '';
    public int $paginateValue = 10;

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
        'statusId',
    ];

    protected array $allowedSorts = ['id'];

    public function getListeners() : array
    {
        return [
            'refresh-registration-index-component:'.auth()->user()->id => '$refresh'
        ];
    }

    public function render() { return
        view('livewire.student.registration-component.registration-index-component', ['registrations' => $this->rows]);
    }

    public function getRowsProperty() { return
        $this->rowsQuery->paginate($this->paginateValue);
    }

    public function getRowsQueryProperty()
    {
        return Models\Registration::search($this->search)
            ->filterByStudent(Auth::user()->student->id)
            ->filterByStatus($this->statusId)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->dateFiltered($this->dateMin, $this->dateMax);
    }

    public function getStatusesProperty() { return
        Models\Status::get(['id', 'name']);
    }

    public function updatingStatusId() { $this->resetPage(); }

    public function updatingPaginateValue() { $this->resetPage(); }
}
